<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah permission sudah ada sebelum membuat
        if (!Permission::where('name', 'View Identitas')->exists()) {
            Permission::create(['name' => 'View Identitas']);
        }
        if (!Permission::where('name', 'Tambah Identitas')->exists()) {
            Permission::create(['name' => 'Tambah Identitas']);
        }
        if (!Permission::where('name', 'Edit Identitas')->exists()) {
            Permission::create(['name' => 'Edit Identitas']);
        }
        if (!Permission::where('name', 'Hapus Identitas')->exists()) {
            Permission::create(['name' => 'Hapus Identitas']);
        }
    }
} 