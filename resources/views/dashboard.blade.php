@php
    /** * Mock Data for Preview
     * In production, these will come from your Controller/Livewire component
     */
    $totalDebt = 142.5;
    $reputation = 12;

    $latestExpenses = collect([
        (object) [
            'name' => 'Organic Coffee',
            'amount' => 45.0,
            'created_at' => now()->subMinutes(15),
            'group' => (object) ['name' => 'Rabat Apartment'],
        ],
        (object) [
            'name' => 'Tagine Dinner',
            'amount' => 180.0,
            'created_at' => now()->subHours(2),
            'group' => (object) ['name' => 'Marrakech Roadtrip'],
        ],
        (object) [
            'name' => 'Toll Booths',
            'amount' => 22.0,
            'created_at' => now()->subHours(5),
            'group' => (object) ['name' => 'Marrakech Roadtrip'],
        ],
        (object) [
            'name' => 'Supermarket Run',
            'amount' => 412.5,
            'created_at' => now()->subDays(1),
            'group' => (object) ['name' => 'Summer Surf Camp'],
        ],
    ]);
@endphp

<x-app-layout>
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h2 class="font-serif text-3xl text-[#f0f4ff] leading-tight tracking-tight italic">
                    {{ __('Command Center') }}
                </h2>
                <p class="text-sm text-[#82BDED] mt-1 uppercase tracking-[0.2em] font-bold opacity-70">
                    Welcome Back {{ auth()->user()->name }} ✧
                </p>
            </div>
            @if ($activeGroup)
                <div x-data={}>
                    <button @click="$dispatch('open-expense-modal')"
                        class="px-5 py-2 bg-[#6b82ff] text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-[#6b82ff]/20">
                        + New Expense
                    </button>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            @livewire('dashboard.user-stats', ['user' => $user, 'group' => $activeGroup], key($user->id))

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-7 space-y-6">
                    <h3 class="text-[#dde5ff] font-serif text-2xl flex items-center gap-3">
                        Active Sector <span
                            class="h-px flex-grow bg-gradient-to-r from-[#6b82ff]/30 to-transparent"></span>
                    </h3>

                    @if ($activeGroup)
                        @livewire('dashboard.group-stats', ['group' => $activeGroup])
                    @else
                        <div
                            class="py-20 text-center bg-[#0d1136]/20 border border-dashed border-[#6b82ff]/20 rounded-[32px] backdrop-blur-sm">
                            <div class="text-5xl mb-4 opacity-20">✧</div>
                            <h4 class="text-[#dde5ff] font-serif text-xl italic mb-2">No Active Constellation</h4>
                            <p class="text-[#3d4a7a] text-sm max-w-xs mx-auto mb-8">Join a group to start logging
                                expenses and building your astral reputation.</p>
                            <div x-data={} class="flex justify-center gap-4">
                                <button @click="$dispatch('open-sector-modal')"
                                    class="px-6 py-2.5 bg-gradient-to-br from-[#4d63f5] to-[#3448d6] rounded-xl text-white text-xs font-bold uppercase tracking-widest shadow-[0_0_20px_rgba(77,99,245,0.3)]">
                                    + New Sector
                                </button>
                                <a href="#"
                                    class="px-8 py-3 bg-white/5 border border-[#6b82ff]/30 text-[#6b82ff] rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#6b82ff]/10 transition-all">
                                    Find a Sector
                                </a href="#">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="lg:col-span-5">
                    <div
                        class="p-8 bg-gradient-to-b from-[#0d1136]/60 to-[#07091a]/40 border border-[#6b82ff]/10 rounded-[32px] backdrop-blur-md sticky top-24 shadow-2xl animate-[rise_0.8s_ease-out]">
                        <h3 class="text-[#dde5ff] font-serif text-2xl mb-8 flex items-center gap-3">
                            Latest Entries
                        </h3>

                        @livewire('group.latest-entries-list', ['group' => $activeGroup])


                        <button
                            class="w-full mt-10 py-4 border border-[#6b82ff]/20 rounded-2xl text-[#82BDED] text-[10px] uppercase tracking-[0.2em] font-black hover:bg-[#6b82ff]/10 hover:border-[#6b82ff]/40 transition-all shadow-inner">
                            Full Expense Archives
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @livewire('group.groupmodal');
    @livewire('group.expensemodal', ['group' => $activeGroup, 'categories' => $categories])
</x-app-layout>
