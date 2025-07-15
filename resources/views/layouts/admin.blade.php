<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت - {{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
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
    </style>
</head>
<body class="bg-[#D2ECD2] font-dana">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-green-800 text-white p-4">
            <div class="flex items-center space-x-3 p-4 border-b border-green-700">
                <a href="{{ route('welcome') }}">
                    <img src="{{ asset('images/koleh.png') }}" alt="Logo" class="w-10 h-10">
                </a>
                <span class="font-bold">پنل مدیریت</span>
            </div>
            <nav class="mt-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 rounded hover:bg-green-700 @if(request()->routeIs('admin.dashboard')) bg-green-700 @endif">
                    داشبورد
                </a>
                <a href="{{ route('admin.destinations') }}" class="block px-4 py-2 rounded hover:bg-green-700 @if(request()->routeIs('admin.destinations')) bg-green-700 @endif">
                    مدیریت مقاصد
                </a>
                <a href="{{ route('admin.events') }}" class="block px-4 py-2 rounded hover:bg-green-700 @if(request()->routeIs('admin.events')) bg-green-700 @endif">
                    مدیریت رویدادها
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-right px-4 py-2 rounded hover:bg-green-700">
                        خروج
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">

            <main class="p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>