<?php

use App\Models\Expense;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, on};

state([
    'expense' => null,
    'payments' => [],
    'loading' => false,
]);

on([
    'open-expense-details' => function ($expenseId) {
        // Set loading state if you want a spinner
        $this->loading = true;

        // Fetch fresh data from DB by ID instead of passing big objects
        $this->expense = Expense::with('category')->find($expenseId);
        $this->payments = Payment::where('expense_id', $expenseId)->with('user')->get();

        $this->loading = false;
    },
]);

$markAsPaid = function ($paymentId) {
    $payment = Payment::with('user')->find($paymentId);

    // Use the fetched expense state for the check
    if ($payment) {
        $payment->update(['paid_at' => now()]);
        $payment->user->increment('reputation');

        // Refresh only the payments collection
        $this->payments = Payment::where('expense_id', $this->expense->id)->with('user')->get();
        $this->dispatch('payment-updated');
    }
};

?>

<div x-data="{ open: false }" @open-expense-details.window="open = true" wire:ignore.self class="relative z-[110]">

    <div wire:loading wire:target="open-expense-details"></div>

    <div x-show="open" x-cloak x-transition.opacity
        class="fixed inset-0 bg-[#07091a]/95 backdrop-blur-xl flex items-center justify-center p-4">

        <div @click.away="open = false;"
            class="relative w-full max-w-2xl flex flex-col bg-gradient-to-br from-[#0d1136] to-[#07091a] border border-[#6b82ff]/30 rounded-[40px] overflow-hidden shadow-[0_0_80px_rgba(107,130,255,0.1)]">

            @if ($expense)
                <div class="p-8 border-b border-white/5 bg-white/[0.02]">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] uppercase tracking-[0.3em] text-[#6b82ff] font-black">Mission Log
                                Details</span>
                            <h2 class="text-3xl font-serif text-[#dde5ff] italic mt-2">{{ $expense['name'] }}</h2>
                            <p class="text-sm text-[#82BDED] opacity-60 mt-1">
                                Category: {{ $expense['category']['name'] ?? 'General' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold block">Total
                                Value</span>
                            <span
                                class="text-3xl font-serif text-emerald-400">${{ number_format($expense['amount'], 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 flex-grow overflow-y-auto max-h-[60vh]">
                    <h4 class="text-[10px] uppercase tracking-[0.2em] text-[#3d4a7a] font-black mb-6">Crew Settlement
                        Status</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach ($payments as $payment)
                            <div
                                class="p-4 rounded-2xl border {{ $payment['paid_at'] ?? null ? 'bg-emerald-500/5 border-emerald-500/20' : 'bg-white/[0.03] border-white/10' }}">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-8 h-8 rounded-lg bg-[#07091a] border border-white/10 flex items-center justify-center text-xs text-[#82BDED]">
                                            {{ substr($payment['user']['name'] ?? 'U', 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-xs font-medium text-[#dde5ff]">
                                                {{ $payment['user']['name'] ?? 'Unknown' }}</p>
                                            <p class="text-[15px] text-[#3d4a7a] font-bold uppercase tracking-tighter">
                                                Share: ${{ number_format($payment['amount'], 2) }}
                                            </p>
                                        </div>
                                    </div>

                                    @if ($payment['paid_at'] ?? null)
                                        <span
                                            class="text-emerald-400 text-[10px] font-bold uppercase tracking-widest">Settled</span>
                                    @else
                                        <button wire:click="markAsPaid({{ $payment['id'] }})"
                                            class="px-3 py-1.5 bg-[#6b82ff]/10 hover:bg-[#6b82ff] text-[#6b82ff] hover:text-white rounded-lg text-[9px] font-bold transition-all">
                                            Confirm
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="p-8 text-white">Loading Expense Data...</div>
            @endif

            <div class="p-6 bg-white/[0.02] text-center border-t border-white/5">
                <button @click="open = false"
                    class="text-[10px] font-bold uppercase tracking-[0.3em] text-[#3d4a7a] hover:text-[#6b82ff] transition-colors">
                    Close Briefing
                </button>
            </div>
        </div>
    </div>
</div>
