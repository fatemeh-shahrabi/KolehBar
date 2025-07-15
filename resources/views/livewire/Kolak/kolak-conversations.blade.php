<div class="min-h-screen bg-[#E2F4E2] flex flex-col items-center rtl text-right px-2" dir="rtl">
    <!-- New Conversation Button -->
    <div class="w-full max-w-screen-lg mx-auto mt-6 flex justify-end">
        <button wire:click="createConversation" class="bg-[#A7D7A8] hover:bg-[#5C9562] text-white px-5 py-2 rounded-xl shadow transition font-dana font-semibold">
            مکالمه جدید
        </button>
    </div>

    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="w-full max-w-screen-lg mx-auto mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Conversation List Container -->
    <div class="w-full max-w-screen-lg mx-auto bg-white shadow-md rounded-2xl p-6 space-y-4 mt-4">
        @if ($conversations->count() === 0)
            <div class="bg-[#F9A85D] text-white p-6 rounded-xl shadow">
                <strong class="block mb-2">توجه:</strong>
                <p>لطفاً ابتدا یک مکالمه ایجاد کنید.</p>
            </div>
        @endif

        @foreach ($conversations as $conversation)
            <div class="flex items-center justify-between py-4 border-b last:border-none border-[#E0E0E0]">
                <div>
                    <p class="text-[#384943] font-bold text-lg">
                        {{ $conversation->title.'...' ?? 'بدون عنوان' }}
                    </p>
                    <small class="text-[#6B6B6B]">
                        آخرین به‌روزرسانی: {{ \Carbon\Carbon::parse($conversation->updated_at)->locale('fa')->diffForHumans() }}
                    </small>
                </div>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('kolak.messages', $conversation->id) }}">
                        <button class="bg-[#6FA972] hover:bg-[#5C9562] text-white px-4 py-2 rounded-xl shadow transition">
                            مشاهده
                        </button>
                    </a>
                    
                    @if ($confirmingDeletion === $conversation->id)
                        <button wire:click="deleteConversation({{ $conversation->id }})" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl shadow transition">
                            تأیید حذف
                        </button>
                        <button wire:click="cancelDelete" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl shadow transition">
                            انصراف
                        </button>
                    @else
                        <button wire:click="confirmDelete({{ $conversation->id }})" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-xl shadow transition">
                            حذف
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>