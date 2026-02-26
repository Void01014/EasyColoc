<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-[#07091a] relative overflow-hidden px-4">
        
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-[#6b82ff]/10 rounded-full blur-[120px] pointer-events-none"></div>

        <div class="relative w-full max-w-md bg-gradient-to-br from-[#0d1136]/90 to-[#07091a]/95 border border-[#6b82ff]/30 rounded-[40px] p-10 shadow-2xl backdrop-blur-xl animate-[rise_0.5s_ease-out]">
            
            <div class="text-center mb-10">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-3xl bg-[#6b82ff]/10 text-[#6b82ff] mb-6 text-3xl shadow-inner">
                    ✧
                </div>
                <h2 class="font-serif text-3xl text-[#f0f4ff] italic leading-tight">
                    Incoming Connection
                </h2>
                <p class="text-[10px] uppercase tracking-[0.3em] text-[#82BDED] font-black mt-3 opacity-60">
                    Security Verification Required
                </p>
            </div>

            <div class="space-y-6 text-center mb-10">
                <p class="text-[#82BDED] text-sm leading-relaxed">
                    You have been summoned to join the crew of <br>
                    <span class="text-[#dde5ff] font-bold text-lg block mt-1 tracking-tight">"{{ $group_name }}"</span>
                </p>
                
                <div class="py-3 px-4 bg-white/5 rounded-2xl border border-white/5 inline-block">
                    <span class="text-[9px] text-[#3d4a7a] font-bold uppercase tracking-widest block">Linked Token</span>
                    <span class="text-[11px] text-[#6b82ff] font-mono opacity-80 uppercase tracking-tighter">{{ Str::limit($token, 12) }}...</span>
                </div>
            </div>

            <div class="space-y-4">
                <form action="{{ route('groups.handle-invite') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="action" value="accept">
                    
                    <button type="submit" class="w-full py-4 bg-[#6b82ff] hover:bg-[#4d63f5] text-white rounded-2xl text-xs font-bold uppercase tracking-widest transition-all shadow-[0_10px_20px_rgba(107,130,255,0.2)] active:scale-95">
                        Accept Connection
                    </button>
                </form>

                <form action="{{ route('groups.handle-invite') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="action" value="decline">

                    <button type="submit" class="w-full py-4 text-[#3d4a7a] hover:text-red-400 text-[10px] font-bold uppercase tracking-widest transition-colors">
                        Decline Transmission
                    </button>
                </form>
            </div>

            <div class="mt-12 text-center pt-6 border-t border-white/5">
                <p class="text-[9px] text-[#3d4a7a] font-bold uppercase tracking-widest italic">
                    Stationed in Rabat • Sidi Ghouzia Gateway
                </p>
            </div>
        </div>
    </div>

    <style>
        @keyframes rise {
            from { opacity: 0; transform: translateY(20px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
    </style>
</x-guest-layout>