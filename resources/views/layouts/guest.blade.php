<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    </head>

    <!-- <body class="font-sans text-gray-900 antialiased"> -->
    <body style="border: solid 1px red;" class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">        
        <div style="border: solid 1px red;"  class="flex w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
            {{ $slot }}
        </div>
    </body>
</html>
