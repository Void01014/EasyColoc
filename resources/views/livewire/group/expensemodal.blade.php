<?php

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state, rules};

state([
    'group' => null,
    'categories' => [],
    'name' => '',
    'amount' => '',
    'category_id' => '',
    'description' => '',
]);

rules([
    'name' => 'required|min:3|max:50',
    'amount' => 'required|numeric|min:0.01',
    'category_id' => 'required|exists:categories,id',
    'description' => 'nullable|string',
]);

$saveExpense = function () {
    $this->validate();

    Expense::create([
        'user_id' => Auth::id(),
        'group_id' => $this->group->id,
        'name' => $this->name,
        'amount' => $this->amount,
        'category_id' => $this->category_id,
        'description' => $this->description,
    ]);

    $this->dispatch('expense-saved');
    $this->reset(['name', 'amount', 'category_id', 'description']);

    return redirect(request()->fullUrl());
};

?>

<div x-data="{ open: false }" 
     @open-expense-modal.window="open = true" 
     @expense-saved.window="open = false"
     class="relative z-[100]">

    <div x-show="open" x-cloak x-transition.opacity
         class="fixed inset-0 bg-[#07091a]/90 backdrop-blur-md flex items-center justify-center p-4">

        <div @click.away="open = false"
             class="relative w-full max-w-xl bg-[#0d1136] border border-[#6b82ff]/30 rounded-[32px] p-8 shadow-2xl">
            
            <div class="text-center mb-8">
                <h3 class="text-[#dde5ff] font-serif text-2xl italic tracking-tight">Log New Mission Expense</h3>
                <p class="text-[10px] uppercase tracking-widest text-[#3d4a7a] mt-2">Update the Sector Ledger</p>
            </div>

            <form wire:submit.prevent="saveExpense" class="space-y-5">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold mb-2 ml-1">Expense Title</label>
                    <input type="text" wire:model="name" placeholder="e.g., Gas to Marrakech"
                           class="w-full bg-[#07091a]/50 border border-[#6b82ff]/20 rounded-2xl px-5 py-3 text-[#dde5ff] focus:border-[#6b82ff] focus:ring-0 transition-all">
                    @error('name') <span class="text-red-400 text-[10px] mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold mb-2 ml-1">Amount ($)</label>
                        <input type="number" step="0.01" wire:model="amount" placeholder="0.00"
                               class="w-full bg-[#07091a]/50 border border-[#6b82ff]/20 rounded-2xl px-5 py-3 text-[#dde5ff] focus:border-[#6b82ff] focus:ring-0 transition-all">
                        @error('amount') <span class="text-red-400 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold mb-2 ml-1">Category</label>
                        <select wire:model="category_id" 
                                class="w-full bg-[#07091a]/50 border border-[#6b82ff]/20 rounded-2xl px-5 py-3 text-[#dde5ff] focus:border-[#6b82ff] focus:ring-0 transition-all">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="text-red-400 text-[10px] mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold mb-2 ml-1">Description (Optional)</label>
                    <textarea wire:model="description" rows="2"
                              class="w-full bg-[#07091a]/50 border border-[#6b82ff]/20 rounded-2xl px-5 py-3 text-[#dde5ff] focus:border-[#6b82ff] focus:ring-0 transition-all"></textarea>
                </div>

                <div class="flex flex-col gap-3 pt-4">
                    <button type="submit" 
                            class="w-full py-4 bg-[#6b82ff] hover:bg-[#4d63f5] text-white rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-[#6b82ff]/20">
                        Confirm Expense
                    </button>
                    <button type="button" @click="open = false"
                            class="w-full py-2 text-[#3d4a7a] hover:text-[#82BDED] text-[10px] font-bold uppercase tracking-widest transition-colors">
                        Discard
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>