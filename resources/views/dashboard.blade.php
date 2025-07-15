<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>داشبورد کاربری - کوله‌بار</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <header class="bg-[#A7D7A7] px-4 py-3 shadow-md sticky top-0 z-10">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('kolak.conversations') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/kolak-avatar.png') }}" alt="Logo" class="w-10 h-10 rounded-full shadow" />
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
        </div>
    </header>
    <div class="max-w-6xl mx-auto py-8 px-4">
        <div class="bg-white rounded-xl shadow-md p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
                <h1 class="text-2xl font-bold text-gray-800">داشبورد کاربری</h1>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105">
                        خروج از حساب
                    </button>
                </form>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-gradient-to-br from-[#E1F4E1] to-white rounded-xl shadow-md p-6 hover:shadow-lg transition-all transform hover:scale-105">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="bg-[#A7D7A7] p-3 rounded-full text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5v-2a2 2 0 012-2h10a2 2 0 012 2v2h-4m-6 0h.01M12 16h.01" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">مکالمات اخیر</h2>
                            <a href="{{ route('kolak.conversations') }}" class="text-[#EC9F48] hover:text-[#F68B2D] font-semibold flex items-center transition">
                                مشاهده همه مکالمات
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-br from-[#E1F4E1] to-white rounded-xl shadow-md p-6 hover:shadow-lg transition-all transform hover:scale-105">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="bg-[#A7D7A7] p-3 rounded-full text-gray-800">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">تنظیمات حساب</h2>
                            <a href="{{ route('profile') }}" class="text-[#EC9F48] hover:text-[#F68B2D] font-semibold flex items-center transition">
                                ویرایش پروفایل
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(auth()->user()->is_admin)
                <div class="mt-8 bg-gradient-to-br from-[#FEF3C7] to-[#FDE68A] rounded-xl shadow-md p-6 hover:shadow-lg transition-all transform hover:scale-105">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="bg-yellow-200 p-3 rounded-full text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.104-.896-2-2-2s-2 .896-2 2 2 4 2 4 2-2.896 2-4zm0 0c0-1.104-.896-2-2-2s-2 .896-2 2 2 4 2 4 2-2.896 2-4zm0 0c0-1.104-.896-2-2-2s-2 .896-2 2 2 4 2 4 2-2.896 2-4z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-800 mb-2">دسترسی مدیریت</h2>
                            <a href="{{ route('admin.dashboard') }}" class="text-[#EC9F48] hover:text-[#F68B2D] font-semibold flex items-center transition">
                                ورود به پنل مدیریت
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</body>
</html>