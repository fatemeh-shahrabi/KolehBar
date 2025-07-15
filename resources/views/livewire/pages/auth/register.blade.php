<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 mx-4 font-dana">
    <!-- لوگو -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/kolehbar-logo.png') }}" alt="کوله‌بار" class="h-16" />
        </a>
    </div>

    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">به کوله‌بار خوش آمدید!</h1>
    <p class="text-center text-sm text-gray-600 mb-6">برای شروع ماجراجویی خود ثبت‌نام کنید</p>

    <!-- تب‌ها -->
    <div class="flex bg-[#E1F4E1] rounded-lg p-1 mb-6">
        <a href="{{ route('login') }}" class="flex-1 py-2 text-sm font-semibold text-[#6FA972] text-center">
            ورود
        </a>
        <button class="flex-1 py-2 text-sm font-semibold text-white bg-[#6FA972] rounded-lg shadow">
            ثبت‌نام
        </button>
    </div>

    <form wire:submit="register" class="space-y-4">
        <!-- نام -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">نام کامل</label>
            <input 
                wire:model="name"
                id="name"
                type="text"
                name="name"
                placeholder="نام و نام خانوادگی خود را وارد کنید"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition @error('name') border-red-500 @enderror"
                required
                autofocus
            >
            @error('name')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

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
            >
            @error('email')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- رمز عبور -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
            <input 
                wire:model="password"
                id="password"
                type="password"
                name="password"
                placeholder="حداقل 8 کاراکتر"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition @error('password') border-red-500 @enderror"
                required
            >
            @error('password')
                <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- تکرار رمز -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تکرار رمز عبور</label>
            <input 
                wire:model="password_confirmation"
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                placeholder="رمز عبور را مجدداً وارد کنید"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition"
                required
            >
        </div>

        <!-- دکمه ارسال -->
        <button type="submit" class="w-full bg-[#6FA972] hover:bg-[#5e955f] text-white py-3 px-4 rounded-lg font-semibold shadow-md transition-all transform hover:scale-[1.02]">
            ایجاد حساب کاربری
        </button>
    </form>
</div>