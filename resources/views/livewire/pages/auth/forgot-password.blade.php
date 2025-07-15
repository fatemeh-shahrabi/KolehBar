<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate(['email' => ['required', 'string', 'email']]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 mx-4 font-dana">
    <!-- لوگو -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/kolehbar-logo.png') }}" alt="کوله‌بار" class="h-16" />
        </a>
    </div>

    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">بازیابی رمز عبور</h1>
    <p class="text-center text-sm text-gray-600 mb-6">لطفاً ایمیل خود را وارد کنید تا لینک بازیابی ارسال شود</p>

    <!-- وضعیت سشن -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-4">
        <!-- ایمیل -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
            <input 
                wire:model="email"
                id="email"
                type="email"
                name="email"
                placeholder="مثال: your_email@gmail.com"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition @error('email') border-red-500 @enderror"
                required
                autofocus
            >
            @error('email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- دکمه ارسال -->
        <button type="submit" class="w-full bg-[#6FA972] hover:bg-[#5e955f] text-white py-3 px-4 rounded-lg font-semibold shadow-md transition-all transform hover:scale-[1.02]">
            ارسال لینک بازیابی
        </button>

        <!-- بازگشت به ورود -->
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-[#6FA972] hover:underline" wire:navigate>
                بازگشت به صفحه ورود
            </a>
        </div>
    </form>
</div>