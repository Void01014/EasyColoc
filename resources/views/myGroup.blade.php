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
                                @if ($member->pivot->role === 'owner')
                                    <span class="text-yellow-400 text-sm" title="Sector Lead">✦</span>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div class="space-y-3">
                                    @forelse ($settlements[$member->id] as $settlement)
                                        <div
                                            class="relative group flex items-center justify-between p-3 rounded-2xl bg-white/[0.02] border border-white/[0.05] hover:border-[#6b82ff]/30 hover:bg-[#6b82ff]/5 transition-all duration-300">

                                            <div class="flex items-center gap-3">
                                                <div class="relative flex items-center">
                                                    @if ($settlement['amount'] > 0)
                                                        {{-- Energy Flow Out --}}
                                                        <div class="flex items-center">
                                                            <div
                                                                class="w-8 h-[1px] bg-gradient-to-r from-emerald-500 to-transparent">
                                                            </div>
                                                            <div class="text-emerald-500 text-[10px] animate-pulse">▶
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- Energy Flow In --}}
                                                        <div class="flex items-center">
                                                            <div class="text-yellow-500 text-[10px] animate-pulse">◀
                                                            </div>
                                                            <div
                                                                class="w-8 h-[1px] bg-gradient-to-l from-yellow-500 to-transparent">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-[9px] uppercase tracking-widest text-[#3d4a7a] font-bold group-hover:text-[#82BDED] transition-colors">
                                                        {{ $settlement['amount'] > 0 ? 'Receiving from' : 'Sending to' }}
                                                    </span>
                                                    <span class="text-xs text-[#dde5ff] font-medium tracking-tight">
                                                        {{ $settlement['to_name'] }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="text-right">
                                                <span
                                                    class="font-serif text-sm {{ $settlement['amount'] > 0 ? 'text-emerald-400' : 'text-yellow-400' }} drop-shadow-[0_0_8px_rgba(107,130,255,0.2)]">
                                                    ${{ number_format(abs($settlement['amount']), 2) }}
                                                </span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-6 flex flex-col items-center justify-center opacity-40">
                                            <span class="text-xl mb-1">✧</span>
                                            <p class="text-[10px] uppercase tracking-widest text-[#3d4a7a] font-bold">
                                                Orbital Equilibrium</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="grid grid-cols-1 lg:grid-cols-12 gap-12">

                @livewire('group.expense-list', ['group' => $activeGroup])


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
                                        @if ($member->pivot->role === 'owner')
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
    @livewire('group.expensemodal', ['group' => $activeGroup, 'categories' => $categories])
</x-app-layout>
