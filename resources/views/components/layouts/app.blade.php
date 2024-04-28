{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
{{-- </head>
<body class="font-sans antialiased">

    <main>
        {{ $slot }}
    </main>

    @livewireScripts
</body> --}}
{{-- </html> --}}
{{-- <!DOCTYPE html> --}}
{{-- <html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat System</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('stylechat.css')}}" >
    @livewireStyles
    @vite(['resources/js/app.js'])


</head>
<body>

    <div class="container">
        <div class="row clearfix">
            <div class="col-lg-12">
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>


    @livewireScripts
</body>
</html> --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Chat System</title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('stylechat.css')}}" >
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            .chat-list-container {
    max-height: 100%; /* Set max height to enable scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
    border: 1px solid #ccc; /* Optional: Add border for visual separation */
    border-radius: 5px; /* Optional: Add border radius */
    padding: 10px; /* Optional: Add padding */
}
.chat-history {
    height: calc(100% - 80px); /* Adjust the height as needed */
    overflow-y: auto; /* Enable vertical scrolling */
    padding: 10px; /* Add padding to the chat history */
}
        </style>
        <title>{{ $title ?? 'Page Title' }}</title>
    </head>
    <body>
        {{ $slot }}
    </body>
    @livewireScripts
</html>
