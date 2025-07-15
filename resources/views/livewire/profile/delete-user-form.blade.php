<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-semibold text-gray-800 font-dana">
            {{ __('حذف حساب') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('پس از حذف حساب، تمام منابع و داده‌های آن به‌طور دائم حذف خواهند شد. قبل از حذف حساب، لطفاً هر داده یا اطلاعاتی که مایل به حفظ آن هستید دانلود کنید.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-[#EF4444] hover:bg-[#DC2626] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 font-dana"
    >
        {{ __('حذف حساب') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit="deleteUser" class="p-6">
            <h2 class="text-lg font-semibold text-gray-800 font-dana">
                {{ __('آیا مطمئن هستید که می‌خواهید حساب خود را حذف کنید؟') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('پس از حذف حساب، تمام منابع و داده‌های آن به‌طور دائم حذف خواهند شد. لطفاً رمز عبور خود را وارد کنید تا تأیید کنید که می‌خواهید حساب خود را به‌طور دائم حذف کنید.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only font-dana">{{ __('رمز عبور') }}</label>
                <input
                    wire:model="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition font-dana"
                    placeholder="{{ __('رمز عبور') }}"
                />
                <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('password')" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button x-on:click="$dispatch('close')" class="bg-white border border-gray-300 text-gray-700 px-5 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-all transform hover:scale-105 font-dana">
                    {{ __('انصراف') }}
                </button>
                <button type="submit" class="bg-[#EF4444] hover:bg-[#DC2626] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 font-dana">
                    {{ __('حذف حساب') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>