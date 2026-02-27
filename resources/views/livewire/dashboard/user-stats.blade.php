<?php

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{computed, state, mount, on};

state(['user', 'group', 'unpaidCount' => ($unpaidCount = 3)]);

$total_debt = computed(function () {
    return $this->group->expenses()->sum('amount');
});

on([
    'expense-saved' => '$refresh',
]);

?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

    <div
        class="relative overflow-hidden p-6 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-3xl backdrop-blur-xl shadow-xl">
        <div class="relative z-10 flex items-center gap-5">
            @if ($group)
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl {{ $this->total_debt > 0 ? 'bg-yellow-500/10 text-yellow-400' : 'bg-emerald-500/10 text-emerald-400' }}">
                    {{ $this->total_debt > 0 ? '▼' : '▲' }}
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-[#82BDED] font-black">Net Balance
                    </p>
                    <p class="text-2xl font-serif {{ $this->total_debt > 0 ? 'text-yellow-400' : 'text-emerald-400' }}">
                        {{ $this->total_debt > 0 ? '-' : '+' }} ${{ number_format(abs($this->total_debt), 2) }}
                    </p>
                </div>
            @else
                <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-xl text-[#3d4a7a]">
                    ?
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-[#3d4a7a] font-black">Net Balance
                    </p>
                    <p class="text-sm font-sans italic text-[#3d4a7a]">Join a group to sync</p>
                </div>
            @endif
        </div>
    </div>

    <div
        class="relative overflow-hidden p-6 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-3xl backdrop-blur-xl shadow-xl">
        <div class="relative z-10 flex items-center gap-5">
            <div
                class="w-14 h-14 rounded-2xl bg-indigo-500/10 text-indigo-300 flex items-center justify-center text-2xl">
                ✧
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-[0.2em] text-[#82BDED] font-black">Astral
                    Reputation</p>
                <p class="text-2xl font-serif text-[#dde5ff]">
                    {{ $user->reputation }} <span class="text-xs font-sans italic opacity-50 ml-1">Score</span>
                </p>
            </div>
        </div>
    </div>

    <div
        class="relative overflow-hidden p-6 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-3xl backdrop-blur-xl shadow-xl">
        <div class="relative z-10 flex items-center gap-5">
            @if ($group)
                <div
                    class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl {{ $unpaidCount > 0 ? 'bg-red-500/10 text-red-400' : 'bg-blue-500/10 text-blue-400' }}">
                    {{ $unpaidCount }}
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-[#82BDED] font-black">Unpaid
                        Stakes</p>
                    <p class="text-2xl font-serif text-[#dde5ff]">Pending Actions</p>
                </div>
            @else
                <div class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-xl text-[#3d4a7a]">
                    !
                </div>
                <div>
                    <p class="text-[10px] uppercase tracking-[0.2em] text-[#3d4a7a] font-black">Unpaid
                        Stakes</p>
                    <p class="text-sm font-sans italic text-[#3d4a7a]">Join a group to see</p>
                </div>
            @endif
        </div>
    </div>
</div>
