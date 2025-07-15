<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-800 font-dana">
            {{ __('اطلاعات پروفایل') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __("اطلاعات پروفایل و آدرس ایمیل خود را به‌روزرسانی کنید.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" class="mt-6 space-y-6">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 font-dana">{{ __('نام') }}</label>
            <input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition font-dana" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 font-dana">{{ __('ایمیل') }}</label>
            <input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full border border-gray-300 rounded-lg py-3 px-4 focus:ring-2 focus:ring-[#A7D7A7] focus:border-[#A7D7A7] transition font-dana" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-500 text-xs" :messages="$errors->get('email')" />

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-3 text-gray-600 font-dana">
                        {{ __('آدرس ایمیل شما تأیید نشده است.') }}
                        <button wire:click.prevent="sendVerification" class="text-[#EC9F48] hover:text-[#F68B2D] text-sm font-semibold transition">
                            {{ __('برای ارسال مجدد ایمیل تأیید کلیک کنید.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-sm text-[#A7D7A7] font-dana">
                            {{ __('لینک تأیید جدید به آدرس ایمیل شما ارسال شد.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-[#75AC78] hover:bg-[#6C9E6E] text-white px-5 py-3 rounded-lg font-semibold transition-all transform hover:scale-105 font-dana">
                {{ __('ذخیره') }}
            </button>

            <x-action-message class="me-3 text-[#A7D7A7] font-semibold" on="profile-updated">
                {{ __('ذخیره شد.') }}
            </x-action-message>
        </div>
    </form>
</section>