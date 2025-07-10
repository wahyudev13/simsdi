<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MasterBerkasSeeder::class,
            setAplikasiSeeder::class,
            RoleSeeder::class,
            AdminSeeder::class,
            
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
