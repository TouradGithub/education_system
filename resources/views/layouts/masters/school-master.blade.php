<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') || {{ getSchool()->name }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (App::getLocale() == 'ar')
    <html lang="en" dir="rtl">
    @else
        <html lang="en">
    @endif
    @include('layouts.include')
    @yield('css')

</head>
<body class="sidebar-fixed">
<div class="container-scroller">


    @include('layouts.header-school')

    <div class="container-fluid page-body-wrapper">


        @include('layouts.main-sidebar.school-sidebar')

            <div class="main-panel">

                @yield('content')

            </div>

        @include('layouts.footer')

    </div>

</div>

@include('layouts.footer_js')

{{-- After Update Notes Modal --}}
{{-- @include('after-update-note-modal')--}}


@yield('js')

@yield('script')
<script>
    // setInterval(function() {
    //     $("#notifications_count").load(window.location.href + " #notifications_count");
    //     // $("#unreadNotifications").load(window.location.href + " #unreadNotifications");
    // }, 5000);

</script>

</body>

</html>
