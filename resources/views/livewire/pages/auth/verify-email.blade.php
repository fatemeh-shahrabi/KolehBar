<?php

use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public function sendVerification(): void
    {
        if (auth()->user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard'), navigate: true);
            return;
        }

        auth()->user()->sendEmailVerificationNotification();

        session()->flash('status', 'verification-link-sent');
    }

    public function logout(): void
    {
        auth()->guard('web')->logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 mx-4 font-dana">
    <!-- لوگو -->
    <div class="flex justify-center mb-6">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/kolehbar-logo.png') }}" alt="کوله‌بار" class="h-16" />
        </a>
    </div>

    <h1 class="text-center text-xl font-bold text-gray-800 mb-2">تایید ایمیل</h1>
    
    <div class="space-y-4 text-center">
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm text-green-600">
                لینک تایید جدید به ایمیل شما ارسال شد.
            </div>
        @endif

        <p class="text-sm text-gray-600">
            قبل از ادامه، لطفاً ایمیل خود را با کلیک روی لینک تایید بررسی کنید.
        </p>

        <p class="text-sm text-gray-600">
            اگر ایمیل را دریافت نکرده‌اید، می‌توانید درخواست ارسال مجدد کنید.
        </p>

        <div class="flex flex-col gap-4 mt-6">
            <button wire:click="sendVerification" 
                    class="bg-[#6FA972] hover:bg-[#5e955f] text-white py-2 px-4 rounded-lg font-semibold shadow-md transition-all">
                ارسال مجدد لینک تایید
            </button>

            <button wire:click="logout" 
                    class="text-sm text-gray-600 hover:text-gray-900">
                خروج از حساب کاربری
            </button>
        </div>
    </div>
</div>