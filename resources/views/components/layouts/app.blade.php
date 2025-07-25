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
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            @font-face {
                font-family: 'Vazirmatn';
                font-weight: 400;
                font-style: normal;
                src: url('/fonts/Vazirmatn-Regular.woff2') format('woff2');
            }
            @font-face {
                font-family: 'dana';
                font-weight: 400;
                font-style: normal;
                src: url('/fonts/DanaFaNum-DemiBold.woff2') format('woff2');
            }
        
            .font-vazir {
                font-family: 'Vazirmatn', sans-serif;
            }
        
            .font-dana {
                font-family: 'dana', sans-serif;
            }
        </style>
    </head>
    <body class="bg-gray-100 font-dana">
        <header class="flex justify-between items-center p-4">
            <h1 class="text-2xl font-bold">Default Layout</h1>
        </header>
        <p>
            This layout is located in <code>resources/views/components/layouts/app.blade.php</code>
        </p>
        {{ $slot }}
    </body>
</html>
