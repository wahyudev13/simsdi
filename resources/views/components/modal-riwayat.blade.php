<!-- Modal Tambah Riwayat Pekerjaan -->
<div class="modal fade" id="modaladdRiwayat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Dokumen Riwayat Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_rw"></div>
                <form method="POST" id="form-tambah-rw" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai_rw" id="id_pegawai_rw" value="{{ $pegawai->id }}"
                        name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_riwayat_id" class="col-form-label">Nama Dokumen <label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_riwayat_id" id="nama_file_riwayat_id"
                            name="nama_file_riwayat_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_perjanjian as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_rw" class="col-form-label">Nomor <label class="text-danger">*</label></label>
                        <input type="text" class="form-control nomor_rw" id="nomor_rw" name="nomor">
                    </div>
                    <div class="form-group">
                        <label for="tgl_ed" class="col-form-label">Berkalu Sampai</label>
                        <input type="date" class="form-control tgl_ed" id="tgl_ed" name="tgl_ed">
                    </div>
                    <div class="form-group">
                        <label for="pengingat" class="col-form-label">Pengingat</label>
                        <input type="date" class="form-control pengingat" id="pengingat" name="pengingat">
                    </div>
                    <div class="form-group">
                        <label for="filerw" class="col-form-label">File
                            <span class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control filerw" id="filerw" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" id="add_lain">Simpan</button>
                        <button type="submit" class="btn btn-info d-none" id="add_lain_disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Riwayat Pekerjaan -->
<div class="modal fade" id="modaleditRiwayat" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Dokumen Riwayat Pekerjaan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_rw_edit"></div>
                <form method="POST" id="form-edit-riwayat" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id-riwayat-edit" id="id-riwayat-edit" name="id">
                    <input type="hidden" class="id_pegawai_rw_edit" id="id_pegawai_rw_edit"
                        value="{{ $pegawai->id }}" name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_riwayat_id_edit" class="col-form-label">Nama Dokumen <label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_riwayat_id_edit" id="nama_file_riwayat_id_edit"
                            name="nama_file_riwayat_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_perjanjian as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_rw_edit" class="col-form-label">Nomor <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control nomor_rw_edit" id="nomor_rw_edit" name="nomor">
                    </div>
                    <div class="form-group">
                        <label for="tgl_ed_rw_edit" class="col-form-label">Berkalu Sampai</label>
                        <input type="date" class="form-control tgl_ed_rw_edit" id="tgl_ed_rw_edit"
                            name="tgl_ed">
                    </div>
                    <div class="form-group">
                        <label for="pengingat_rw_edit" class="col-form-label">Pengingat</label>
                        <input type="date" class="form-control pengingat_rw_edit" id="pengingat_rw_edit"
                            name="pengingat">
                    </div>
                    <div class="form-group">
                        <label for="filerw" class="col-form-label">File
                            <span class="badge badge-secondary">.pdf</span> <label
                                class="text-danger">*</label></label>
                        <input type="file" class="form-control filerw" id="filerw" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" id="add_lain">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
