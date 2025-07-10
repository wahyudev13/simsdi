<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionResetSeeder extends Seeder
{
    public function run()
    {
        // Hapus data di tabel relasi terlebih dahulu
        DB::table('model_has_permissions')->delete();
        DB::table('role_has_permissions')->delete();
        // Hapus semua permission lama
        DB::table('permissions')->delete();

        $permissions = [
            // USER
            'user-ijazah-view',
            'user-ijazah-create',
            'user-ijazah-edit',
            'user-ijazah-delete',
            'user-transkrip-view',
            'user-transkrip-create',
            'user-transkrip-edit',
            'user-transkrip-delete',
            'user-str-view',
            'user-str-create',
            'user-str-edit',
            'user-str-delete',
            'user-sip-view',
            'user-sip-create',
            'user-sip-edit',
            'user-sip-delete',
            'user-riwayat-view',
            'user-riwayat-create',
            'user-riwayat-edit',
            'user-riwayat-delete',
            'user-kesehatan-view',
            'user-kesehatan-create',
            'user-kesehatan-edit',
            'user-kesehatan-delete',
            'user-vaksin-view',
            'user-vaksin-create',
            'user-vaksin-edit',
            'user-vaksin-delete',
            'user-sertif-view',
            'user-sertif-create',
            'user-sertif-edit',
            'user-sertif-delete',
            'user-orientasi-view',
            'user-orientasi-create',
            'user-orientasi-edit',
            'user-orientasi-delete',
            'user-identitas-view',
            'user-identitas-create',
            'user-identitas-edit',
            'user-identitas-delete',
            'user-menu-access',
            // ADMIN
            'admin-karyawan-view',
            'admin-all-access',
            'admin-karyawan-detail',
            'admin-karyawan-dokumen',
            'admin-karyawan-penilaian',
            'admin-karyawan-dokumen-k3',
            'admin-karyawan-dokumen-diklat',
            'admin-peringatan',
        ];

        foreach ($permissions as $name) {
            DB::table('permissions')->insert([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }
    }
} 