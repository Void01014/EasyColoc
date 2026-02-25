@php
    /** * Mock Data for Preview
     * In production, these will come from your Controller/Livewire component
     */
    $totalDebt = 142.5;
    $unpaidCount = 3;
    $reputation = 12;

    // A user can only be in one group at a time
    $activeGroup = null;

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
                <button
                    class="px-6 py-2.5 bg-gradient-to-br from-[#4d63f5] to-[#3448d6] rounded-xl text-white text-xs font-bold uppercase tracking-widest shadow-[0_0_20px_rgba(77,99,245,0.3)] hover:shadow-[0_0_30px_rgba(77,99,245,0.5)] transition-all active:scale-95">
                    + Log New Expense
                </button>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div
                    class="relative overflow-hidden p-6 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-3xl backdrop-blur-xl shadow-xl">
                    <div class="relative z-10 flex items-center gap-5">
                        @if ($activeGroup)
                            <div
                                class="w-14 h-14 rounded-2xl flex items-center justify-center text-2xl {{ $totalDebt > 0 ? 'bg-yellow-500/10 text-yellow-400' : 'bg-emerald-500/10 text-emerald-400' }}">
                                {{ $totalDebt > 0 ? '▼' : '▲' }}
                            </div>
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.2em] text-[#82BDED] font-black">Net Balance
                                </p>
                                <p
                                    class="text-2xl font-serif {{ $totalDebt > 0 ? 'text-yellow-400' : 'text-emerald-400' }}">
                                    {{ $totalDebt > 0 ? '-' : '+' }} ${{ number_format(abs($totalDebt), 2) }}
                                </p>
                            </div>
                        @else
                            <div
                                class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-xl text-[#3d4a7a]">
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
                                {{ $reputation }} <span class="text-xs font-sans italic opacity-50 ml-1">Score</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="relative overflow-hidden p-6 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-3xl backdrop-blur-xl shadow-xl">
                    <div class="relative z-10 flex items-center gap-5">
                        @if ($activeGroup)
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
                            <div
                                class="w-14 h-14 rounded-2xl bg-white/5 flex items-center justify-center text-xl text-[#3d4a7a]">
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


            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                <div class="lg:col-span-7 space-y-6">
                    <h3 class="text-[#dde5ff] font-serif text-2xl flex items-center gap-3">
                        Active Sector <span
                            class="h-px flex-grow bg-gradient-to-r from-[#6b82ff]/30 to-transparent"></span>
                    </h3>

                    @if ($activeGroup)
                        <div
                            class="relative overflow-hidden p-8 bg-gradient-to-br from-[#0d1136]/80 to-[#07091a]/95 border border-[#6b82ff]/20 rounded-[32px] shadow-2xl group animate-[rise_0.6s_ease-out]">
                            <div
                                class="absolute -top-12 -right-12 w-64 h-64 bg-[#6b82ff]/5 rounded-full blur-[80px] pointer-events-none">
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
                                            {{ $activeGroup->name }}</h4>
                                    </div>
                                    <div class="flex -space-x-3">
                                        @for ($i = 0; $i < min($activeGroup->users_count, 5); $i++)
                                            <div
                                                class="w-10 h-10 rounded-full border-2 border-[#07091a] bg-[#1a2580] flex items-center justify-center text-[10px] text-white shadow-lg">
                                                {{ $i + 1 }}
                                            </div>
                                        @endfor
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-8">
                                    <div class="p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm">
                                        <span
                                            class="text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold block mb-2">Total
                                            Sector Volume</span>
                                        <p class="text-[#dde5ff] text-xl font-serif">
                                            ${{ number_format($activeGroup->total_volume ?? 2450.0, 2) }}
                                            <span
                                                class="text-[9px] font-sans text-[#82BDED] block opacity-70 uppercase tracking-tighter mt-1">Total
                                                expenses logged</span>
                                        </p>
                                    </div>

                                    <div class="p-5 bg-white/5 rounded-2xl border border-white/5 backdrop-blur-sm">
                                        <span
                                            class="text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold block mb-2">Your
                                            Standing</span>
                                        @php
                                            // Mocking a standing for the group
                                            $standing = -45.0; // Negative means you owe, positive means you are owed
                                        @endphp
                                        <p
                                            class="text-xl font-serif {{ $standing < 0 ? 'text-yellow-400' : 'text-emerald-400' }}">
                                            {{ $standing < 0 ? 'Settlement Due' : 'Credit Owed' }}
                                            <span class="text-xs font-sans text-[#dde5ff] block mt-1 italic opacity-80">
                                                ${{ number_format(abs($standing), 2) }}
                                                {{ $standing < 0 ? 'to others' : 'to you' }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="flex flex-wrap gap-4 pt-4 border-t border-white/5">
                                    <a href="#"
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
                    @else
                        <div
                            class="py-20 text-center bg-[#0d1136]/20 border border-dashed border-[#6b82ff]/20 rounded-[32px] backdrop-blur-sm">
                            <div class="text-5xl mb-4 opacity-20">✧</div>
                            <h4 class="text-[#dde5ff] font-serif text-xl italic mb-2">No Active Constellation</h4>
                            <p class="text-[#3d4a7a] text-sm max-w-xs mx-auto mb-8">Join a group to start logging
                                expenses and building your astral reputation.</p>
                            <div class="flex justify-center gap-4">
                                <a href="#"
                                    class="px-8 py-3 bg-[#6b82ff]/30 border border-[#6b82ff]/30 text-black-800/2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#6b82ff] transition-all">
                                    Create a Sector
                                </a href="#">
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

                        <div class="space-y-8 relative">
                            <div
                                class="absolute left-[7px] top-2 bottom-2 w-px bg-gradient-to-b from-[#6b82ff]/50 via-[#6b82ff]/10 to-transparent">
                            </div>

                            @foreach ($latestExpenses as $expense)
                                <div class="relative pl-8 group">
                                    <div
                                        class="absolute left-0 top-1.5 w-3.5 h-3.5 rounded-full border border-[#6b82ff] bg-[#07091a] z-10 group-hover:bg-[#6b82ff] group-hover:scale-125 transition-all shadow-[0_0_10px_rgba(107,130,255,0.4)]">
                                    </div>

                                    <div class="flex justify-between items-start gap-4">
                                        <div>
                                            <p
                                                class="text-[#dde5ff] text-sm font-medium leading-none group-hover:text-[#6b82ff] transition-colors">
                                                {{ $expense->name }}</p>
                                            <p
                                                class="text-[10px] text-[#3d4a7a] uppercase tracking-wider mt-2 font-black">
                                                {{ $expense->group->name }}</p>
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

                        <button
                            class="w-full mt-10 py-4 border border-[#6b82ff]/20 rounded-2xl text-[#82BDED] text-[10px] uppercase tracking-[0.2em] font-black hover:bg-[#6b82ff]/10 hover:border-[#6b82ff]/40 transition-all shadow-inner">
                            Full Expense Archives
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
