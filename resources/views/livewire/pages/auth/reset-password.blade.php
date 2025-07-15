<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            return;
        }

        session()->flash('status', __($status));
        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 mx-4 font-dana">
    <!-- لوگو -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/kolehbar-logo.png') }}" alt="کوله‌بار" class="h-16" />
        </a>
    </div>

    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">تنظیم مجدد رمز عبور</h1>
    <p class="text-center text-sm text-gray-600 mb-6">لطفاً رمز عبور جدید خود را وارد کنید</p>

    <form wire:submit="resetPassword" class="space-y-4">
        <!-- ایمیل (مخفی) -->
        <input type="hidden" wire:model="email">

        <!-- رمز جدید -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور جدید</label>
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

        <!-- تکرار رمز -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">تکرار رمز عبور</label>
            <input 
                wire:model="password_confirmation"
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] outline-none transition"
                required
            >
        </div>

        <!-- دکمه ارسال -->
        <button type="submit" class="w-full bg-[#6FA972] hover:bg-[#5e955f] text-white py-3 px-4 rounded-lg font-semibold shadow-md transition-all transform hover:scale-[1.02]">
            تغییر رمز عبور
        </button>
    </form>
</div>