@extends('layouts.app')
@section('title', 'Set Aplikasi')
@section('setting', 'active')
@section('setting2', 'show')
@section('aplikasi', 'active')
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Aplikasi</h1>
    {{-- <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
            DataTables documentation</a>.</p> --}}

    <!-- DataTales Example -->
    <div id="message"></div>

    <div class="card shadow mb-4">
        <div class="card-body p-5">
            <form method="POST" id="form-set-aplikasi" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <h4 class="h4 mb-2 text-gray-800">Profile</h4>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$aplikasi->id}}">
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="nama" class="col-form-label">Nama Instansi</label>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group">
                            <input type="text" class="form-control nama" id="nama" name="nama" value="{{$aplikasi->nama_instansi}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="telp" class="col-form-label">Nomor Telepon</label>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group">
                            <input type="number" class="form-control telp" id="telp" name="telp" value="{{$aplikasi->no_telp}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="email" class="col-form-label">Email</label>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group">
                            <input type="text" class="form-control email" id="email" name="email" value="{{$aplikasi->email}}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="alamat" class="col-form-label">Alamat</label>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group">
                            <textarea class="form-control" name="alamat" id="" cols="30" rows="3">{{$aplikasi->alamat}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="logo" class="col-form-label">Logo Instansi</label>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group">
                            <input type="file" class="form-control logo" id="logo" name="logo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                      
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="form-group">
                            <img src="{{asset('/File/Setting/Logo/'.$aplikasi->logo)}}" class="img-thumbnail" alt="..." style="max-width: 20%">
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <h4 class="h4 mb-2 text-gray-800">Notifikasi</h4>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        <label for="logo" class="col-form-label">Waktu Laporan</label>
                    </div>
                    <div class="col-md-6 col-lg-10">
                        <div class="alert alert-secondary" role="alert">
                            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="info-circle" class="svg-inline--fa fa-info-circle fa-w-16 " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" color="grey"><path fill="currentColor" d="M256 8C119.043 8 8 119.083 8 256c0 136.997 111.043 248 248 248s248-111.003 248-248C504 119.083 392.957 8 256 8zm0 110c23.196 0 42 18.804 42 42s-18.804 42-42 42-42-18.804-42-42 18.804-42 42-42zm56 254c0 6.627-5.373 12-12 12h-88c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h12v-64h-12c-6.627 0-12-5.373-12-12v-24c0-6.627 5.373-12 12-12h64c6.627 0 12 5.373 12 12v100h12c6.627 0 12 5.373 12 12v24z"></path></svg>
                            <p class="pl-4 mb-0">Silakan atur waktu kapan email notifikasi Masa berlaku STR dikirimkan ke email Anda.</p> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-lg-2">
                        
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <div class="form-group">
                            <input type="time" class="form-control time" id="time" value="{{$aplikasi->time}}" name="time">
                        </div>
                    </div>
                </div> --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <!-- /.container-fluid -->

@endsection

@push('custom-scripts')
    <script>
        $('#form-set-aplikasi').on('submit', function(e) {
            e.preventDefault();
            var file = $('.logo').val();
            var rename = file.replace("C:\\fakepath\\", "");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var form = $('#form-set-aplikasi')[0];
            var formData = new FormData(form);

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: "{{ route('setting.aplikasi.store') }}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                success: function(response) {
                    if (response.status == 400) {
                        $('#message').html("")
                        $('#message').addClass("alert alert-danger")
                        $('#message').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#message').append('<li>' + error_value +
                                '</li>');
                        });
                    } else {
                        $('#message').html("")
                        $('#message').removeClass("alert-primary")
                        $('#message').removeClass("alert-danger")
                        $('#message').addClass("alert alert-success")
                        $('#message').text(response.message)
                        location.reload();
                       
                    }
                }
            });
        });
    </script>
@endpush

@push('custom-css')
<style>
    svg.svg-inline--fa.fa-info-circle.fa-w-16 {
    width: 14px;
    height: 14px;
    position: absolute;
    top: 17px;
}
</style>
@endpush
