@php
    // Mocking the Active Group
    $activeGroup = $activeGroup ??(object) [
        'id' => 1,
        'name' => 'Marrakech Roadtrip',
        'owner_id' => 1, // Sarah is the owner
        'users' => collect([
            (object) [
                'id' => 1,
                'name' => 'Sarah Alami',
                'reputation' => 24,
                'balances' => [
                    ['target_name' => 'Yassine', 'amount' => 150.0], // Sarah is owed $150
                    ['target_name' => 'Mehdi', 'amount' => -45.0], // Sarah owes Mehdi $45
                ],
            ],
            (object) [
                'id' => 2,
                'name' => 'Yassine Tazi',
                'reputation' => 15,
                'balances' => [
                    ['target_name' => 'Sarah', 'amount' => -150.0], // Yassine owes Sarah $150
                    ['target_name' => 'Mehdi', 'amount' => 20.0], // Yassine is owed $20 by Mehdi
                ],
            ],
            (object) [
                'id' => 3,
                'name' => 'Mehdi Benani',
                'reputation' => 18,
                'balances' => [
                    ['target_name' => 'Sarah', 'amount' => 45.0], // Mehdi is owed $45 by Sarah
                    ['target_name' => 'Yassine', 'amount' => -20.0], // Mehdi owes Yassine $20
                ],
            ],
        ]),
    ];

    // Mocking the Expense Ledger (Mission Logs)
    $expenses = $expenses ?? collect([]);
@endphp

<x-app-layout>
    <x-slot name="header">
        <div x-data={} class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="text-[#3d4a7a] hover:text-[#6b82ff] transition-colors">←</a>
                <h2 class="font-serif text-3xl text-[#f0f4ff] italic italic tracking-tight">
                    {{ $activeGroup->name }}
                </h2>
            </div>
            <button @click="$dispatch('open-expense-modal')"
                class="px-5 py-2 bg-[#6b82ff] text-white text-xs font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-[#6b82ff]/20">
                + New Expense
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">

            <section>
                <h3
                    class="text-[#82BDED] text-[10px] uppercase tracking-[0.3em] font-black mb-8 flex items-center gap-4">
                    The Debt Constellation <span
                        class="h-px flex-grow bg-gradient-to-r from-[#6b82ff]/20 to-transparent"></span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($activeGroup->users as $member)
                        <div
                            class="relative p-6 bg-[#0d1136]/40 border border-[#6b82ff]/10 rounded-[32px] backdrop-blur-md">
                            <div class="flex items-center gap-3 mb-6">
                                <div
                                    class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#6b82ff] to-[#4d63f5] flex items-center justify-center text-white font-bold">
                                    {{ substr($member->name, 0, 1) }}
                                </div>
                                <span class="text-[#dde5ff] font-medium">{{ $member->name }}</span>
                                @if ($member->id === $activeGroup->owner_id)
                                    <span class="text-yellow-400 text-sm" title="Sector Lead">✦</span>
                                @endif
                            </div>

                            {{-- <div class="space-y-4">
                                @foreach ($member->balances as $balance)
                                    <div class="flex items-center justify-between group">
                                        <div class="flex items-center gap-2">
                                            @if ($balance['amount'] > 0)
                                                <span class="text-emerald-400 font-bold">──▶</span>
                                            @else
                                                <span class="text-yellow-400 font-bold">◀──</span>
                                            @endif
                                            <span class="text-xs text-[#82BDED] opacity-60 uppercase tracking-tighter">
                                                {{ $balance['target_name'] }}
                                            </span>
                                        </div>
                                        <span
                                            class="font-serif text-sm {{ $balance['amount'] > 0 ? 'text-emerald-400' : 'text-yellow-400' }}">
                                            ${{ number_format(abs($balance['amount']), 2) }}
                                        </span>
                                    </div>
                                @endforeach

                                @if (count($member->balances) === 0)
                                    <p class="text-[10px] italic text-[#3d4a7a] text-center py-2">No active ties.</p>
                                @endif
                            </div> --}}
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                <div class="lg:col-span-8 space-y-6">
                    <h3 class="text-[#dde5ff] font-serif text-2xl italic">Mission Logs</h3>

                    <div class="space-y-4">
                        @forelse($expenses as $expense)
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

                <aside class="lg:col-span-4 space-y-8">
                    <div
                        class="p-8 bg-gradient-to-b from-[#0d1136]/60 to-[#07091a]/40 border border-[#6b82ff]/10 rounded-[32px]">
                        <h4 class="text-[#dde5ff] font-serif text-xl mb-6 italic">Sector Personnel</h4>
                        <div class="space-y-4">
                            @foreach ($activeGroup->users as $member)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.4)]">
                                        </div>
                                        <span class="text-sm text-[#82BDED]">{{ $member->name }}</span>
                                        @if ($member->id === $activeGroup->owner_id)
                                            <span class="text-yellow-400 text-[10px]">✦</span>
                                        @endif
                                    </div>
                                    <span class="text-[10px] text-[#3d4a7a] font-bold">REP:
                                        {{ $member->reputation }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div x-data="{}" class="mt-8 pt-6 border-t border-[#6b82ff]/10">
                            <button @click="$dispatch('open-invite-modal')"
                                class="w-full py-3 border border-[#6b82ff]/20 text-[#6b82ff] text-[10px] font-bold uppercase tracking-widest rounded-xl hover:bg-[#6b82ff]/10 transition-all">
                                Invite Explorer
                            </button>
                        </div>
                    </div>
                </aside>

            </section>
        </div>
    </div>
    @livewire('group.invitemodal', ['group' => $activeGroup])
    @livewire('group.expensemodal', ['group' => $activeGroup])
</x-app-layout>
