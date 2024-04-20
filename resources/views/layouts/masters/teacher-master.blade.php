<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title') || {{ __('teacher.teacher') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.include')
    @if (App::getLocale() == 'ar')
    <html lang="en" dir="rtl">
    @else
        <html lang="en">
    @endif
    @yield('css')

</head>
<body class="sidebar-fixed">
<div class="container-scroller">

    {{-- header --}}
    @include('layouts.header-teacher')

    <div class="container-fluid page-body-wrapper">


        @include('layouts.main-sidebar.teacher-sidebar')

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
@livewireScripts
</body>

</html>
