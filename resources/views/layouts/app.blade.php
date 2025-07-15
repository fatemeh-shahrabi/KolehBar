<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="description" content="برنامه‌ریزی سفر هوشمند با کوله‌بار - کشف مکان‌های جدید و برنامه‌ریزی سفر به راحتی">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script defer src="//unpkg.com/alpinejs" integrity="..." crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('prism/prism.css') }}">
    <script src="{{ asset('prism/prism.js') }}"></script>
    <link rel="icon" href="/logo/koleh.png">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

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
        font-family: 'Dana';
        font-weight: 400;
        font-style: normal;
        src: url('/fonts/DanaFaNum-DemiBold.woff2') format('woff2');
    }
    
    .font-vazir {
        font-family: 'Vazirmatn', sans-serif;
    }
    
    .font-dana {
        font-family: 'Dana', sans-serif;
    }
    
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .place-card {
        transition: all 0.3s ease;
    }
    
    .place-card:hover {
        transform: translateY(-5px);
    }
    
    .btn-primary {
        background-image: linear-gradient(to right, #FF914D, #FFA657);
    }
    
    .btn-primary:hover {
        background-image: linear-gradient(to right, #F68B2D, #FF914D);
    }
</style>
<body class="font-dana antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- <livewire:layout.navigation /> --}}

        {{-- <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif --}}
        <header class="bg-[#A7D7A7] px-4 py-3 shadow-md sticky top-0 z-10">
            <div class="max-w-6xl mx-auto flex items-center justify-between">
                <!-- Left Side: Conversations Button -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('kolak.conversations') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/kolak-avatar.png') }}" alt="Welcome" class="w-10 h-10 rounded-full shadow hover:scale-105 transition-all" />
                    </a>
                    @auth
                        <div class="flex items-center gap-3">
                            <a href="{{ route('dashboard') }}">
                                <button class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-2 rounded-lg font-semibold shadow-md transition-all transform hover:scale-105">
                                    <span>{{ Auth::user()->name }}</span>
                                </button>
                            </a>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-2 rounded-lg font-semibold shadow-md transition-all transform hover:scale-105">
                            ورود / ثبت‌نام
                        </a>
                    @endauth
                </div>
                <!-- Right Side: Welcome Button and User/Login Button -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/koleh.png') }}" alt="Conversations" class="w-10 h-10 rounded shadow hover:scale-105 transition-all" />
                    </a>
                </div>
            </div>
        </header>
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @livewireScripts

</body>

</html>
