<?php

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{computed, state, mount, on};

state(['group']);

$total_volume = computed(function () {
    return $this->group
        ->expenses()
        ->sum('amount');
});

on([
    'expense-saved' => '$refresh',
]);

?>

<div
    class="relative overflow-hidden p-8 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/95 border border-[#6b82ff]/20 rounded-[32px] shadow-2xl group animate-[rise_0.6s_ease-out]">
    <div class="absolute -top-12 -right-12 w-64 h-64 bg-[#6b82ff]/5 rounded-full blur-[80px] pointer-events-none">
    </div>
    <div
        class="absolute -bottom-6 -right-6 text-9xl opacity-[0.02] select-none group-hover:rotate-12 transition-transform duration-700">
        ✦</div>

    <div class="relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span
                    class="text-[10px] bg-[#6b82ff]/10 border border-[#6b82ff]/20 px-3 py-1 rounded-full text-[#82BDED] uppercase tracking-widest font-bold">Current
                    Mission</span>
                <h4
                    class="text-[#dde5ff] text-3xl font-medium mt-3 tracking-tight group-hover:text-[#6b82ff] transition-colors">
                    {{ $group->name }}</h4>
            </div>
            <div class="flex -space-x-3">
                @for ($i = 0; $i < min($group->users_count, 5); $i++)
                    <div
                        class="w-10 h-10 rounded-full border-2 border-[#07091a] bg-[#1a2580] flex items-center justify-center text-[10px] text-white shadow-lg">
                        {{ $i + 1 }}
                    </div>
                @endfor
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
            <div class="p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm">
                <span class="text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold block mb-2">Total
                    Sector Volume</span>
                <p class="text-[#dde5ff] text-xl font-serif">
                    ${{ number_format($this->total_volume ?? 2450.0, 2) }}
                    <span
                        class="text-[9px] font-sans text-[#82BDED] block opacity-70 uppercase tracking-tighter mt-1">Total
                        expenses logged</span>
                </p>
            </div>

            <div class="p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm">
                <span class="text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold block mb-2">Your
                    Standing</span>
                @php
                    // Mocking a standing for the group
                    $standing = -45.0; // Negative means you owe, positive means you are owed
                @endphp
                <p class="text-xl font-serif {{ $standing < 0 ? 'text-yellow-400' : 'text-emerald-400' }}">
                    {{ $standing < 0 ? 'Settlement Due' : 'Credit Owed' }}
                    <span class="text-xs font-sans text-[#dde5ff] block mt-1 italic opacity-80">
                        ${{ number_format(abs($standing), 2) }}
                        {{ $standing < 0 ? 'to others' : 'to you' }}
                    </span>
                </p>
            </div>
        </div>

        <div class="flex flex-wrap gap-4 pt-4 border-t border-white/5">
            <a href="{{ route('myGroup.view') }}"
                class="px-6 py-3 bg-[#6b82ff] hover:bg-[#4d63f5] text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-[0_10px_20px_rgba(107,130,255,0.2)]">
                Open Sector Console
            </a>
            <button
                class="px-6 py-3 border border-red-500/20 hover:bg-red-500/5 text-red-400 rounded-xl text-xs font-bold uppercase tracking-widest transition-all">
                Leave Group
            </button>
        </div>
    </div>
</div>
