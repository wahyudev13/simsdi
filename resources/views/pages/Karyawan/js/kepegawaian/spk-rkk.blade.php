@include('components.script-berkas-kepegawaian.spk-script', [
    'tableId' => 'tb-spk',
    'spkGetRoute' => 'berkas.spk.get',
    'spkStoreRoute' => 'berkas.spk.store',
    'spkEditRoute' => 'berkas.spk.edit',
    'spkUpdateRoute' => 'berkas.spk.update',
    'spkDestroyRoute' => 'berkas.spk.destroy',
    'modalAdd' => 'modal-add-spk',
    'modalEdit' => 'modal-edit-spk',
    'viewRoutePDF' => '/karyawan/berkas/spk/view/',
])
