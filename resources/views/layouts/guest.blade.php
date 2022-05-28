<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- LINE AWESOME -->
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

        <!-- Google fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital@1&family=Noto+Sans+JP&display=swap" rel="stylesheet">
    
        <!-- favicon -->
        <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('image/favicon.ico') }}">
    </head>
    <body style="font-family: 'Noto Sans JP';">
        <div class="text-gray-900 antialiased">
            {{ $slot }}
        </div>
    </body>
</html>
