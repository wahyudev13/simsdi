@include('components.script-berkas-kepegawaian.orientasi-script', [
    'tableId' => 'tb-orientasi',
    'orientasiRoute' => 'berkas.orientasi.get',
    'orientasiStoreRoute' => 'berkas.orientasi.store',
    'orientasiEditRoute' => 'berkas.orientasi.edit',
    'orientasiUpdateRoute' => 'berkas.orientasi.update',
    'orientasiDestroyRoute' => 'berkas.orientasi.destroy',
    'enablePaging' => false,
    'enableSearch' => false,
    'enableInfo' => false,
    'viewRoutePDF' => '/karyawan/berkas/orientasi/view/',
])
