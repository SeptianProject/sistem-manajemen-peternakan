<?php

namespace Database\Seeders;

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
use Illuminate\Database\Seeder;

class DashboardDemoSeeder extends Seeder
{
    public function run(): void
    {
        $jenisTernak = collect([
            ['nama' => 'Sapi Perah', 'suhu_min' => 37.5, 'suhu_max' => 39.5],
            ['nama' => 'Sapi Potong', 'suhu_min' => 37.5, 'suhu_max' => 39.5],
            ['nama' => 'Kambing', 'suhu_min' => 38.5, 'suhu_max' => 40.5],
        ])->map(fn (array $data): JenisTernak => JenisTernak::create($data));

        $jenisProduksi = collect([
            ['nama' => 'Susu', 'satuan' => 'Liter'],
            ['nama' => 'Telur', 'satuan' => 'Butir'],
            ['nama' => 'Berat Panen', 'satuan' => 'Kg'],
        ])->map(fn (array $data): JenisProduksi => JenisProduksi::create($data));

        $tindakan = collect([
            ['nama' => 'Pemeriksaan Rutin'],
            ['nama' => 'Vaksinasi'],
            ['nama' => 'Pemberian Vitamin'],
        ])->map(fn (array $data): Tindakan => Tindakan::create($data));

        $jabatan = collect([
            ['nama' => 'Petugas Kandang'],
            ['nama' => 'Petugas Kesehatan'],
            ['nama' => 'Petugas Produksi'],
        ])->map(fn (array $data): Jabatan => Jabatan::create($data));

        foreach ([
            [
                'nama_peternakan' => 'Peternakan Sinar Makmur',
                'alamat' => 'Jl. Raya Banyuwangi No. 12',
                'no_telp' => '081234567891',
            ],
            [
                'nama_peternakan' => 'Peternakan Sejahtera Bersama',
                'alamat' => 'Jl. Gunung Ijen No. 8',
                'no_telp' => '081234567892',
            ],
        ] as $clientData) {
            $client = Client::create($clientData + ['status' => 'aktif']);

            User::create([
                'client_id' => $client->id,
                'nama' => 'Pemilik '.$client->nama_peternakan,
                'no_telp' => $client->no_telp,
                'username' => 'pemilik'.$client->id,
                'password' => 'password',
                'role' => 'pemilik',
                'status' => 'aktif',
            ]);

            $kandangs = collect([
                ['nama' => 'Kandang Utama', 'lokasi' => 'Blok A', 'kapasitas' => 20],
                ['nama' => 'Kandang Produksi', 'lokasi' => 'Blok B', 'kapasitas' => 15],
            ])->map(fn (array $data): Kandang => Kandang::create($data + [
                'client_id' => $client->id,
                'status' => 'aktif',
            ]));

            $officers = collect([
                ['nama' => 'Andi Saputra', 'jabatan' => $jabatan->get(0)],
                ['nama' => 'Budi Santoso', 'jabatan' => $jabatan->get(1)],
                ['nama' => 'Citra Lestari', 'jabatan' => $jabatan->get(2)],
            ])->map(function (array $data, int $index) use ($client): Petugas {
                $user = User::create([
                    'client_id' => $client->id,
                    'nama' => $data['nama'],
                    'no_telp' => fake()->numerify('08##########'),
                    'username' => 'petugas'.$client->id.($index + 1),
                    'password' => 'password',
                    'role' => 'petugas',
                    'status' => 'aktif',
                ]);

                return Petugas::create([
                    'client_id' => $client->id,
                    'user_id' => $user->id,
                    'jabatan_id' => $data['jabatan']->id,
                ]);
            });

            $ternak = collect([
                ['kode' => '001', 'jenis' => $jenisTernak->get(0), 'kandang' => $kandangs->get(0), 'kelamin' => 'betina', 'lahir' => '2023-02-14'],
                ['kode' => '002', 'jenis' => $jenisTernak->get(0), 'kandang' => $kandangs->get(0), 'kelamin' => 'betina', 'lahir' => '2023-06-20'],
                ['kode' => '003', 'jenis' => $jenisTernak->get(1), 'kandang' => $kandangs->get(1), 'kelamin' => 'jantan', 'lahir' => '2022-11-05'],
                ['kode' => '004', 'jenis' => $jenisTernak->get(2), 'kandang' => $kandangs->get(1), 'kelamin' => 'betina', 'lahir' => '2024-01-18'],
            ])->map(fn (array $data): Ternak => Ternak::create([
                'client_id' => $client->id,
                'kode' => 'CL'.$client->id.'-'.$data['kode'],
                'jenis_ternak_id' => $data['jenis']->id,
                'kandang_id' => $data['kandang']->id,
                'jenis_kelamin' => $data['kelamin'],
                'tgl_lahir' => $data['lahir'],
                'status' => 'aktif',
            ]));

            foreach ($ternak as $index => $animal) {
                HealthRecord::create([
                    'client_id' => $client->id,
                    'ternak_id' => $animal->id,
                    'petugas_id' => $officers->get($index % $officers->count())->id,
                    'tindakan_id' => $tindakan->get($index % $tindakan->count())->id,
                    'tgl_pemeriksaan' => now()->subDays($index + 1)->toDateString(),
                    'berat_badan' => 280 + ($index * 35),
                    'suhu_badan' => 38.2 + ($index * 0.1),
                    'diagnosa' => 'Kondisi sehat dan perlu pemantauan rutin.',
                ]);

                ProductionRecord::create([
                    'client_id' => $client->id,
                    'ternak_id' => $animal->id,
                    'jenis_produksi_id' => $jenisProduksi->get($index % $jenisProduksi->count())->id,
                    'kandang_id' => $animal->kandang_id,
                    'tgl_produksi' => now()->subDays($index)->toDateString(),
                    'jumlah' => 12 + ($index * 2.5),
                ]);
            }
        }
    }
}
