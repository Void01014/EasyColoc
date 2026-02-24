<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SplitStay') }}</title>

    <link rel="stylesheet" href="https://fonts.cdnfonts.com/css/grotley">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Grotley', serif; }
        
    </style>
</head>
<body class="bg-[#07091a] text-[#dde5ff] min-h-screen antialiased selection:bg-[#6b82ff]/30 overflow-x-hidden">
    
    <div id="stars" class="fixed inset-0 pointer-events-none z-0"></div>
    <div class="orb-1 fixed w-[600px] h-[600px] rounded-full blur-[120px] bg-[radial-gradient(circle,#1a2580_0%,transparent_70%)] -top-[200px] -left-[200px] pointer-events-none z-0"></div>
    <div class="orb-2 fixed w-[500px] h-[500px] rounded-full blur-[120px] bg-[radial-gradient(circle,#0e1a6e_0%,transparent_70%)] bottom-[10%] right-[-10%] pointer-events-none z-0"></div>

    <div class="relative z-10 min-h-screen flex flex-col">
        <livewire:layout.navigation />

        @if (isset($header))
            <header class="pt-10 pb-2">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main class="flex-grow">
            {{ $slot }}
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('stars');
            if (container) {
                for (let i = 0; i < 150; i++) {
                    const s = document.createElement('div');
                    const size = Math.random() * 2 + 0.5;
                    s.className = 'star absolute rounded-full bg-white pointer-events-none';
                    s.style.width = `${size}px`;
                    s.style.height = `${size}px`;
                    s.style.top = `${Math.random() * 100}%`;
                    s.style.left = `${Math.random() * 100}%`;
                    s.style.setProperty('--d', `${3 + Math.random() * 6}s`);
                    s.style.setProperty('--delay', `${-Math.random() * 8}s`);
                    s.style.setProperty('--op', `${0.3 + Math.random() * 0.6}`);
                    container.appendChild(s);
                }
            }
        });
    </script>
</body>
</html>