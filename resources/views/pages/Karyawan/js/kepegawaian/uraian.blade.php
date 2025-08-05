@include('components.script-berkas-kepegawaian.uraian-script', [
    'tableId' => 'tb-uraian',
    'uraianRoute' => 'berkas.uraian.get',
    'uraianStoreRoute' => 'berkas.uraian.store',
    'uraianEditRoute' => 'berkas.uraian.edit',
    'uraianUpdateRoute' => 'berkas.uraian.update',
    'uraianDestroyRoute' => 'berkas.uraian.destroy',
    'modalAdd' => 'modal-add-uraian',
    'modalEdit' => 'modal-edit-uraian',
    'viewRoutePDF' => '/karyawan/berkas/uraian-tugas/view/',
])
