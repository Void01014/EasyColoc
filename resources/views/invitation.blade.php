<x-app-layout>
    <x-slot name="header">
        <div class="text-center">
            <h2 class="font-serif text-3xl text-[#f0f4ff] leading-tight tracking-tight">
                {{ __('Account Settings') }}
            </h2>
            <p class="text-sm text-[#82BDED] mt-2 uppercase tracking-[0.2em]">Manage your cosmic identity & security</p>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col items-center space-y-8">
            
            <div class="relative overflow-hidden w-full max-w-[550px] p-6 sm:p-10 bg-gradient-to-br from-[#0d1136]/85 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-[24px] backdrop-blur-xl shadow-2xl animate-[rise_0.6s_ease-out]">
                <div class="relative z-10 mx-auto">
                    <div class="mb-8 text-center sm:text-left">
                        <h3 class="text-[#dde5ff] text-xl font-medium tracking-tight">{{ __('Profile Information') }}</h3>
                        <p class="text-[#82BDED] text-sm mt-1 opacity-80">Update your account's profile information and email address.</p>
                        <div class="h-px w-full bg-[#6b82ff]/10 mt-4"></div>
                    </div>
                    
                    <livewire:profile.update-profile-information-form />
                </div>
                
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#6b82ff]/10 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <div class="relative overflow-hidden w-full max-w-[550px] p-6 sm:p-10 bg-gradient-to-br from-[#0d1136]/85 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-[24px] backdrop-blur-xl shadow-2xl animate-[rise_0.8s_ease-out]">
                <div class="relative z-10 mx-auto">
                    <div class="mb-8 text-center sm:text-left">
                        <h3 class="text-[#dde5ff] text-xl font-medium tracking-tight">{{ __('Security') }}</h3>
                        <p class="text-[#82BDED] text-sm mt-1 opacity-80">Ensure your account is using a long, random password to stay secure.</p>
                        <div class="h-px w-full bg-[#6b82ff]/10 mt-4"></div>
                    </div>

                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="relative overflow-hidden w-full max-w-[550px] p-6 sm:p-10 bg-gradient-to-br from-[#1a0b14]/60 to-[#07091a]/95 border border-red-500/20 rounded-[24px] backdrop-blur-xl shadow-2xl animate-[rise_1s_ease-out]">
                <div class="relative z-10 mx-auto">
                    <div class="mb-8 text-center sm:text-left">
                        <h3 class="text-red-300 text-xl font-medium tracking-tight">{{ __('Danger Zone') }}</h3>
                        <p class="text-[#82BDED] text-sm mt-1 opacity-80">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
                        <div class="h-px w-full bg-red-500/10 mt-4"></div>
                    </div>

                    <livewire:profile.delete-user-form />
                </div>
                
                <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-red-500/10 rounded-full blur-3xl pointer-events-none"></div>
            </div>
            
        </div>
    </div>
</x-app-layout>