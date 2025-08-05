<!-- Modal Tambah Orientasi -->
<div class="modal fade" id="modal-add-orientasi" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Sertifikat / Evaluasi Orientasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_ori"></div>
                <form method="POST" id="form-tambah-orientasi" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai" id="id_pegawai_orientasi" value="{{ $pegawai->id }}"
                        name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_ori" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select" id="nama_file_ori" name="nama_file_ori">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_orientasi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_orientasi" class="col-form-label">Nomor<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="nomor_orientasi" name="nomor_orientasi">
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai" class="col-form-label">Tanggal Mulai<label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai" class="col-form-label">Tanggal Selesai<label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                    </div>
                    <div class="form-group">
                        <label for="file_orientasi" class="col-form-label">File
                            <span class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file_orientasi" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="add_ori">Simpan</button>
                        <button type="submit" class="btn btn-primary d-none" id="add_ori_disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Orientasi -->
<div class="modal fade" id="modal-edit-orientasi" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sertifikat / Evaluasi Orientasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_ori_edit"></div>
                <form method="POST" id="form-edit-orientasi" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai" id="id_pegawai_orientasi_edit" name="id_pegawai">
                    <input type="hidden" class="id_orientasi" id="id_orientasi" name="id_orientasi">
                    <div class="form-group">
                        <label for="nama_file_ori_edit" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select" id="nama_file_ori_edit" name="nama_file_ori">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_orientasi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nomor_orientasi_edit" class="col-form-label">Nomor<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="nomor_orientasi_edit" name="nomor_orientasi">
                    </div>
                    <div class="form-group">
                        <label for="tgl_mulai_edit" class="col-form-label">Tanggal Mulai<label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl_mulai_edit" name="tgl_mulai">
                    </div>
                    <div class="form-group">
                        <label for="tgl_selesai_edit" class="col-form-label">Tanggal Selesai<label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl_selesai_edit" name="tgl_selesai">
                    </div>
                    <div class="form-group">
                        <label for="file_orientasi_edit" class="col-form-label">File
                            <span class="badge badge-secondary">.pdf</span> <label
                                class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file_orientasi_edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="update_ori">Update</button>
                        <button type="submit" class="btn btn-primary d-none" id="update_ori_disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
