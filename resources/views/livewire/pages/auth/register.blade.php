<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();
    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    Auth::login($user);
    $this->redirect(route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <header class="flex items-center gap-3 mb-6">
        <div class="w-10 h-10 bg-gradient-to-br from-[#6b82ff] to-[#3d56e0] rounded-xl flex items-center justify-center text-lg shadow-[0_0_20px_rgba(107,130,255,0.4)]">
            <span class="text-white">✦</span>
        </div>
        <div>
            <h2 class="text-lg tracking-wider text-[#dde5ff]">SplitStay</h2>
            <p class="text-[10px] tracking-[0.15em] text-[#3D82F5] uppercase font-bold">Co-rent & trip expenses</p>
        </div>
    </header>

    <h1 class="text-2xl leading-tight text-[#f0f4ff] mb-1.5 font-serif">Create account.</h1>
    <p class="text-sm text-[#6EA4FF] mb-6 leading-relaxed">Start splitting costs effortlessly.</p>

    <form wire:submit="register" class="space-y-4">
        <div>
            <label for="name" class="block text-[11px] tracking-widest text-[#6EA4FF] uppercase mb-1.5">{{ __('Full Name') }}</label>
            <input wire:model="name" id="name" type="text" name="name" required autofocus autocomplete="name"
                   class="w-full bg-white/5 border border-[#6b82ff]/20 rounded-lg px-4 py-2.5 text-sm text-[#dde5ff] outline-none transition-all focus:border-[#6b82ff]/50 focus:bg-[#6b82ff]/5 focus:ring-4 focus:ring-[#6b82ff]/10">
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs opacity-80" />
        </div>

        <div>
            <label for="email" class="block text-[11px] tracking-widest text-[#6EA4FF] uppercase mb-1.5">{{ __('Email Address') }}</label>
            <input wire:model="email" id="email" type="email" name="email" required autocomplete="username"
                   class="w-full bg-white/5 border border-[#6b82ff]/20 rounded-lg px-4 py-2.5 text-sm text-[#dde5ff] outline-none transition-all focus:border-[#6b82ff]/50 focus:bg-[#6b82ff]/5 focus:ring-4 focus:ring-[#6b82ff]/10">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs opacity-80" />
        </div>

        <div class="grid grid-cols-1 gap-4">
            <div>
                <label for="password" class="block text-[11px] tracking-widest text-[#6EA4FF] uppercase mb-1.5">{{ __('Password') }}</label>
                <input wire:model="password" id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full bg-white/5 border border-[#6b82ff]/20 rounded-lg px-4 py-2.5 text-sm text-[#dde5ff] outline-none transition-all focus:border-[#6b82ff]/50 focus:bg-[#6b82ff]/5 focus:ring-4 focus:ring-[#6b82ff]/10">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs opacity-80" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-[11px] tracking-widest text-[#6EA4FF] uppercase mb-1.5">{{ __('Confirm') }}</label>
                <input wire:model="password_confirmation" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full bg-white/5 border border-[#6b82ff]/20 rounded-lg px-4 py-2.5 text-sm text-[#dde5ff] outline-none transition-all focus:border-[#6b82ff]/50 focus:bg-[#6b82ff]/5 focus:ring-4 focus:ring-[#6b82ff]/10">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs opacity-80" />
            </div>
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="relative overflow-hidden w-full py-3 bg-gradient-to-br from-[#4d63f5] to-[#3448d6] rounded-lg text-white font-medium tracking-wider shadow-[0_0_20px_rgba(77,99,245,0.4)] hover:shadow-[0_0_32px_rgba(77,99,245,0.6)] hover:-translate-y-px active:translate-y-0 transition-all duration-200">
                {{ __('Create Account') }}
            </button>
        </div>
    </form>

    <footer class="text-center mt-8 text-[13px] text-[#6EA4FF]">
        Already have an account?
        <a href="{{ route('login') }}" wire:navigate class="text-[#6b82ff] ml-1 hover:border-b hover:border-[#6b82ff] transition-all">Sign in</a>
    </footer>
</div>