<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="w-full">
    <div class="mx-auto w-full max-w-md">
        {{-- Header --}}
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-gray-100">
                Welcome back
            </h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Sign in to continue to your dashboard
            </p>
        </div>

        {{-- Card --}}
        <div class="rounded-2xl border border-gray-200/70 bg-white/80 shadow-sm backdrop-blur
                    dark:border-gray-800 dark:bg-gray-900/60">
            <div class="p-6 sm:p-7">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form wire:submit="login" class="space-y-4">
                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />

                        <div class="relative mt-1">
                            {{-- icon --}}
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path d="M2.94 6.34a2 2 0 0 1 1.6-1.31l.23-.02h10.46a2 2 0 0 1 1.87 1.3l.07.2-6.7 4.02a2 2 0 0 1-1.88.1l-.14-.1-6.48-4.19Z"/>
                                    <path d="M18 8.05v5.95a2 2 0 0 1-1.85 1.99l-.15.01H4a2 2 0 0 1-1.99-1.85L2 14V8.28l6.2 4.01a4 4 0 0 0 3.98.15l.2-.12L18 8.05Z"/>
                                </svg>
                            </div>

                            <x-text-input
                                wire:model="form.email"
                                id="email"
                                type="email"
                                name="email"
                                required
                                autofocus
                                autocomplete="username"
                                class="block w-full rounded-xl border-gray-300 bg-white pl-10 pr-3 py-2.5 text-sm shadow-sm
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500
                                       dark:focus:border-emerald-500 dark:focus:ring-emerald-500/30"
                                placeholder="you@example.com"
                            />
                        </div>

                        <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />

                        <div class="relative mt-1">
                            {{-- icon --}}
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0 1 10 0v2a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2Zm2-2a3 3 0 1 1 6 0v2H7V7Z" clip-rule="evenodd"/>
                                </svg>
                            </div>

                            <x-text-input
                                wire:model="form.password"
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                class="block w-full rounded-xl border-gray-300 bg-white pl-10 pr-3 py-2.5 text-sm shadow-sm
                                       focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/30
                                       dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 dark:placeholder-gray-500
                                       dark:focus:border-emerald-500 dark:focus:ring-emerald-500/30"
                                placeholder="••••••••"
                            />
                        </div>

                        <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                    </div>

                    <!-- Remember / Forgot -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember" class="inline-flex items-center gap-2 select-none">
                            <input
                                wire:model="form.remember"
                                id="remember"
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-gray-300 text-emerald-600 shadow-sm
                                       focus:ring-emerald-500/40 dark:border-gray-700 dark:bg-gray-900"
                            >
                            <span class="text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Remember me') }}
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a
                                class="text-sm font-medium text-emerald-700 hover:text-emerald-800
                                       dark:text-emerald-400 dark:hover:text-emerald-300
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/40 rounded-md"
                                href="{{ route('password.request') }}"
                                wire:navigate
                            >
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <div class="pt-2">
                        <x-primary-button
                            class="w-full justify-center rounded-xl py-2.5 shadow-sm
                                   bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500/40"
                        >
                            {{ __('Log in') }}
                        </x-primary-button>

                        <p class="mt-4 text-center text-[12px] text-gray-500 dark:text-gray-400">
                            By signing in, you agree to the acceptable use policy.
                        </p>
                    </div>
                </form>
            </div>
        </div>

        {{-- Tiny footer --}}
        <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
            © {{ date('Y') }} — Depot Stock
        </div>
    </div>
</div>