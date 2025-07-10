<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ActivityLogPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create permission for admin guard
        $adminPermission = Permission::firstOrCreate([
            'name' => 'Pegawai Admin',
            'guard_name' => 'admin'
        ]);

        // Create permission for web guard (if not exists)
        $webPermission = Permission::firstOrCreate([
            'name' => 'Pegawai Admin',
            'guard_name' => 'web'
        ]);

        // Assign permission to superadmin role (admin guard)
        $superadminRole = Role::where('name', 'superadmin')->where('guard_name', 'admin')->first();
        if ($superadminRole) {
            $superadminRole->givePermissionTo($adminPermission);
        }

        // Assign permission to admin role (web guard)
        $adminRole = Role::where('name', 'admin')->where('guard_name', 'web')->first();
        if ($adminRole) {
            $adminRole->givePermissionTo($webPermission);
        }

        $this->command->info('Activity Log permissions created successfully!');
    }
} 