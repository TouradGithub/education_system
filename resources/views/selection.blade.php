{{-- <!DOCTYPE html>
<html lang="fr" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="Modèle HTML5" />
    <meta name="description" content="Webmin - Modèle d'administration Bootstrap 4 & Angular 5" />
    <meta name="author" content="potenzaglobalsolutions.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion Scolaire</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="images/favicon.ico" />

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
                            @if(session('success'))
                                <div class="alert alert-danger">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <h3 style="font-family: 'Cairo', sans-serif" class="mb-30">Select connection mode</h3>
                            <div class="form-inline">

                                <a class="btn btn-default col-lg-3" title="Acadimic" href="{{route('acadimic.login')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/teacher.png')}}">
                                    <div>Academic</div>
                                </a>
                                <a class="btn btn-default col-lg-3" title="School" href="{{url('loginSchool')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/admin.png')}}">
                                    <div>School</div>
                                </a>
                                <a class="btn btn-default col-lg-3" title="Administrator" href="{{url('Admin/login')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/admin.png')}}">
                                    <div>Administratorr</div>
                                </a>
                                <a class="btn btn-default col-lg-3" title="Administrator" href="{{route('teacher.teacher.login')}}">
                                    <img alt="user-img" width="100px;" src="{{URL::asset('section/assets/images/admin.png')}}">
                                    <div>Teacher</div>
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

</html> --}}

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{route('web.chargilypay.redirect')}}" method="post">
        @csrf
        <input type="submit" placeholder="OK">

    </form>
</body>
</html>
