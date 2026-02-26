<?php

use App\Models\Group;
use Livewire\Volt\Component;

new class extends Component {
    public string $name = '';

    public function createSector()
    {
        $this->validate([
            'name' => 'required|min:3|max:50',
        ]);

        $group = Group::create([
            'name' => $this->name,
        ]);

        $group->addUser('owner');

        $this->dispatch('sector-created');
        $this->reset('name');
    }
}; ?>

<div x-data="{ open: false }" @open-sector-modal.window="open = true" @sector-created.window="open = false"
    class="relative z-[100]">

    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-[#07091a]/80 backdrop-blur-sm flex items-center justify-center p-4">

        <div @click.away="open = false"
            class="relative w-full max-w-lg bg-gradient-to-br from-[#0d1136] to-[#07091a] border border-[#6b82ff]/30 rounded-[32px] p-8 shadow-[0_0_50px_rgba(107,130,255,0.15)] overflow-hidden">

            <div
                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-[#6b82ff] to-transparent opacity-50">
            </div>

            <div class="relative z-10">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#6b82ff]/10 text-[#6b82ff] mb-4 text-2xl">
                        ✦
                    </div>
                    <h3 class="text-[#dde5ff] font-serif text-2xl italic tracking-tight">Initialize New Sector</h3>
                    <p class="text-[#82BDED] text-xs uppercase tracking-[0.2em] mt-2 opacity-70">Define the coordinates
                        for your new constellation</p>
                </div>

                <form wire:submit="createSector" class="space-y-6">
                    <div>
                        <label for="name"
                            class="block text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold mb-2 ml-1">Sector
                            Name</label>
                        <input type="text" wire:model="name" id="name" placeholder="e.g. Marrakech Roadtrip..."
                            class="w-full bg-[#07091a]/50 border border-[#6b82ff]/20 rounded-2xl px-5 py-4 text-[#dde5ff] placeholder-[#3d4a7a] focus:outline-none focus:border-[#6b82ff] focus:ring-1 focus:ring-[#6b82ff] transition-all">
                        @error('name')
                        <span
                            class="text-red-400 text-[10px] mt-2 ml-1 uppercase tracking-wider">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-3 pt-4">
                        <button type="submit"
                            class="w-full py-4 bg-[#6b82ff] hover:bg-[#4d63f5] text-white rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-[0_10px_20px_rgba(107,130,255,0.2)] active:scale-95">
                            Create Sector
                        </button>
                        <button type="button" @click="open = false"
                            class="w-full py-4 text-[#3d4a7a] hover:text-[#82BDED] text-[10px] font-bold uppercase tracking-widest transition-colors">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

            <div
                class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#6b82ff]/10 rounded-full blur-3xl pointer-events-none">
            </div>
        </div>
    </div>
</div>