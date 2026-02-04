<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\ServiceRequirement;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'slug' => 'izin_ln_ibadah',
                'name' => 'Izin LN: Ibadah Agama',
                'icon' => 'plane',
                'description' => 'Persyaratan Pemberian Izin Perjalanan Ke Luar Negeri Dengan Alasan Penting Untuk Melaksanakan Ibadah Agama',
                'reqs' => [
                    'Surat Permohonan',
                    'Jadwal Perjalanan',
                    'Jaminan Travel',
                    'KTP',
                ],
            ],
            [
                'slug' => 'izin_ln_obat',
                'name' => 'Izin LN: Pengobatan',
                'icon' => 'stethoscope',
                'description' => 'Persyaratan Pemberian Izin Perjalanan ke Luar Negeri Dengan Alasan Penting Untuk Menjalani Pengobatan',
                'reqs' => [
                    'Rujukan Rumah Sakit',
                    'Jadwal Pengobatan',
                    'Keterangan Dokter',
                    'Paspor',
                ],
            ],
            [
                'slug' => 'pj_bupati',
                'name' => 'Penjabat Bupati / Walikota',
                'icon' => 'shield-check',
                'description' => 'Pengusulan Penjabat Bupati/Walikota',
                'reqs' => [
                    'Usulan Gubernur',
                    'Riwayat Hidup',
                    'SK Pangkat',
                ],
            ],
            [
                'slug' => 'izin_ln_keluarga',
                'name' => 'Izin LN: Kepentingan Keluarga',
                'icon' => 'users',
                'description' => 'Persyaratan Pemberian Izin Perjalanan ke Luar Negeri Dengan Alasan Penting Untuk Kepentingan Keluarga',
                'reqs' => [
                    'Keterangan Kondisi',
                    'Bukti Kekerabatan',
                    'Surat Permohonan',
                ],
            ],
            [
                'slug' => 'cuti_kdh',
                'name' => 'Cuti Diluar Tanggungan Negara',
                'icon' => 'file-text',
                'description' => 'Cuti Diluar Tanggungan Negara Bagi KDH dan WKDH',
                'reqs' => [
                    'Surat Permohonan Cuti',
                    'Alasan Cuti',
                    'Jadwal Cuti',
                ],
            ],
            [
                'slug' => 'izin_ln_umum',
                'name' => 'Izin Keluar Negeri',
                'icon' => 'globe',
                'description' => 'Izin Keluar Negeri (Umum)',
                'reqs' => [
                    'Undangan Luar Negeri',
                    'Jadwal Perjalanan',
                    'Surat Tugas',
                ],
            ],
            [
                'slug' => 'izin_kerjasama',
                'name' => 'Izin Kerjasama',
                'icon' => 'briefcase',
                'description' => 'Permohonan Izin Kerjasama Daerah',
                'reqs' => [
                    'Draft MoU',
                    'Kajian Kerjasama',
                    'Profil Mitra',
                ],
            ],
        ];

        foreach ($services as $data) {
            $service = Service::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'icon' => $data['icon'],
                    'is_active' => true,
                ]
            );

            foreach ($data['reqs'] as $index => $req) {
                ServiceRequirement::updateOrCreate(
                    [
                        'service_id' => $service->id,
                        'name' => $req,
                    ],
                    [
                        'is_required' => true,
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}
