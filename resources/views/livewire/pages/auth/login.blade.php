<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');

form(LoginForm::class);

$login = function () {
    $this->validate();
    $this->form->authenticate();
    Session::regenerate();
    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <header class="flex items-center gap-3 mb-8">
        <div class="w-11 h-11 bg-gradient-to-br from-[#6b82ff] to-[#3d56e0] rounded-xl flex items-center justify-center text-xl shadow-[0_0_22px_rgba(107,130,255,0.5)]">
            <span class="text-white">✦</span>
        </div>
        <div>
            <h2 class="text-xl tracking-wider text-[#dde5ff]">SplitStay</h2>
            <p class="text-[11px] tracking-[0.15em] text-[#82BDED] uppercase font-bold">Co-rent & trip expenses</p>
        </div>
    </header>

    <h1 class="text-[28px] leading-tight text-[#f0f4ff] mb-1.5 font-serif">Welcome back.</h1>
    <p class="text-sm text-[#82BDED] mb-8 leading-relaxed">Sign in to manage your shared costs.</p>

    <x-auth-session-status class="mb-4 shadow-[0_0_15px_rgba(107,130,255,0.1)] border border-[#6b82ff]/20 p-3 rounded-lg text-sm" :status="session('status')" />

    <form wire:submit="login" class="space-y-5">
        <div>
            <label for="email" class="block text-[12px] tracking-widest text-[#82BDED] uppercase mb-2">{{ __('Email address') }}</label>
            <input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username"
                   class="w-full bg-white/5 border border-[#6b82ff]/20 rounded-lg px-4 py-3 text-sm text-[#dde5ff] outline-none transition-all placeholder:text-[#82BDED] focus:border-[#6b82ff]/50 focus:bg-[#6b82ff]/5 focus:ring-4 focus:ring-[#6b82ff]/10">
            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-xs opacity-80" />
        </div>

        <div>
            <label for="password" class="block text-[12px] tracking-widest text-[#82BDED] uppercase mb-2">{{ __('Password') }}</label>
            <input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full bg-white/5 border border-[#6b82ff]/20 rounded-lg px-4 py-3 text-sm text-[#dde5ff] outline-none transition-all placeholder:text-[#82BDED] focus:border-[#6b82ff]/50 focus:bg-[#6b82ff]/5 focus:ring-4 focus:ring-[#6b82ff]/10">
            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-xs opacity-80" />
        </div>

        <div class="flex items-center justify-between text-sm py-2">
            <label for="remember" class="flex items-center gap-2 text-[#82BDED] cursor-pointer group select-none">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember" 
                       class="rounded border-[#6b82ff]/40 bg-white/5 text-[#6b82ff] focus:ring-[#6b82ff]/20 focus:ring-offset-0">
                <span class="text-xs uppercase tracking-tight">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-[#6b82ff] text-xs hover:border-b hover:border-[#6b82ff] transition-all" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <button type="submit" 
                class="relative overflow-hidden w-full py-3.5 bg-gradient-to-br from-[#4d63f5] to-[#3448d6] rounded-lg text-white font-medium tracking-wider shadow-[0_0_20px_rgba(77,99,245,0.45)] hover:shadow-[0_0_32px_rgba(77,99,245,0.65)] hover:-translate-y-px active:translate-y-0 transition-all duration-200">
            {{ __('Sign in') }}
        </button>

        <div class="flex items-center gap-3 py-2 text-[10px] tracking-[0.2em] text-[#82BDED] uppercase">
            <div class="h-px flex-1 bg-[#6b82ff]/15"></div>
            OR
            <div class="h-px flex-1 bg-[#6b82ff]/15"></div>
        </div>
    </form>

    <footer class="text-center mt-8 text-[13px] text-[#82BDED]">
        No account yet?
        <a href="{{ route('register') }}" wire:navigate class="text-[#6b82ff] ml-1 hover:border-b hover:border-[#6b82ff] transition-all">Create one</a>
    </footer>
</div>