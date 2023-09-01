<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/css/sb-admin-2.min.css') }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        {{-- <div class="row justify-content-center"> --}}

        {{-- <div class="col-xl-10 col-lg-12 col-md-9"> --}}

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                    <div class="col-lg-6">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Login</h1>
                            </div>
                            <div id="error_list"></div>
                            <form class="user" id="form-login">
                                {{-- <form class="user" method="POST" action="{{ route('login.authentication') }}"> --}}
                               
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user username" id="exampleInputEmail"
                                        aria-describedby="emailHelp" placeholder="Username" name="username" id="username">
                                </div>
                                {{-- <div class="form-group">
                                    <input type="password" class="form-control form-control-user password"
                                        id="exampleInputPassword" placeholder="Password" name="password" id="password">
                                </div> --}}
                                <div class="input-group mb-3" id="show_hide_password">
                                    <input type="password" class="form-control form-control-user password" placeholder="Password"  name="password" id="password">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2" style="border-radius: 0px 55px 55px 0px;"> 
                                            <a href="#"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                        </span>
                                    </div>
                                  </div>
                                {{-- <div class="form-group text-center">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="guard_admin" name="guard" class="custom-control-input guard_admin" value="admin">
                                        <label class="custom-control-label" for="guard_admin">Admistrator</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="guard_user" name="guard" class="custom-control-input guard_user" value="web">
                                        <label class="custom-control-label" for="guard_user">Karyawan</label>
                                    </div>
                                </div> --}}
                                {{-- <a href="#" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </a> --}}
                                <button id="btn-login" class="btn btn-primary btn-user btn-block">
                                   Login
                                </button>
                                <button id="btn-login-disabled" class="btn btn-primary btn-user btn-block d-none" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                            </form>
                            {{-- <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- </div>

        </div> --}}

    </div>

    

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/js/sb-admin-2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass( "fa-eye-slash" );
                    $('#show_hide_password i').removeClass( "fa-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass( "fa-eye-slash" );
                    $('#show_hide_password i').addClass( "fa-eye" );
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#btn-login').click(function (e) { 
                e.preventDefault();

                var username = $('.username').val();
                var password = $('.password').val();
                //var guardchecked = $("input[name='guard']:checked").val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('login.authentication') }}",
                    // contentType: false,
                    // processData: false,
                    cache: false,
                    data: {
                        'username': username,
                        'password': password,
                        //'guard' : guardchecked,
                        '_token': "{{ csrf_token() }}",
                    },
                    dataType: "json",
                    beforeSend:function(){
                       $('#btn-login').addClass("d-none");
                       $('#btn-login-disabled').removeClass("d-none");
                    },
                    success: function(response) {
                    if (response.status == 400) {
                        $('#error_list').html("")
                        $('#error_list').addClass("alert alert-danger")
                        $('#error_list').removeClass("d-none")

                        $.each(response.error, function(key, error_value) {
                            $('#error_list').append('<li>' + error_value +
                                '</li>');
                        });

                        $('#btn-login').removeClass("d-none");
                        $('#btn-login-disabled').addClass("d-none");
                    }else if(response.status == 401){
                        $('#error_list').html("")
                        $('#error_list').addClass("alert alert-danger")
                        $('#error_list').removeClass("d-none")
                        // $('#error_list').removeClass("d-none")
                        $('#error_list').text(response.message)
                        $('#btn-login').removeClass("d-none");
                        $('#btn-login-disabled').addClass("d-none");
                    }else {
                        $('#error_list').html("")
                        $('#error_list').removeClass("alert-danger")
                        $('#error_list').removeClass("alert-primary")
                        $('#error_list').removeClass("alert-warning")
                        $('#error_list').addClass("alert alert-success")
                        // $('#error_list').removeClass("d-none")
                        $('#error_list').text(response.message)
                        window.location = "{{ route('dashboard.index') }}";
                    }
                        // if (response.success == true) {
                        //     window.location = "{{ route('dashboard.index') }}";
                        // } else {
                        //     console.log(response.success);

                        // }
                        // console.log(response);
                    }
                });
            });
                
           
        });
    </script>

</body>

</html>
