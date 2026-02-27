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
        ->limit(5)
        ->get();
});

on([
    'expense-saved' => '$refresh',
]);

?>

<div class="space-y-8 relative">

    @foreach ($this->expenses as $expense)
        <div class="relative pl-8 group">
            <div
                class="absolute left-0 top-1.5 w-3.5 h-3.5 rounded-full border border-[#6b82ff] bg-[#07091a] z-10 group-hover:bg-[#6b82ff] group-hover:scale-125 transition-all shadow-[0_0_10px_rgba(107,130,255,0.4)]">
            </div>

            <div class="flex justify-between items-start gap-4">
                <div>
                    <p class="text-[#dde5ff] font-medium">{{ $expense->name }}</p>
                    <p class="text-[10px] text-[#3d4a7a] uppercase tracking-widest font-bold">
                        Paid by {{ $expense->user->name }} •
                        {{ $expense->created_at->format('M d') }}
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-sm font-serif text-[#6b82ff]">
                        ${{ number_format($expense->amount, 2) }}</p>
                    <p class="text-[10px] text-[#3d4a7a] mt-1 italic">
                        {{ $expense->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>
