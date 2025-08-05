<!-- Modal Tambah Penilaian -->
<div class="modal fade" id="modal-add-penilaian" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Penilaian Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_penilaian"></div>
                <form method="POST" id="form-tambah-penilaian" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_pegawai_penilaian" value="{{ $pegawai->id }}" name="id_pegawai">
                    <div class="form-group">
                        <label for="tgl-penilaian" class="col-form-label">Tanggal Penilaian <label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl-penilaian" name="tgl_penilaian">
                    </div>
                    <div class="form-group">
                        <label for="dep-penilaian">Unit Kerja <label class="text-danger">*</label></label>
                        <select class="form-select select2 select-departemen" id="dep-penilaian"
                            data-placeholder="Pilih Unit Kerja" name="dep_penilaian">

                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan" class="col-form-label">Jabatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="jabatan" name="jabatan">
                    </div>
                    <div class="form-group">
                        <label for="nilai" class="col-form-label">Total Nilai <label
                                class="text-danger">*</label></label>
                        <input type="number" class="form-control" id="nilai" name="nilai">
                    </div>
                    {{-- <div class="form-group">
                    <label for="ket" class="col-form-label">Keterangan <label
                            class="text-danger">*</label></label>
                    <input type="text" class="form-control" id="ket" name="ket">
                </div> --}}
                    <div class="form-group">
                        <label for="file-penilaian" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-penilaian" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>

                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="add-spk">Simpan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- ./ end Modal -->

<!-- Modal Edit Penilaian -->
<div class="modal fade" id="modal-edit-penilaian" data-backdrop="static" data-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Penilaian Karyawan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="error_list_penilaian_edit"></div>
                <form method="POST" id="form-update-penilaian" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_pegawai_penilaian_edit" name="id_pegawai">
                    <input type="hidden" id="id-penilaian" name="id">
                    <div class="form-group">
                        <label for="tgl-penilaian-edit" class="col-form-label">Tanggal Penilaian <label
                                class="text-danger">*</label></label>
                        <input type="date" class="form-control" id="tgl-penilaian-edit" name="tgl_penilaian">
                    </div>
                    <div class="form-group">
                        <label for="dep-penilaian-edit">Unit Kerja <label class="text-danger">*</label></label>
                        <select class="form-select select2 select-departemen-edit" id="dep-penilaian-edit"
                            data-placeholder="Pilih Unit Kerja" name="dep_penilaian">

                            @foreach ($deparetemen as $item)
                                <option value="{{ $item->dep_id }}">{{ $item->nama }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jabatan-edit" class="col-form-label">Jabatan <label
                                class="text-danger">*</label></label>
                        <input type="text" class="form-control" id="jabatan-edit" name="jabatan">
                    </div>
                    <div class="form-group">
                        <label for="nilai-edit" class="col-form-label">Total Nilai <label
                                class="text-danger">*</label></label>
                        <input type="number" class="form-control" id="nilai-edit" name="nilai">
                    </div>
                    {{-- <div class="form-group">
                    <label for="ket" class="col-form-label">Keterangan <label
                            class="text-danger">*</label></label>
                    <input type="text" class="form-control" id="ket" name="ket">
                </div> --}}
                    <div class="form-group">
                        <label for="file-penilaian-edit" class="col-form-label">File <span
                                class="badge badge-secondary">.pdf</span> <label class="text-danger">*</label></label>
                        <input type="file" class="form-control" id="file-penilaian-edit" name="file">
                        <small>Ukuran maksimal 2MB</small>
                    </div>

                    <p class="text-danger">*Wajib Diisi</p>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" id="edit-penilaian-submit">Update</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- ./ end Modal -->
