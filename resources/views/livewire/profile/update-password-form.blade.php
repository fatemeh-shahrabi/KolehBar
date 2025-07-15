<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-800 font-dana">
            {{ __('به‌روزرسانی رمز عبور') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('برای امنیت حساب خود، از یک رمز عبور طولانی و تصادفی استفاده کنید.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" class="mt-6 space-y-6">
        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 font-dana">{{ __('رمز عبور فعلی') }}</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition font-dana" autocomplete="current-password" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('current_password')" />
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 font-dana">{{ __('رمز عبور جدید') }}</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition font-dana" autocomplete="new-password" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('password')" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 font-dana">{{ __('تأیید رمز عبور') }}</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition font-dana" autocomplete="new-password" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('password_confirmation')" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 font-dana">
                {{ __('ذخیره') }}
            </button>

            <x-action-message class="me-3 text-[#A7D7A7] font-semibold" on="password-updated">
                {{ __('ذخیره شد.') }}
            </x-action-message>
        </div>
    </form>
</section>