<div class="min-h-screen bg-[#E2F4E2] flex flex-col items-center rtl text-right px-2" dir="rtl">
    <!-- Header -->
    <div class="w-full max-w-screen-lg px-4 py-3 bg-[#C0DEBE] flex items-center justify-between shadow-md mb-6 rounded-b-2xl">
        <!-- Icon Buttons -->
        <div class="flex items-center gap-4">

            <button class="w-10 h-10 flex items-center justify-center" aria-label="koleh-bar">
                <img src="{{ asset('images/setting.png') }}" alt="icon" class="w-15 h-15" />
            </button>

            <button class="w-10 h-10 flex items-center justify-center rounded-xl shadow-md hover:scale-105 transition" aria-label="icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            
        </div>

        <!-- Login + Lock Container -->
<div class="flex items-center gap-3">


    <a href="{{ route('login') }}" class=" text-black text-base px-5 py-2 rounded-xl shadow bg-[#A7D7A8] hover:bg-[#5C9562] transition">
        ورود و ثبت‌نام
    </a>

    <button class="w-10 h-10 flex items-center justify-center border border-[#8CC48E] rounded-xl shadow-sm" aria-label="koleh-bar">
        <img src="{{ asset('images/koleh.png') }}" alt="icon" class="w-8 h-8" />
    </button>
    
</div>

    </div>

    @php $hasMessages = $conversation->messages()->exists(); @endphp

    @if (! $hasMessages)
        <!-- Welcome State -->
        <div class="text-center mt-14 mb-6 px-4 max-w-md">
            <div class="w-28 h-28 bg-[#F9A85D] rounded-full mx-auto flex items-center justify-center shadow-lg relative">
                <div class="absolute w-4 h-7 bg-[#FBECD8] rounded-full left-8 top-[3.5rem]"></div>
                <div class="absolute w-4 h-7 bg-[#FBECD8] rounded-full right-8 top-[3.5rem]"></div>
            </div>
            <p class="mt-6 text-[#4A4A4A] text-sm font-medium leading-6">
                من <span class="text-[#F9A85D] font-bold">کولکم</span>، برنامه‌ریز شخصی سفر تو.<br>
                <span class="font-bold">اینجام که بیشتر بشناسمت و کمک کنم تا بتونیم بهترین برنامه سفر را بچینیم.</span>
            </p>
        </div>
    @endif

    <!-- Chat Section -->
    <div class="w-full max-w-xl flex flex-col justify-end grow">
        @if (! $hasMessages)
            <!-- Preset Prompts -->
            <div class="overflow-x-auto mb-4">
                <div class="flex gap-3 min-w-max">
                    @foreach ([
                        'برام چندتا تست شخصیت‌شناسی بفرست',
                        'خودت ازم سوال بپرس جواب بدم',
                        'از چه نظر میخوای من را بشناسی؟'
                    ] as $prompt)
                        <button wire:click="setPrompt('{{ $prompt }}')" class="whitespace-nowrap bg-[#A7D7A8] text-white text-sm px-4 py-2 rounded-xl shadow hover:bg-[#95c299] transition">
                            {{ $prompt }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($hasMessages)
            <!-- Messages -->
            <div class="w-full flex flex-col gap-4 overflow-y-auto max-h-[60vh] px-2 pb-[140px] scrollbar-thin scrollbar-thumb-green-300">
                @foreach ($conversation->messages as $message)
                    <div class="flex {{ $message->sender === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div class="{{ $message->sender === 'user' ? 'bg-white' : 'bg-[#CFEACF]' }} text-[#384943] px-5 py-3 max-w-[75%] rounded-t-2xl {{ $message->sender === 'user' ? 'rounded-bl-2xl' : 'rounded-br-2xl' }} shadow-md text-sm leading-relaxed">
                            <div class="font-bold text-xs mb-1">
                                {{ $message->sender === 'user' ? auth()->user()->name : 'کولک' }}
                            </div>
                            <div class="ai-content">{!! $message->message !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Input -->
    <div class="w-full max-w-xl sticky bottom-0 bg-[#E2F4E2] pt-4 pb-6 z-10">
        <form wire:submit.prevent="sendMessage" class="flex items-center gap-3">
            <div class="flex-1 relative">
                <input wire:model="message_input" type="text"
                       class="w-full bg-[#DDF0DC] text-sm text-right rounded-full border border-[#A8CBA8] px-5 py-3 pr-12 shadow focus:outline-none focus:ring-2 focus:ring-green-400 transition placeholder-[#7C9C7E]"
                       placeholder="درباره خودت بهم بگو..." dir="rtl">
                <div class="absolute left-4 top-1/2 -translate-y-1/2 bg-[#D3E6D1] p-1.5 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#4F7751]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-.552.448-1 1-1h.01c.548 0 .99.444.99.99v.01c0 .548-.442.99-.99.99h-.01a1 1 0 01-1-1z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>

            <button type="submit" class="bg-[#6FA972] hover:bg-[#5C9562] text-white p-3 rounded-full shadow-lg transition flex items-center justify-center" aria-label="ارسال پیام">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
        </form>
    </div>
</div>
