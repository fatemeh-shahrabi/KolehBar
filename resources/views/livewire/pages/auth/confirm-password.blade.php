<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    public function confirmPassword(): void
    {
        $this->validate(['password' => ['required', 'string']]);

        if (! auth()->guard('web')->validate([
            'email' => auth()->user()->email,
            'password' => $this->password,
        ])) {
            $this->addError('password', 'رمز عبور وارد شده نادرست است.');
            return;
        }

        session()->put('auth.password_confirmed_at', time());
        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
}; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 mx-4 font-dana">
    <!-- لوگو -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/kolehbar-logo.png') }}" alt="کوله‌بار" class="h-16" />
        </a>
    </div>

    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">تأیید رمز عبور</h1>
    <p class="text-center text-sm text-gray-600 mb-6">لطفاً برای امنیت بیشتر، رمز عبور خود را وارد کنید</p>

    <form wire:submit="confirmPassword" class="space-y-4">
        <!-- رمز عبور -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
            <input 
                wire:model="password"
                id="password"
                type="password"
                name="password"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition @error('password') border-red-500 @enderror"
                required
                autofocus
            >
            @error('password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- دکمه ارسال -->
        <button type="submit" class="w-full bg-[#6FA972] hover:bg-[#5e955f] text-white py-3 px-4 rounded-lg font-semibold shadow-md transition-all transform hover:scale-[1.02]">
            تأیید رمز عبور
        </button>
    </form>
</div>