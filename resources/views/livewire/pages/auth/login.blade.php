<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }
}; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 mx-4 font-dana">
    <div class="flex justify-center mb-6">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/kolehbar-logo.png') }}" alt="کوله‌بار" class="h-16" />
        </a>
    </div>

    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">سلام ماجراجو!</h1>
    <p class="text-center text-sm text-gray-600 mb-6">برای استفاده از کوله‌بار لطفاً وارد شوید</p>

    <div class="flex bg-[#E1F4E1] rounded-lg p-1 mb-6">
        <button class="flex-1 py-2 text-sm font-semibold text-white bg-[#6FA972] rounded-lg shadow">
            ورود
        </button>
        <a href="{{ route('register') }}" class="flex-1 py-2 text-sm font-semibold text-[#6FA972] text-center">
            ثبت‌نام
        </a>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-4">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">ایمیل</label>
            <input 
                wire:model="form.email"
                id="email"
                type="email"
                name="email"
                placeholder="مثال: your_email@gmail.com"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition @error('form.email') border-red-500 @enderror"
                required
                autofocus
            >
            @error('form.email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
            <input 
                wire:model="form.password"
                id="password"
                type="password"
                name="password"
                placeholder="رمز عبور خود را وارد کنید"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition @error('form.password') border-red-500 @enderror"
                required
            >
            @error('form.password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="h-4 w-4 text-[#6FA972] focus:ring-[#6FA972] border-gray-300 rounded">
                <label for="remember" class="mr-2 block text-sm text-gray-700">مرا به خاطر بسپار</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-[#6FA972] hover:underline">
                    فراموشی رمز عبور
                </a>
            @endif
        </div>

        <button type="submit" class="w-full bg-[#6FA972] hover:bg-[#5e955f] text-white py-3 px-4 rounded-lg font-semibold shadow-md transition-all transform hover:scale-[1.02]">
            ورود به حساب کاربری
        </button>
    </form>
</div>