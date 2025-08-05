@include('components.script-berkas-kepegawaian.lain-lain-script', [
    'tableId' => 'tb-lainlain',
    'lainLainRoute' => 'berkas.lainlain.get',
    'lainLainStoreRoute' => 'berkas.lainlain.store',
    'lainLainEditRoute' => 'berkas.lainlain.edit',
    'lainLainUpdateRoute' => 'berkas.lainlain.update',
    'lainLainDestroyRoute' => 'berkas.lainlain.destroy',
    'modalAdd' => 'modal-add-lain',
    'modalEdit' => 'modal-edit-lain',
    'viewRoutePDF' => '/karyawan/berkas/lain-lain/view/',
])
