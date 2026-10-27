<?php

namespace App\Modules\Management\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return match ($this->route('resource')) {
            'clients' => ['nama_peternakan' => 'required|string|max:100', 'alamat' => 'required|string|max:255', 'no_telp' => 'required|string|max:20', 'status' => 'required|in:aktif,nonaktif'],
            'users' => ['nama' => 'required|string|max:100', 'username' => 'required|string|max:30', 'password' => 'nullable|string|min:8', 'role' => 'required|in:admin,pemilik,petugas', 'status' => 'required|in:aktif,nonaktif'],
            default => [],
        };
    }
}
