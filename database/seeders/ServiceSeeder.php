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
                'form_fields' => [
                    ['name' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'type' => 'text', 'placeholder' => 'Sesuai KTP', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'negara_tujuan', 'label' => 'Negara Tujuan', 'type' => 'text', 'placeholder' => 'Contoh: Arab Saudi', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'tanggal_berangkat', 'label' => 'Tanggal Berangkat', 'type' => 'date', 'placeholder' => null, 'options_text' => null, 'is_required' => '1'],
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
                'form_fields' => [
                    ['name' => 'nama_pasien', 'label' => 'Nama Pasien', 'type' => 'text', 'placeholder' => 'Nama lengkap pasien', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'nama_rumah_sakit', 'label' => 'Rumah Sakit Tujuan', 'type' => 'text', 'placeholder' => 'Nama RS di luar negeri', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'diagnosa', 'label' => 'Diagnosa Penyakit', 'type' => 'textarea', 'placeholder' => 'Jelaskan singkat diagnosa', 'options_text' => null, 'is_required' => '1'],
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
                'form_fields' => [
                    ['name' => 'nama_calon', 'label' => 'Nama Calon PJ', 'type' => 'text', 'placeholder' => 'Nama lengkap calon penjabat', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'nip', 'label' => 'NIP', 'type' => 'text', 'placeholder' => 'Nomor Induk Pegawai', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'jabatan_asal', 'label' => 'Jabatan Saat Ini', 'type' => 'text', 'placeholder' => 'Jabatan sebelum diangkat', 'options_text' => null, 'is_required' => '1'],
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
                'form_fields' => [
                    ['name' => 'nama_pemohon', 'label' => 'Nama Pemohon', 'type' => 'text', 'placeholder' => 'Nama lengkap', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'hubungan_keluarga', 'label' => 'Hubungan Keluarga', 'type' => 'select', 'placeholder' => 'Pilih hubungan', 'options_text' => 'Orang Tua,Anak,Saudara,Pasangan', 'is_required' => '1'],
                    ['name' => 'keperluan', 'label' => 'Keperluan', 'type' => 'textarea', 'placeholder' => 'Jelaskan keperluan keluarga', 'options_text' => null, 'is_required' => '1'],
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
                'form_fields' => [
                    ['name' => 'nama_pejabat', 'label' => 'Nama Pejabat', 'type' => 'text', 'placeholder' => 'Nama KDH/WKDH', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'lama_cuti', 'label' => 'Lama Cuti (Hari)', 'type' => 'number', 'placeholder' => 'Jumlah hari cuti', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'alasan', 'label' => 'Alasan Cuti', 'type' => 'textarea', 'placeholder' => 'Jelaskan alasan cuti', 'options_text' => null, 'is_required' => '1'],
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
                'form_fields' => [
                    ['name' => 'nama_lengkap', 'label' => 'Nama Lengkap', 'type' => 'text', 'placeholder' => 'Nama sesuai paspor', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'instansi', 'label' => 'Instansi', 'type' => 'text', 'placeholder' => 'Nama instansi asal', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'negara_tujuan', 'label' => 'Negara Tujuan', 'type' => 'text', 'placeholder' => 'Masukkan negara tujuan', 'options_text' => null, 'is_required' => '1'],
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
                'form_fields' => [
                    ['name' => 'nama_kerjasama', 'label' => 'Judul Kerjasama', 'type' => 'text', 'placeholder' => 'Judul MoU/Kerjasama', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'mitra', 'label' => 'Nama Mitra', 'type' => 'text', 'placeholder' => 'Nama pihak mitra kerjasama', 'options_text' => null, 'is_required' => '1'],
                    ['name' => 'durasi', 'label' => 'Durasi Kerjasama', 'type' => 'text', 'placeholder' => 'Contoh: 2 Tahun', 'options_text' => null, 'is_required' => '1'],
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
                    'form_fields' => $data['form_fields'] ?? null,
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