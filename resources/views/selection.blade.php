<!DOCTYPE html>
<html lang="fr" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Modèle HTML5" />
    <meta name="description" content="Webmin - Modèle d'administration Bootstrap 4 & Angular 5" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>System Education | Adross</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{URL::asset('images/logo.png')}}" />

    <!-- Police -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Poppins:200,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900">

    <!-- CSS -->
    <link href="{{ URL::asset('section/assets/css/rtl.css') }}" rel="stylesheet">
</head>

<body>

    <div class="wrapper">

        <section class="height-100vh d-flex align-items-center page-section-ptb login"
                 style="background-image: url('{{ asset('section/assets/images/sativa.png')}}');">
            <div class="container">
                <div class="row justify-content-center no-gutters vertical-align">

                    <div style="border-radius: 15px;" class="col-lg-8 col-md-8 bg-white">
                        <div class="login-fancy pb-40 clearfix">
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">Selecter le mode de Connexionn</h3>
                            <div class="form-inline">

                                {{-- <a class="btn btn-default col-lg-3" title="Acadimic" href="{{route('acadimic.login')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/teacher.png')}}">
                                    <div>Academic</div>
                                </a> --}}
                                <a class="btn btn-default col-lg-4" title="School" href="{{url('loginSchool')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/admin.png')}}">
                                    <div>School</div>
                                </a>
                                <a class="btn btn-default col-lg-4" title="Administrator" href="{{url('Admin/login')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/admin.png')}}">
                                    <div>Administratorr</div>
                                </a>
                                <a class="btn btn-default col-lg-4" title="Administrator" href="{{route('teacher.teacher.login')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/admin.png')}}">
                                    <div>Teacher</div>
                                </a>
                            </div>

                        </div>
                    </div><br><br><br>

                      <div style="border-radius: 15px; margin-top:20px; " class="col-lg-8 col-md-8 bg-white text-center">
                        <div class="login-fancy pb-40 clearfix">

                            <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">Download Apps from this Url</h3>
                            <div class="form-inline">

                                <a class="btn btn-default col" title="Acadimic" target="_blank" href="https://drive.google.com/file/d/1JJCuKO5TeGyyFGChxNx_8e_ph9ycZC_6/view?usp=sharing">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('images/logo.png')}}">
                                    <div style="font-weight: bold;">Student App</div>
                                </a>
                                <a class="btn btn-default col" title="School" target="_blank" href="https://drive.google.com/file/d/1zZrpJmTtj2win7Dgc1e9TJ9BvyCTvgkB/view?usp=sharing">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('images/logo.png')}}">
                                    <div style="font-weight: bold;">Gradian App</div>
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
    <!-- jQuery -->
    <script src="{{ URL::asset('section/assets/js/jquery-3.3.1.min.js') }}"></script>
    <!-- Plugins jQuery -->
    <script src="{{ URL::asset('section/assets/js/plugins-jquery.js') }}"></script>
    <!-- Chemin des plugins -->
    <script>
        var plugin_path = 'js/';
    </script>

    <!-- Toastr -->
    @yield('js')
    <!-- Personnalisé -->
    <script src="{{ URL::asset('section/assets/js/custom.js') }}"></script>

</body>

</html>
