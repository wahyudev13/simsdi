<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'k3',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'sdi',
            'guard_name' => 'web'
        ]);
        Role::create([
            'name' => 'diklat',
            'guard_name' => 'web'
        ]);
    }
}
