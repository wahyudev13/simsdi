<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::create(['name' => 'View Ijazah']);
        Permission::create(['name' => 'Tambah Ijazah']);
        Permission::create(['name' => 'Edit Ijazah']);
        Permission::create(['name' => 'Hapus Ijazah']);
        
        Permission::create(['name' => 'View Transkrip']);
        Permission::create(['name' => 'Tambah Transkrip']);
        Permission::create(['name' => 'Edit Transkrip']);
        Permission::create(['name' => 'Hapus Transkrip']);

        Permission::create(['name' => 'View STR']);
        Permission::create(['name' => 'Tambah STR']);
        Permission::create(['name' => 'Edit STR']);
        Permission::create(['name' => 'Hapus STR']);

        Permission::create(['name' => 'View SIP']);
        Permission::create(['name' => 'Tambah SIP']);
        Permission::create(['name' => 'Edit SIP']);
        Permission::create(['name' => 'Hapus SIP']);

        Permission::create(['name' => 'View Riwayat']);
        Permission::create(['name' => 'Tambah Riwayat']);
        Permission::create(['name' => 'Edit Riwayat']);
        Permission::create(['name' => 'Hapus Riwayat']);

        Permission::create(['name' => 'View Kesehatan']);
        Permission::create(['name' => 'Tambah Kesehatan']);
        Permission::create(['name' => 'Edit Kesehatan']);
        Permission::create(['name' => 'Hapus Kesehatan']);

        Permission::create(['name' => 'View Vaksin']);
        Permission::create(['name' => 'Tambah Vaksin']);
        Permission::create(['name' => 'Edit Vaksin']);
        Permission::create(['name' => 'Hapus Vaksin']);

        Permission::create(['name' => 'View Sertif']);
        Permission::create(['name' => 'Tambah Sertif']);
        Permission::create(['name' => 'Edit Sertif']);
        Permission::create(['name' => 'Hapus Sertif']);

        Permission::create(['name' => 'View Orientasi']);
        Permission::create(['name' => 'Tambah Orientasi']);
        Permission::create(['name' => 'Edit Orientasi']);
        Permission::create(['name' => 'Hapus Orientasi']);
    }
}
