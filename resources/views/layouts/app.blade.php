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
    <link rel="stylesheet" href="{{ asset('prism/prism.css') }}">
    <script src="{{ asset('prism/prism.js') }}"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@livewireStyles

</head>
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
<body class="font-dana antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- <livewire:layout.navigation /> --}}

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @livewireScripts

</body>

</html>
