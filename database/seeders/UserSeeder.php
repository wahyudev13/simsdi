<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@kawankoding.id',
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('admin');

        $staf = User::create([
            'name' => 'User',
            'email' => 'user@kawankoding.id',
            'password' => bcrypt('12345678'),
        ]);

        $staf->assignRole('user');

        $k3 = User::create([
            'name' => 'k3',
            'email' => 'userk3',
            'password' => bcrypt('12345678'),
        ]);

        $k3->assignRole('user','k3');
    }
}
