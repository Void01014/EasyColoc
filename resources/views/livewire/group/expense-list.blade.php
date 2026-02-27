<?php

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{computed, state, mount, on};

state(['group']);

$expenses = computed(function () {
    return $this->group
        ->expenses()
        ->with(['user', 'category'])
        ->latest()
        ->get();
});

on([
    'expense-saved' => '$refresh',
]);

?>

<div class="lg:col-span-8 space-y-6">
    <h3 class="text-[#dde5ff] font-serif text-2xl italic">Mission Logs</h3>

    <div class="space-y-4">
        @forelse($this->expenses as $expense)
            <div
                class="group flex items-center justify-between p-5 bg-[#0d1136]/20 border border-[#6b82ff]/5 rounded-2xl hover:bg-[#6b82ff]/5 transition-all">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-[#07091a] border border-[#6b82ff]/10 flex items-center justify-center text-xl">
                        {{ $expense->category->icon ?? '📦' }}
                    </div>
                    <div>
                        <p class="text-[#dde5ff] font-medium">{{ $expense->name }}</p>
                        <p class="text-[10px] text-[#3d4a7a] uppercase tracking-widest font-bold">
                            Paid by {{ $expense->user->name }} •
                            {{ $expense->created_at->format('M d') }}
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-lg font-serif text-[#dde5ff]">
                        ${{ number_format($expense->amount, 2) }}</p>
                    <button
                        class="text-[9px] text-[#6b82ff] uppercase tracking-[0.2em] font-black opacity-0 group-hover:opacity-100 transition-opacity">View
                        Details</button>
                </div>
            </div>
        @empty
            <div class="py-10 text-center border border-dashed border-[#3d4a7a] rounded-3xl">
                <p class="text-[#3d4a7a] italic">The ledger is empty for this sector.</p>
            </div>
        @endforelse
    </div>
</div>
