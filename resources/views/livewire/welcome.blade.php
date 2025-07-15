<div class="bg-[#D2ECD2] font-dana text-gray-800 min-h-screen flex flex-col">
    <!-- Main Content -->
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="text-center py-8 px-4 max-w-2xl mx-auto">
            <h1 class="text-xl font-bold mb-2">سلام دوست ماجراجوم!</h1>
            <p class="text-sm mb-6 text-gray-600">برای دریافت برنامه سفر، روی دکمه پایین کلیک کن تا ماجراجویی‌ رو شروع کنیم!</p>
            <button class="bg-[#FFA657] hover:bg-[#F68B2D] text-white py-3 px-8 rounded-lg font-semibold shadow-md transition-all transform hover:scale-105">
                بزن بریم
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H6M12 5l-7 7 7 7" />
                </svg>
            </button>
        </section>

        <!-- Favorite Places Section -->
        <section class="bg-[#E1F4E1] py-6 px-4">
            <div class="max-w-6xl mx-auto">     
                <div class="flex items-center justify-between mb-6 px-2">
                    <h2 class="text-lg font-bold mb-4 text-[#EC9F48]">مکان‌های محبوب</h2>
                    <a href="#" class="text-sm text-[#EC9F48] font-semibold flex items-center">
                        مشاهده همه
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div> 

                <div class="flex overflow-x-auto scrollbar-hide gap-4 pb-4 -mx-4 px-4">
                    @foreach($featuredDestinations as $destination)
                        <div class="place-card w-72 flex-shrink-0 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all p-4">
                            <div class="bg-gray-200 h-40 rounded-lg mb-4 relative overflow-hidden">
                                @if($destination->image_url)
                                    <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" class="w-full h-full object-cover">
                                @endif
                                <div class="absolute top-2 left-2 bg-white/90 px-2 py-1 rounded-full text-xs font-bold flex items-center">
                                    <img src="{{ asset('images/star.png') }}" alt="star" class="w-4 h-4 ml-1" />
                                    {{ $destination->rating }}
                                </div>
                            </div>
                            <div class="flex justify-between items-start">
                                <h3 class="text-md font-bold">{{ $destination->name }}</h3>
                            </div>
                            <div class="mt-2 space-y-1">
                                <p class="text-xs text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    بهترین زمان: {{ $destination->best_time_to_visit }}
                                </p>
                                <p class="text-xs text-gray-600 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $destination->city }}، {{ $destination->address }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Location Input Section -->
        <section class="py-8 px-4 max-w-2xl mx-auto text-center">
            <h2 class="text-xl font-bold mb-2 text-[#EC9F48]">کجا بریم؟</h2>
            <p class="mb-4 text-sm text-gray-600">فقط کافیه آدرستو وارد کنی تا رویدادهای درحال برگزاری اطرافت رو پیدا کنیم.</p>
            <form class="w-full relative">
                <input 
                    type="text" 
                    placeholder="آدرست را بنویس..." 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition"
                >
                <button type="submit" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-[#EC9F48]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </section>

        <!-- Event List Section -->
        <section class="px-4 max-w-2xl mx-auto">
            <div class="space-y-4">
                @foreach($ongoingEvents as $event)
                    <div class="bg-[#A7D7A7] rounded-lg shadow-sm hover:shadow-md transition p-5 flex items-start gap-4">
                        <div class="bg-gray-200 w-20 h-20 rounded-lg flex-shrink-0">
                            @if($event->image_url)
                                <img src="{{ $event->image_url }}" alt="{{ $event->title }}" class="w-full h-full object-cover rounded-lg">
                            @endif
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-md mb-1">{{ $event->title }}</h3>
                                <span class="bg-[#EC9F48]/10 text-[#EC9F48] text-xs px-2 py-1 rounded-full">در حال برگزاری</span>
                            </div>
                            <p class="text-xs text-gray-600 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $event->destination->city }}، {{ $event->address }}
                            </p>
                            <div class="flex justify-between items-center mt-3">
                                <a href="#" class="text-[#EC9F48] text-sm font-semibold hover:underline flex items-center">
                                    اطلاعات بیشتر
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                                <span class="text-xs text-gray-500">ظرفیت باقی‌مانده: {{ $event->remaining_capacity }} نفر</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center my-6">
                <button class="text-[#EC9F48] text-sm font-semibold flex items-center justify-center mx-auto">
                    نشان دادن همه
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </section>

        <!-- FAQ Section -->
        <section class="bg-[#A7D7A7] py-8 px-4">
            <div class="max-w-2xl mx-auto">
                <h2 class="text-lg font-bold mb-4 text-[#EC9F48]">سوالات متداول</h2>

                <div class="faq-items space-y-4 text-sm">
                    <div class="bg-white/30 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">برنامه سفر چیست؟</h3>
                        <p class="text-gray-700">«برنامه سفر» یعنی یک نقشه یا پلن که مشخص می‌کنه در طول یک سفر، کجاها رو می‌خوای بری، چه کارهایی می‌خوای انجام بدی و چطوری زمانت رو مدیریت می‌کنی.</p>
                    </div>

                    <div class="bg-white/30 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">کولک چیه؟</h3>
                        <p class="text-gray-700">کولک هوش مصنوعی ما (که کوله‌بار باشیم) هست، قابلیت چت و صحبت را باهاش دارید، درواقع کولک بعد از چند سوال که ما براش تعریف کردیم با شما و نوع سفرتون آشنا میشه و بهتون یک برنامه سفر میده.</p>
                    </div>

                    <div class="bg-white/30 p-4 rounded-lg">
                        <h3 class="font-bold mb-2">سرویس کولک کوچک چیست؟</h3>
                        <p class="text-gray-700">در این سرویس بعد از شناخت شما و نوع سفر مورد پسندتون ما فقط یک برنامه سفر برای مقصد مورد نظرتون میدیم.</p>
                    </div>

                    <div class="bg-white/30 p-4 rounded-lg faq-hidden">
                        <h3 class="font-bold mb-2">سرویس کولک همراه چیست؟</h3>
                        <p class="text-gray-700">اگر ۸۶ تومان پرداخت کنید ما فقط یک برنامه سفر بهتون میدیم ولی اگر از سرویس کولک همراه استفاده کنید ما کل یک هفته در کنارتونیم و در طول سفر تمام سوالاتتون را جواب میدیم و چندتا برنامه سفر بهتون میدیم.</p>
                    </div>

                    <div class="bg-white/30 p-4 rounded-lg faq-hidden">
                        <h3 class="font-bold mb-2">آیا سرویس کولک همراه فقط برای یک هفته است؟</h3>
                        <p class="text-gray-700">خیر، شما می‌توانید با پرداخت ۴۰ تومان روزانه به مدت ۱۱ روز و بیشتر استفاده کنید.</p>
                    </div>

                    <div class="bg-white/30 p-4 rounded-lg faq-hidden">
                        <h3 class="font-bold mb-2">آیا می‌تونیم بعد از گرفتن برنامه سفر خودمون همین‌جا توی اپ روش ادیت بزنیم؟</h3>
                        <p class="text-gray-700">ما در دو فرمت یعنی پی‌دی‌اف و به صورت متن بهتون برنامه سفر را میدیم و شما می‌تونین متنی را کپی کنید و بعد توی برنامه‌ی دیگری ادیت بزنید روش ولی توی خود اپ امکانش نیست، مگر اینکه از سرویس کولک همراه استفاده کنید که اونجا هرجایی مشکل داشته باشه به خود کولک که بگید ویرایش می‌کنه براتون.</p>
                    </div>
                </div>

                <div class="text-center mt-6">
                    <button id="faq-toggle" class="text-[#EC9F48] text-sm font-semibold flex items-center justify-center mx-auto">
                        نمایش همه
                        <svg id="faq-icon" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer Section -->
    <footer class="bg-[#D2ECD2] py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-6">
                <h3 class="text-lg font-bold mb-4 justify-center">
                    <img src="{{ asset('images/kolehbar-logo.png') }}" alt="kolehbar-logo" class="h-12 mx-auto" />
                </h3>
                <p class="text-sm text-gray-600 mb-3">کوله‌بار را در شبکه‌های اجتماعی دنبال کنید:</p>
                <div class="flex justify-center gap-4">
                    <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="text-gray-700 bi bi-instagram">
                            <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="text-gray-700 bi bi-linkedin">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 bg-white rounded-full flex items-center justify-center shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" class="text-gray-700 bi bi-telegram">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.287 5.906q-1.168.486-4.666 2.01-.567.225-.595.442c-.03.243.275.339.69.47l.175.055c.408.133.958.288 1.243.294q.39.01.868-.32 3.269-2.206 3.374-2.23c.05-.012.12-.026.166.016s.042.12.037.141c-.03.129-1.227 1.241-1.846 1.817-.193.18-.33.307-.358.336a8 8 0 0 1-.188.186c-.38.366-.664.64.015 1.088.327.216.589.393.85.571.284.194.568.387.936.629q.14.092.27.187c.331.236.63.448.997.414.214-.02.435-.22.547-.82.265-1.417.786-4.486.906-5.751a1.4 1.4 0 0 0-.013-.315.34.34 0 0 0-.114-.217.53.53 0 0 0-.31-.093c-.3.005-.763.166-2.984 1.09"/>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                <div>
                    <h4 class="font-bold mb-2">تماس با ما</h4>
                    <p class="flex items-center gap-2 mb-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        ۰۹۱۲۳۵۰۷۵۷۱
                    </p>
                    <p class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        koleh.barr@gmail.com
                    </p>
                </div>

                <div>
                    <h4 class="font-bold mb-2">شبکه‌های اجتماعی</h4>
                    <p class="mb-1">اینستاگرام: koleh.bar</p>
                    <p>لینکدین: Koleh Bar</p>
                </div>

                <div>
                    <h4 class="font-bold mb-2">پیام‌رسان‌ها</h4>
                    <p class="mb-1">تلگرام: @Kolehbar</p>
                    <p>چنل تلگرام: Kolehbar</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- FAQ Toggle Styles -->
    <style>
        .faq-hidden {
            display: none;
        }
        .faq-items.show-all .faq-hidden {
            display: block;
        }
    </style>

    <!-- FAQ Toggle Script -->
    <script>
        document.getElementById('faq-toggle').addEventListener('click', function() {
            const faqContainer = document.querySelector('.faq-items');
            const buttonText = this.querySelector('span') || this.firstChild;
            const icon = document.getElementById('faq-icon');

            faqContainer.classList.toggle('show-all');

            if (faqContainer.classList.contains('show-all')) {
                buttonText.textContent = 'بستن سوالات';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />';
            } else {
                buttonText.textContent = 'نمایش همه';
                icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />';
            }
        });
    </script>
</div>