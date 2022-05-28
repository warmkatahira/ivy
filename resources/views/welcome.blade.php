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
        <link href="https://fonts.googleapis.com/css2?family=Fugaz+One&family=Merriweather:ital@1&family=Noto+Sans+JP&family=Noto+Serif+JP&display=swap" rel="stylesheet">
        
        <!-- favicon -->
        <link rel="shortcut icon" type="image/x-icon"  href="{{ asset('image/favicon.ico') }}">
    </head>
    <body class="antialiased" style="font-family: 'Noto Sans JP';">
        <div class="min-h-screen bg-teal-50">
            @if (Route::has('login'))
                <div class="fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">ログイン</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">ユーザー登録</a>
                        @endif
                    @endauth
                </div>
            @endif
            <section class="text-gray-600 body-font">
                <div class="container px-5 py-24 mx-auto flex flex-col">
                    <div class="lg:w-4/6 mx-auto">
                        <div class="rounded-lg h-64 overflow-hidden p-16 text-center">
                            <span class="text-black text-5xl" style="font-family: 'Noto Serif JP';">クラウド棚卸システム</span><br><br>
                            <!-- <span class="text-teal-700 text-6xl" style="font-family: 'Merriweather';">Ivy</span> -->
                            <img src="{{ asset('image/logo.svg') }}" width="100" class="m-auto">
                        </div>
                        <div class="mt-10 p-5 border-t-8 border-teal-700 bg-teal-100" style="font-family: 'Noto Serif JP';">
                            <p class="my-5 text-4xl text-center">棚卸のみに特化したシンプルなシステム</p>
                            <p class="mb-4 text-3xl text-sky-400" style="font-family: 'Fugaz One';"><i class="las la-check"></i>Step 01</p>
                            <p class="ml-7 mb-4 text-2xl">商品と在庫を設定</p>
                            <p class="mb-4 text-3xl text-sky-400" style="font-family: 'Fugaz One';"><i class="las la-check"></i>Step 02</p>
                            <p class="ml-7 mb-4 text-2xl">商品をスキャン</p>
                            <p class="mb-4 text-4xl text-rose-500 text-center">簡単2ステップで棚卸が始められます!</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
