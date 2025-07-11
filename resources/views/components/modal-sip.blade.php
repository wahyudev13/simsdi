<!-- Modal Tambah SIP -->
<div class="modal fade" id="modaladdSIP" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Surat Izin Praktik (SIP)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_sip"></div>
                <form method="POST" id="form-tambah-sip" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id_pegawai_sip" id="id_pegawai_sip" value="{{ $pegawai->id }}"
                        name="id_pegawai">
                    <div class="form-group">
                        <label for="nama_file_sip_id" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_sip_id" id="nama_file_sip_id" name="nama_file_sip_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_izin as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_sip" class="col-form-label">Nomor SIP<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control no_sip" id="no_sip" name="no_sip">
                    </div>
                    <div class="form-group">
                        <label for="no_reg" class="col-form-label">Nomor Reg STR<label
                                class="text-danger">*</label></label>
                        <select class="form-select select-str" id="no_reg" name="no_reg"></select>
                    </div>
                    <div class="form-group">
                        <label for="filesip" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control filesip" id="filesip" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="add_sip">Simpan</button>
                        <button type="submit" class="btn btn-warning d-none" id="add_sip_disabled" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit SIP -->
<div class="modal fade" id="modaleditSIP" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel"aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Surat Izin Praktik (SIP)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_sip_edit"></div>
                <form method="POST" id="form-edit-sip" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="id-sip-edit" id="id-sip-edit" name="id">
                    <div class="form-group">
                        <label for="nama_file_sip_id_edit" class="col-form-label">Nama Dokumen<label
                                class="text-danger">*</label></label>
                        <select class="custom-select nama_file_sip_id_edit" id="nama_file_sip_id_edit"
                            name="nama_file_sip_id">
                            <option value="" selected>Choose...</option>
                            @foreach ($master_berkas_izin as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_berkas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_sip_edit" class="col-form-label">Nomor SIP<label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control no_sip_edit" id="no_sip_edit" name="no_sip">
                    </div>
                    <div class="form-group">
                        <label for="no_reg_sip_edit" class="col-form-label">Nomor Reg STR<label
                                class="text-danger">*</label></label>
                        <select class="form-select select-str-edit" id="no_reg_sip_edit" name="no_reg"></select>
                    </div>
                    <div class="form-group">
                        <label for="filesip" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span><label class="text-danger">*</label></label>
                        <input type="file" class="form-control filesip" id="filesip" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>
                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning" id="submit_edit_sip">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
