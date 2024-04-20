<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') || {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.include')
    @yield('css')

</head>
<body class="sidebar-fixed">
<div class="container-scroller">

    {{-- header --}}
    @include('layouts.header')

    <div class="container-fluid page-body-wrapper">


        @include('layouts.main-sidebar.acadimy-sidebar')

            <div class="main-panel">

                @yield('content')

            </div>

        @include('layouts.footer')

    </div>

</div>

@include('layouts.footer_js')

{{-- After Update Notes Modal --}}
{{-- @include('after-update-note-modal') --}}


@yield('js')

@yield('script')

</body>

</html>
