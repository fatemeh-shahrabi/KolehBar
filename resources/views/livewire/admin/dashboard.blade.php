<div class="bg-[#D2ECD2] font-dana min-h-screen py-8 px-4">
    
    <div class="max-w-6xl mx-auto space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <!-- Users Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-8 border-r-4 border-blue-500 hover:shadow-lg transition-all transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">کاربران</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $userCount }}</h3>
                        <p class="text-xs text-gray-500 mt-2">تعداد کل کاربران</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <a href="#" class="mt-4 inline-flex items-center text-sm font-semibold text-[#EC9F48] hover:text-[#F68B2D] transition">
                    مشاهده کاربران
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Destinations Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-8 border-r-4 border-green-500 hover:shadow-lg transition-all transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">مقاصد</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $destinationCount }}</h3>
                        <p class="text-xs text-gray-500 mt-2">مقاصد فعال</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('admin.destinations') }}" class="mt-4 inline-flex items-center text-sm font-semibold text-[#EC9F48] hover:text-[#F68B2D] transition">
                    مدیریت مقاصد
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Events Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-8 border-r-4 border-purple-500 hover:shadow-lg transition-all transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">رویدادها</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $eventCount }}</h3>
                        <p class="text-xs text-gray-500 mt-2">کل رویدادها</p>
                    </div>
                    <div class="bg-purple-100 p-4 rounded-full text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('admin.events') }}" class="mt-4 inline-flex items-center text-sm font-semibold text-[#EC9F48] hover:text-[#F68B2D] transition">
                    مدیریت رویدادها
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <!-- Ongoing Events Card -->
            <div class="bg-gradient-to-br from-white to-gray-50 rounded-xl shadow-md p-8 border-r-4 border-yellow-500 hover:shadow-lg transition-all transform hover:scale-105">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">رویدادهای فعال</p>
                        <h3 class="text-3xl font-bold text-gray-800">{{ $ongoingEventsCount }}</h3>
                        <p class="text-xs text-gray-500 mt-2">در حال برگزاری</p>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-3">
                            <div class="bg-[#F59E0B] h-2 rounded-full transition-all" style="width: {{ min(100, ($ongoingEventsCount / max(1, $eventCount)) * 100) }}%"></div>
                        </div>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
                <a href="{{ route('admin.events') }}?statusFilter=ongoing" class="mt-4 inline-flex items-center text-sm font-semibold text-[#EC9F48] hover:text-[#F68B2D] transition">
                    مشاهده رویدادها
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">فعالیت‌های اخیر</h3>
                <a href="#" class="text-sm font-semibold text-[#EC9F48] hover:text-[#F68B2D] flex items-center transition">
                    مشاهده همه
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
            <div class="divide-y divide-gray-200">
                <!-- Activity Item -->
                <div class="p-6 hover:bg-[#E1F4E1] transition-all cursor-pointer rounded-lg mx-4 my-2">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="bg-blue-100 p-3 rounded-full text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800">مقصد جدید اضافه شد</p>
                            <p class="text-sm text-gray-600 mt-1">مسجد جامع اصفهان</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-sm text-gray-600">۲ ساعت پیش</span>
                            <span class="text-xs text-blue-600 bg-blue-100 px-3 py-1 rounded-full mt-2">جدید</span>
                        </div>
                    </div>
                </div>
                <!-- More Activity Item -->
                <div class="p-6 hover:bg-[#E1F4E1] transition-all cursor-pointer rounded-lg mx-4 my-2">
                    <div class="flex items-center space-x-4 space-x-reverse">
                        <div class="flex-shrink-0">
                            <div class="bg-[#A7D7A7] p-3 rounded-full text-gray-800">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-gray-800">رویداد به روز رسانی شد</p>
                            <p class="text-sm text-gray-600 mt-1">جشنواره غذاهای محلی</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <span class="text-sm text-gray-600">۵ ساعت پیش</span>
                            <span class="text-xs text-gray-800 bg-[#A7D7A7] px-3 py-1 rounded-full mt-2">به‌روزرسانی</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>