<?php

namespace Database\Seeders;
use App\Models\Admin;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Admin::create([
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);
        //$admin->hasAllDirectPermissions(Permission::all());
    }
}
