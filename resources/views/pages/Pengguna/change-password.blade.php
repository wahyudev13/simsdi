@extends('layouts.app')
@section('title', 'Ubah Password')
{{-- @section('main1', 'active')
@section('main2', 'show')
@section('karyawan', 'active') --}}
@section('body')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Ubah Password</h1>

    <!-- DataTales Example -->
    <div id="success_message"></div>
    <div id="error_list"></div>
    <div class="card shadow mb-4">
        {{-- <div class="card-header py-3">

        </div> --}}
        <div class="card-body">
            <div class="container-fluid mt-4 mb-4">
                <form id="form-password">
                    <input type="hidden" id="id-pengguna" value="{{ $pengguna->id }}" name="id_pengguna">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" value="{{ $pengguna->username }}"
                                readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="passwordold">Password Lama</label>
                            <div class="input-group " id="show_hide_password2">
                                <input type="password" class="form-control" id="passwordold" name="passwordold">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">
                                        <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="passwordnew">Password Baru</label>
                            <div class="input-group " id="show_hide_password">
                                <input type="password" class="form-control" id="passwordnew" name="passwordnew">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">
                                        <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary" id="ganti">Ganti</button>
                </form>
            </div>
            <!-- /.container-fluid -->
        </div>
    </div>
@endsection
@push('custom-scripts')
    <!-- Page level plugins -->
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
            $("#show_hide_password2 a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password2 input').attr("type") == "text") {
                    $('#show_hide_password2 input').attr('type', 'password');
                    $('#show_hide_password2 i').addClass("fa-eye-slash");
                    $('#show_hide_password2 i').removeClass("fa-eye");
                } else if ($('#show_hide_password2 input').attr("type") == "password") {
                    $('#show_hide_password2 input').attr('type', 'text');
                    $('#show_hide_password2 i').removeClass("fa-eye-slash");
                    $('#show_hide_password2 i').addClass("fa-eye");
                }
            });

            //UPDATE 
            $(document).on('click', '#ganti', function(e) {
                e.preventDefault();

                var data = {
                    'id': $('#id-pengguna').val(),
                    'username': $('#username').val(),
                    'passwordold': $('#passwordold').val(),
                    'passwordnew': $('#passwordnew').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "{{ route('profile.ganti_passowrd') }}",
                    data: data,
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 400) {
                            $('#error_list').html("")
                            $('#success_message').addClass("d-none")
                            $('#error_list').addClass("alert alert-danger")
                            $('#error_list').removeClass("d-none")

                            $.each(response.error, function(key, error_value) {
                                $('#error_list').append('<li>' + error_value +
                                    '</li>');
                            });
                        } else if (response.status == 401) {
                            $('#error_list').html("")
                            $('#success_message').addClass("d-none")
                            $('#error_list').addClass("alert alert-danger")
                            $('#error_list').removeClass("d-none")
                            $('#error_list').text(response.error)
                        } else {
                            $('#success_message').html("")
                            $('#error_list').addClass("d-none")
                            $('#success_message').removeClass("d-none")
                            $('#success_message').removeClass("alert-danger")
                            $('#success_message').removeClass("alert-success")
                            $('#success_message').removeClass("alert-warning")
                            $('#success_message').addClass("alert alert-primary")
                            // $('#success_message').removeClass("d-none")
                            $('#success_message').text(response.message)
                        }
                    }
                });

            });
        });
    </script>
@endpush
