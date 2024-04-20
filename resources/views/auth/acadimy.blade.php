<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('Teacher') }} || {{ config('app.name') }}</title>

    @include('layouts.include')

</head>

<body>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
            <div class="row flex-grow">
                <div class="col-lg-4 mx-auto">

                    <div class="auth-form-light text-left p-5">

                        <div class="brand-logo text-center">
                            <img src="{{ env('LOGO2') ? url(Storage::url(env('LOGO2'))) :url('assets/logo.svg') }}" alt="logo">
                        </div>
                        <form action="{{ route('acadimic.login') }}" id="frmLogin" method="POST" class="pt-3">
                            @csrf
                            <div class="form-group">
                                <label>{{ __('email') }}</label>
                                {{-- <input type="text" name="username" required class="form-control form-control-lg" placeholder="{{__('username')}}"> --}}
                                <input id="email" type="email" class="form-control form-control-lg" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ __('email') }}">
                            </div>
                            <div class="form-group">
                                <label>{{ __('password') }}</label>
                                {{-- <input type="password" name="password" required class="form-control form-control-lg" placeholder="{{__('password')}}"> --}}

                                <div class="input-group">
                                    <input id="password" type="password" class="form-control form-control-lg" name="password" required autocomplete="current-password" placeholder="{{ __('password') }}">
                                    <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-eye-slash" id="togglePassword"></i>
                                            </span>
                                    </div>
                                </div>
                            </div>

                            @if (Route::has('password.request'))
                                <div class="my-2 d-flex justify-content-end align-items-center">

                                    <a class="auth-link text-black" href="{{ route('password.request') }}">
                                        {{ __('forgot_password') }}
                                    </a>
                                </div>
                            @endif
                            <div class="mt-3">
                                <div class="col-md-12">
                                    <button class="btn btn-block btn-success mt-2" id="superadmin_btn">Login Acadimy</button>
                                </div>
                            </div>
                        </form>
                        {{-- @if(env('DEMO_MODE')) --}}



                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
</div>

<script src="{{ asset('/assets/js/vendor.bundle.base.js') }}"></script>
<script src="{{ asset('/assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/assets/jquery-toast-plugin/jquery.toast.min.js') }}"></script>

<script type='text/javascript'>
     $("#frmLogin").validate({
         rules: {
             username: "required",
             password: "required",
         },
         success: function(label, element) {
             $(element).parent().removeClass('has-danger')
             $(element).removeClass('form-control-danger')
         },
         errorPlacement: function (label, element) {
             if ($(element).attr("name") == "password"){
                 label.insertAfter(element.parent()).addClass('text-danger mt-2');
             }else{
                 label.addClass('mt-2 text-danger');
                 label.insertAfter(element);
             }
         },
         highlight: function (element, errorClass) {
             $(element).parent().addClass('has-danger')
             $(element).addClass('form-control-danger')
         }
     });

    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

     togglePassword.addEventListener("click", function () {
         const type = password.getAttribute("type") === "password" ? "text" : "password";
         password.setAttribute("type", type);
         // this.classList.toggle("fa-eye");
         if (password.getAttribute("type") === 'password') {
             $('#togglePassword').addClass('fa-eye-slash');
             $('#togglePassword').removeClass('fa-eye');
         } else {
             $('#togglePassword').removeClass('fa-eye-slash');
             $('#togglePassword').addClass('fa-eye');
         }
     });

     @if(env('DEMO_MODE'))
     $('#superadmin_btn').on('click', function (e) {
         $('#email').val('superadmin@gmail.com');
         $('#password').val('superadmin');
         $('#login_btn').attr('disabled', true);
         $(this).attr('disabled', true);
         $('#frmLogin').submit();
     })
     $('#teacher_btn').on('click', function (e) {
         $('#email').val('teacher@gmail.com');
         $('#password').val('teacher123');
         $('#login_btn').attr('disabled', true);
         $(this).attr('disabled', true);
         $('#frmLogin').submit();
     })
     @endif

</script>
</body>

@if (Session::has('error'))
    <script type='text/javascript'>
        $.toast({
            text: '{{ Session::get('error') }}',
            showHideTransition: 'slide',
            icon: 'error',
            loaderBg: '#f2a654',
            position: 'top-right'
        });
    </script>
@endif

{{-- @if ($errors->any())
    @foreach ($errors->all() as $error)
        <script type='text/javascript'>
            $.toast({
                text: '{{ $error }}',
                showHideTransition: 'slide',
                icon: 'error',
                loaderBg: '#f2a654',
                position: 'top-right'
            });
        </script>
    @endforeach
@endif --}}

</html>
