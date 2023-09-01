<?php

namespace Database\Seeders;
use App\Models\MasterBerkas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterBerkasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masterberkas = [
            [
                'kode'=>'001',
                'kategori'=>'pendidikan',
                'nama_berkas' => 'Ijazah Kedokteran'
            ],
            [
                'kode'=>'002',
                'kategori'=>'pendidikan',
                'nama_berkas' => 'Ijazah Kedokteran Spesialis'
            ],
            [
                'kode'=>'003',
                'kategori'=>'pendidikan',
                'nama_berkas' => 'Ijazah S1 Perawat'
            ],
            [
                'kode'=>'004',
                'kategori'=>'pendidikan',
                'nama_berkas' => 'Transkrip Akademik'
            ],
            [
                'kode'=>'005',
                'kategori'=>'ijin',
                'nama_berkas' => 'Surat Tanda Registrasi'
            ],
            [
                'kode'=>'006',
                'kategori'=>'ijin',
                'nama_berkas' => 'Surat Izin Praktik'
            ],
            [
                'kode'=>'007',
                'kategori'=>'identitas',
                'nama_berkas' => 'KTP'
            ],
            [
                'kode'=>'008',
                'kategori'=>'identitas',
                'nama_berkas' => 'KK'
            ],
            [
                'kode'=>'009',
                'kategori'=>'lain',
                'nama_berkas' => 'Berkas Lamaran'
            ],
            [
                'kode'=>'010',
                'kategori'=>'kesehatan',
                'nama_berkas' => 'Test Kesehatan Awal'
            ],
            [
                'kode'=>'011',
                'kategori'=>'kesehatan',
                'nama_berkas' => 'Test Kesehatan Berkala'
            ],
            [
                'kode'=>'012',
                'kategori'=>'kesehatan',
                'nama_berkas' => 'Test Kesehatan Khusus'
            ],
            [
                'kode'=>'013',
                'kategori'=>'kesehatan',
                'nama_berkas' => 'Vaksinasi'
            ],
            [
                'kode'=>'014',
                'kategori'=>'perjanjian',
                'nama_berkas' => 'Kontrak Kerja'
            ],
            [
                'kode'=>'015',
                'kategori'=>'kompetensi',
                'nama_berkas' => 'Sertifikat Pelatihan'
            ],
            [
                'kode'=>'016',
                'kategori'=>'perjanjian',
                'nama_berkas' => 'SK Demosi'
            ],
            [
                'kode'=>'017',
                'kategori'=>'perjanjian',
                'nama_berkas' => 'SK Mutasi'
            ],
            [
                'kode'=>'018',
                'kategori'=>'perjanjian',
                'nama_berkas' => 'SK Rotasi'
            ],
            [
                'kode'=>'019',
                'kategori'=>'orientasi',
                'nama_berkas' => 'Sertifikat Orientasi'
            ],
            [
                'kode'=>'020',
                'kategori'=>'orientasi',
                'nama_berkas' => 'Evaluasi Penilaian Orientasi'
            ],
        ];

        foreach ($masterberkas as $key => $value) {
            MasterBerkas::create($value);
        }
    }
}
