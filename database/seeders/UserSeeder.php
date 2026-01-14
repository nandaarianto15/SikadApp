<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'nip' => '199001012020011001',
            'name' => 'Admin SIKAD',
            'email' => 'admin@sikad.kaltimprov.go.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'nip' => '199001022020012002',
            'name' => 'Verifikator SIKAD',
            'email' => 'verifikator@sikad.kaltimprov.go.id',
            'password' => Hash::make('password123'),
            'role' => 'verifikator',
        ]);

        User::create([
            'nip' => '199001032020013003',
            'name' => 'Pemohon SIKAD',
            'email' => 'pemohon@sikad.kaltimprov.go.id',
            'password' => Hash::make('password123'),
            'role' => 'pemohon',
        ]);
    }
}