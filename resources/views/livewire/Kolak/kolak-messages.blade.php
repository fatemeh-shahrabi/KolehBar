<div class="min-h-screen bg-[#E2F4E2] flex flex-col items-center rtl text-right px-2" dir="rtl">

    <!-- Welcome Message -->
    @if(!$conversation->messages()->exists())
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

    <!-- Chat Messages Section -->
    <div class="w-full max-w-xl flex flex-col justify-end grow">
        @if($conversation->messages()->exists())
            <div class="w-full flex flex-col gap-4 overflow-y-auto max-h-[60vh] px-2 pb-[140px] scrollbar-thin scrollbar-thumb-green-300">
                @foreach($conversation->messages as $message)
                    <div class="flex {{ $message->sender === 'user' ? 'justify-end text-left' : 'justify-start' }} gap-2 items-end">
                        <!-- Avatar -->
                        @if($message->sender === 'assistant')
                            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border-2 border-[#A7D7A8] shadow-md">
                                <img src="{{ asset('images/kolak-avatar.png') }}" alt="کولک" class="w-full h-full object-cover">
                            </div>
                        @endif
                        
                        <!-- Message Bubble -->
                        <div class="{{ $message->sender === 'user' ? 'bg-white' : 'bg-[#CFEACF]' }} text-[#384943] px-5 py-3 max-w-[75%] rounded-t-2xl {{ $message->sender === 'user' ? 'rounded-br-2xl' : 'rounded-bl-2xl' }} shadow-md text-sm leading-relaxed">
                            <div class="font-bold text-xs mb-1">
                                {{ $message->sender === 'user' ? auth()->user()->name : 'کولک' }}
                            </div>
                            <div class="ai-content">{!! $message->message !!}</div>
                        </div>
                        
                        @if($message->sender === 'user')
                            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0 border-2 border-white shadow-md bg-gray-200 flex items-center justify-center">
                                @if(auth()->check() && auth()->user()->profile_photo_path)
                                    <img src="{{ Storage::url(auth()->user()->profile_photo_path) }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs font-bold text-gray-600">
                                        {{ auth()->check() ? strtoupper(substr(auth()->user()->name, 0, 1)) : '?' }}
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Message Input Section -->
    <div class="w-full max-w-xl sticky bottom-0 bg-[#E2F4E2] pt-4 pb-6 z-10">
        <form wire:submit.prevent="sendMessage" class="flex items-center gap-3">
            <div class="flex-1 relative">
                <input 
                    wire:model="message_input" 
                    type="text"
                    class="w-full bg-[#DDF0DC] text-sm text-right rounded-full border border-[#A8CBA8] px-5 py-3 pr-12 shadow focus:outline-none focus:ring-2 focus:ring-green-400 transition placeholder-[#7C9C7E]"
                    placeholder="درباره خودت بهم بگو..." 
                    dir="rtl"
                >
            </div>

            <div class="flex items-center gap-2">
                <!-- Random Prompt Button -->
                <button 
                    type="button" 
                    wire:click="getRandomPrompt"
                    class="bg-[#F9A85D] hover:bg-[#e6954c] text-white p-3 rounded-full shadow-lg transition flex items-center justify-center"
                    aria-label="پیشنهاد تصادفی"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </button>
            
                <!-- Send Button -->
                <button 
                    type="submit" 
                    class="bg-[#6FA972] hover:bg-[#5C9562] text-white p-3 rounded-full shadow-lg transition flex items-center justify-center" 
                    aria-label="ارسال پیام"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rtl:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('livewire:initialized', () => {
    // Scroll to bottom when new message is sent
    Livewire.on('message-sent', () => {
        setTimeout(() => {
            const chatContainer = document.querySelector('.scrollbar-thin');
            if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
        }, 100);
    });
    
    // Initial scroll to bottom
    window.addEventListener('load', () => {
        const chatContainer = document.querySelector('.scrollbar-thin');
        if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;
    });
});
</script>