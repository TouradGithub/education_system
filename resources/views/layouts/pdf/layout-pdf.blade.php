<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @if(App::getLocale() == 'ar')
        <link rel="stylesheet" href="{{URL::asset('app-assets/css-rtl/bootstrap.css')}}">
    @else
        <link rel="stylesheet" href="{{URL::asset('app-assets/bootstrap.css')}}">
    @endif

    <style>
        .table-export {
            width: 100%;
            border-collapse: collapse;
        }

        .table-export td,
        .table-export th {
            border: 1px solid #555;
            padding: 8px;
        }

        .table-export th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
        }
    </style>

</head>
<body style="background-color: #fff">
@include('layouts.pdf._header-pdf', [
    'wilaya_ar' => $wilaya_ar,
    'wilaya' => $wilaya,
    'moughataa_ar' => $moughataa_ar,
    'moughataa' => $moughataa,
    'commune_ar' => $commune_ar,
    'commune' => $commune,
    'title' => $title,
    'title_ar' => $title_ar
])

<div class="container" style="width: 90%">
    @yield('content')
</div>
</body>
</html>
