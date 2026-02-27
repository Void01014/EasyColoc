<?php

use App\Mail\invitation;
use App\Models\Group;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Pest\Support\Str;

use function Livewire\Volt\{state, rules, protect};

state([
    'email' => '',
    'group' => null,
    'error' => false
]);

rules([
    'email' => 'required|email',
]);

$sendInvite = function () {
    $this->validate();
    $this->error = false;


    $invited_user = User::where('email', $this->email)->first();
    
    if ($invited_user) {
        $isAlreadyMember = $invited_user->groups()->where('status', true)->exists();
        if ($isAlreadyMember) {
            $this->error = true;
            return;
        }
    }

    $token = Str::random(64);
    Mail::to($this->email)->send(new Invitation($this->group->name, $token));

    $request = Request::create([
        'user_id' => $invited_user->id,
        'group_id' => $this->group->id,
        'token' => $token,
    ]);

    $this->dispatch('invite-sent');

    $this->reset('email');
};

?>

<div x-data="{ open: false }"
    @open-invite-modal.window="open = true"
    @invite-sent.window="open = false"
    class="relative z-[100]">

    <div x-show="open"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-[#07091a]/80 backdrop-blur-sm flex items-center justify-center p-4">

        <div @click.away="open = false"
            class="relative w-full max-w-lg bg-gradient-to-br from-[#0d1136] to-[#07091a] border border-[#6b82ff]/30 rounded-[32px] p-8 shadow-[0_0_50px_rgba(107,130,255,0.15)] overflow-hidden">

            <div class="relative z-10">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#6b82ff]/10 text-[#6b82ff] mb-4 text-2xl">
                        ✦
                    </div>
                    <h3 class="text-[#dde5ff] font-serif text-2xl italic tracking-tight">Invite New Members</h3>
                </div>

                <form wire:submit.prevent="sendInvite" class="space-y-6">
                    <div>
                        <label for="email" class="block text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold mb-2 ml-1">
                            Email Address
                        </label>
                        <input type="email"
                            wire:model="email"
                            id="email"
                            placeholder="user@example.com"
                            class="w-full bg-[#07091a]/50 border border-[#6b82ff]/20 rounded-2xl px-5 py-4 text-[#dde5ff] placeholder-[#3d4a7a] focus:outline-none focus:border-[#6b82ff] focus:ring-1 focus:ring-[#6b82ff] transition-all">

                        @error('email')
                        <span class="text-red-400 text-[10px] mt-2 ml-1 uppercase tracking-wider">{{ $message }}</span>
                        @enderror
                    </div>
                    @if($error)
                    <h2>This User Is Already In a Sector</h2>
                    @endif

                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit"
                            wire:loading.attr="disabled"
                            class="w-full py-4 bg-[#6b82ff] hover:bg-[#4d63f5] text-white rounded-2xl text-xs font-bold uppercase tracking-widest transition-all active:scale-95 disabled:opacity-50">
                            <span wire:loading.remove>Send Invitation</span>
                            <span wire:loading>Sending...</span>
                        </button>

                        <button type="button" @click="open = false"
                            class="w-full py-4 text-[#3d4a7a] hover:text-[#82BDED] text-[10px] font-bold uppercase tracking-widest transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>