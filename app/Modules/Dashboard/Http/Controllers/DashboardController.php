<?php

namespace App\Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HealthRecord;
use App\Models\Kandang;
use App\Models\Petugas;
use App\Models\ProductionRecord;
use App\Models\Ternak;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = auth()->user();
        $isAdmin = $user->role === 'admin';
        $clientId = $user->client_id;
        $scopeToClient = static function (Builder $query) use ($clientId, $isAdmin): Builder {
            if (! $isAdmin) {
                $query->where('client_id', $clientId);
            }

            return $query;
        };
        $today = today();

        $activeAnimals = $scopeToClient(Ternak::query())
            ->where('status', 'aktif')
            ->count();
        $activeBarnCapacity = $scopeToClient(Kandang::query())
            ->where('status', 'aktif')
            ->sum('kapasitas');
        $capacityPercentage = $activeBarnCapacity > 0
            ? (int) round($activeAnimals / $activeBarnCapacity * 100)
            : 0;

        $productionByType = $scopeToClient(ProductionRecord::query())
            ->whereDate('tgl_produksi', $today)
            ->select('jenis_produksi_id')
            ->selectRaw('SUM(jumlah) as total')
            ->with('jenisProduksi:id,nama,satuan')
            ->groupBy('jenis_produksi_id')
            ->get();

        if ($productionByType->count() === 1) {
            $production = $productionByType->first();
            $productionAmount = rtrim(rtrim(number_format((float) $production->total, 2, ',', '.'), '0'), ',');
            $productionValue = $productionAmount.' '.$production->jenisProduksi->satuan;
            $productionDescription = 'Produksi '.$production->jenisProduksi->nama.' hari ini';
        } elseif ($productionByType->isNotEmpty()) {
            $productionValue = $productionByType->count().' jenis';
            $productionDescription = 'Dicatat dalam beberapa jenis produksi';
        } else {
            $productionValue = '0';
            $productionDescription = 'Belum ada catatan hari ini';
        }

        $todayHealthRecords = $scopeToClient(HealthRecord::query())
            ->whereDate('tgl_pemeriksaan', $today)
            ->count();

        $startDate = $today->copy()->subDays(6);
        $productionTrendTotals = $scopeToClient(ProductionRecord::query())
            ->whereBetween('tgl_produksi', [$startDate->toDateString(), $today->toDateString()])
            ->select('tgl_produksi')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tgl_produksi')
            ->pluck('total', 'tgl_produksi');

        $productionTrend = collect(range(6, 0))
            ->map(function (int $daysAgo) use ($today, $productionTrendTotals): array {
                $date = $today->copy()->subDays($daysAgo);

                return [
                    'date' => $date->translatedFormat('j M'),
                    'total' => (int) ($productionTrendTotals[$date->toDateString()] ?? 0),
                ];
            });

        $speciesComposition = $scopeToClient(Ternak::query())
            ->where('status', 'aktif')
            ->select('jenis_ternak_id')
            ->selectRaw('COUNT(*) as total')
            ->with('jenisTernak:id,nama')
            ->groupBy('jenis_ternak_id')
            ->get();

        $healthRecords = $scopeToClient(HealthRecord::query())
            ->with(['ternak.jenisTernak', 'petugas.user'])
            ->latest('tgl_pemeriksaan')
            ->latest('id')
            ->limit(5)
            ->get();

        $activeStaff = $scopeToClient(Petugas::query())
            ->whereHas('user', fn (Builder $query): Builder => $query->where('status', 'aktif'))
            ->with(['user:id,nama,status', 'jabatan:id,nama'])
            ->limit(5)
            ->get();

        $healthRecordsRoute = match ($user->role) {
            'admin' => 'management.health-records.index',
            'pemilik' => 'owner.health-records.index',
            'petugas' => 'staff.health-records.index',
        };

        $view = match ($user->role) {
            'admin' => 'modules.dashboard.admin.index',
            'pemilik' => 'modules.dashboard.pemilik.index',
            'petugas' => 'modules.dashboard.petugas.index',
        };

        return view($view, compact(
            'activeAnimals',
            'activeBarnCapacity',
            'capacityPercentage',
            'productionValue',
            'productionDescription',
            'todayHealthRecords',
            'productionTrend',
            'speciesComposition',
            'healthRecords',
            'activeStaff',
            'healthRecordsRoute',
        ));
    }
}
