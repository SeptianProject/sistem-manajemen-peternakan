<?php

namespace App\Modules\Management\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\HealthRecord;
use App\Models\Jabatan;
use App\Models\JenisProduksi;
use App\Models\JenisTernak;
use App\Models\Kandang;
use App\Models\Petugas;
use App\Models\ProductionRecord;
use App\Models\Ternak;
use App\Models\Tindakan;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
{
    public const CONFIG = [
        'clients' => [Client::class, 'Peternakan', ['nama_peternakan', 'alamat', 'no_telp', 'status'], ['nama_peternakan' => 'required|string|max:100', 'alamat' => 'required|string|max:255', 'no_telp' => 'required|string|max:20', 'status' => 'required|in:aktif,nonaktif']],
        'users' => [User::class, 'Pengguna', ['client_id', 'nama', 'no_telp', 'username', 'password', 'role', 'status'], ['client_id' => 'nullable|exists:clients,id', 'nama' => 'required|string|max:100', 'no_telp' => 'nullable|string|max:20', 'username' => 'required|string|max:30', 'password' => 'nullable|string|min:8', 'role' => 'required|in:admin,pemilik,petugas', 'status' => 'required|in:aktif,nonaktif']],
        'ternak' => [Ternak::class, 'Ternak', ['kode', 'jenis_ternak_id', 'kandang_id', 'jenis_kelamin', 'tgl_lahir', 'status'], ['kode' => 'required|string|max:30', 'jenis_ternak_id' => 'required|exists:jenis_ternak,id', 'kandang_id' => 'required|exists:kandang,id', 'jenis_kelamin' => 'required|in:jantan,betina', 'tgl_lahir' => 'required|date', 'status' => 'required|in:aktif,terjual,mati']],
        'kandang' => [Kandang::class, 'Kandang', ['nama', 'lokasi', 'kapasitas', 'status'], ['nama' => 'required|string|max:100', 'lokasi' => 'required|string|max:255', 'kapasitas' => 'required|integer|min:1', 'status' => 'required|in:aktif,nonaktif']],
        'health-records' => [HealthRecord::class, 'Rekam Kesehatan', ['ternak_id', 'petugas_id', 'tindakan_id', 'tgl_pemeriksaan', 'berat_badan', 'suhu_badan', 'diagnosa'], ['ternak_id' => 'required|exists:ternak,id', 'petugas_id' => 'required|exists:petugas,id', 'tindakan_id' => 'nullable|exists:tindakan,id', 'tgl_pemeriksaan' => 'required|date', 'berat_badan' => 'required|numeric|min:0', 'suhu_badan' => 'required|numeric|min:0', 'diagnosa' => 'required|string']],
        'production-records' => [ProductionRecord::class, 'Rekam Produksi', ['ternak_id', 'jenis_produksi_id', 'kandang_id', 'tgl_produksi', 'jumlah'], ['ternak_id' => 'required|exists:ternak,id', 'jenis_produksi_id' => 'required|exists:jenis_produksi,id', 'kandang_id' => 'required|exists:kandang,id', 'tgl_produksi' => 'required|date', 'jumlah' => 'required|numeric|min:0']],
        'petugas' => [Petugas::class, 'Petugas', ['user_id', 'jabatan_id'], ['user_id' => 'required|exists:users,id', 'jabatan_id' => 'required|exists:jabatan,id']],
        'jenis-ternak' => [JenisTernak::class, 'Jenis Ternak', ['nama', 'suhu_min', 'suhu_max'], ['nama' => 'required|string|max:50', 'suhu_min' => 'nullable|numeric', 'suhu_max' => 'nullable|numeric']],
        'jenis-produksi' => [JenisProduksi::class, 'Jenis Produksi', ['nama', 'satuan'], ['nama' => 'required|string|max:50', 'satuan' => 'required|string|max:20']],
        'tindakan' => [Tindakan::class, 'Tindakan', ['nama'], ['nama' => 'required|string|max:100']],
        'jabatan' => [Jabatan::class, 'Jabatan', ['nama'], ['nama' => 'required|string|max:50']],
    ];

    public function index(Request $request): View
    {
        $resource = $request->route('resource');
        $this->authorize($resource);
        [$model, $label] = $this->config($resource);
        $items = $this->query($model)->latest()->paginate(10);

        return view('modules.management.index', compact('items', 'resource', 'label'));
    }

    public function create(Request $request): View
    {
        $resource = $request->route('resource');
        $this->authorize($resource);
        [$model, $label, $fields] = $this->config($resource);

        return view('modules.management.form', ['resource' => $resource, 'label' => $label, 'fields' => $fields, 'item' => null, ...$this->lookups($resource)]);
    }

    public function store(Request $request): RedirectResponse
    {
        $resource = $request->route('resource');
        $this->authorize($resource);
        [$model, $label, $fields, $rules] = $this->config($resource);
        $data = $request->validate($this->rules($resource, $rules));
        $this->scopeData($data);
        if ($resource === 'users' && blank($data['password'] ?? null)) {
            $data['password'] = 'password';
        }
        $model::create($data);

        return redirect()->route($this->routeName($resource, 'index'))->with('success', $label.' berhasil ditambahkan.');
    }

    public function edit(Request $request, int $id): View
    {
        $resource = $request->route('resource');
        $this->authorize($resource);
        [$model, $label, $fields] = $this->config($resource);
        $item = $this->query($model)->findOrFail($id);

        return view('modules.management.form', ['resource' => $resource, 'label' => $label, 'fields' => $fields, 'item' => $item, ...$this->lookups($resource)]);
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $resource = $request->route('resource');
        $this->authorize($resource);
        [$model, $label, , $rules] = $this->config($resource);
        $item = $this->query($model)->findOrFail($id);
        $data = $request->validate($this->rules($resource, $rules, true));
        $this->scopeData($data);
        if ($resource === 'users' && blank($data['password'] ?? null)) {
            unset($data['password']);
        }
        $item->update($data);

        return redirect()->route($this->routeName($resource, 'index'))->with('success', $label.' berhasil diperbarui.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $resource = $request->route('resource');
        $this->authorize($resource);
        [$model, $label] = $this->config($resource);
        $this->query($model)->findOrFail($id)->delete();

        return redirect()->route($this->routeName($resource, 'index'))->with('success', $label.' berhasil dihapus.');
    }

    public function reports(): View
    {
        return view('modules.management.reports');
    }

    private function authorize(string $resource): void
    {
        $role = auth()->user()->role;
        $adminResources = ['clients', 'users', 'jenis-ternak', 'jenis-produksi', 'tindakan', 'jabatan'];
        $ownerResources = ['ternak', 'kandang', 'health-records', 'production-records', 'petugas'];
        abort_unless(
            ($role === 'admin' && in_array($resource, $adminResources, true))
            || ($role === 'pemilik' && in_array($resource, $ownerResources, true))
            || ($role === 'petugas' && in_array($resource, ['ternak', 'health-records', 'production-records'], true)),
            403
        );
    }

    private function config(string $resource): array
    {
        abort_unless(isset(self::CONFIG[$resource]), 404);

        return self::CONFIG[$resource];
    }

    private function query(string $model): Builder
    {
        $query = $model::query();
        if (auth()->user()->role !== 'admin' && in_array('client_id', (new $model)->getFillable(), true)) {
            $query->where('client_id', auth()->user()->client_id);
        }

        return $query;
    }

    private function scopeData(array &$data): void
    {
        if (auth()->user()->role !== 'admin') {
            $data['client_id'] = auth()->user()->client_id;
        }
    }

    private function rules(string $resource, array $rules, bool $update = false): array
    {
        if ($resource === 'users') {
            $rules['username'] .= '|'.Rule::unique('users', 'username')->ignore(request()->route('id'));
            $rules['password'] = $update ? 'nullable|string|min:8' : 'required|string|min:8';
        }

        return $rules;
    }

    private function lookups(string $resource): array
    {
        $clientId = auth()->user()->client_id;

        return [
            'clients' => Client::query()->when($clientId, fn ($q) => $q->whereKey($clientId))->get(),
            'users' => User::query()->when($clientId, fn ($q) => $q->where('client_id', $clientId))->get(),
            'ternak' => Ternak::query()->when($clientId, fn ($q) => $q->where('client_id', $clientId))->get(),
            'kandang' => Kandang::query()->when($clientId, fn ($q) => $q->where('client_id', $clientId))->get(),
            'petugas' => Petugas::query()->when($clientId, fn ($q) => $q->where('client_id', $clientId))->get(),
            'jenisTernak' => JenisTernak::all(),
            'jenisProduksi' => JenisProduksi::all(),
            'tindakan' => Tindakan::all(),
            'jabatan' => Jabatan::all(),
        ];
    }

    private function routeName(string $resource, string $action): string
    {
        return 'management.'.$resource.'.'.$action;
    }
}
