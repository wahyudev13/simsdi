<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\setAplikasi;
class setAplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aplikasi = [
            [
                'nama_instansi'=>'RS PKU Muhammadiyah Sekapuk',
                'no_telp'=> '082330321572',
                'email' => 'skahaart@gmail.com',
                'alamat' => 'Jl. Mangga',
                'logo' => 'no_image.png',
                'time' => '08:00'
            ],
        ];

        foreach ($aplikasi as $key => $value) {
            setAplikasi::create($value);
        }
    }
}
