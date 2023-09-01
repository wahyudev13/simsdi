<?php

namespace Database\Seeders;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PenggunnaSeeder extends Seeder
{
    // protected $guard_name = 'web';
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $admin = User::create([
        //     'id_pegawai' => '112',
        //     // 'nik_pegawai' => 'D0000002',
        //     'username' => 'wahyu123',
        //     'email' => 'admin@gmail.com',
        //     'password' => bcrypt('12345678')
        // ]);
        // $admin->assignRole('superadmin');

        $diklat = User::create([
            'id_pegawai' => '115',
            // 'nik_pegawai' => 'D0000003',
            'username' => 'diklat',
            'password'=> bcrypt('12345678')
        ]);
        $diklat->assignRole('diklat');

        $sdi = User::create([
            'id_pegawai' => '116',
            // 'nik_pegawai' => 'D0000004',
            'username' => 'sdi',
            'password'=> bcrypt('12345678')
        ]);
        $sdi->assignRole('sdi');

        $k3 = User::create([
            'id_pegawai' => '117',
            // 'nik_pegawai' => '010101',
            'username' => 'k3',
            'password'=> bcrypt('12345678')
        ]);
        $k3->assignRole('k3');

        $user = User::create([
            'id_pegawai' => '129',
            // 'nik_pegawai' => '010101',
            'username' => 'user',
            'password'=> bcrypt('12345678')
        ]);
        $user->assignRole('user');
        $user->givePermissionTo(Permission::all());

    }
}
