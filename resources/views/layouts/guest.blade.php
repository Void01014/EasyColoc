<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SplitStay — Login</title>
    @vite('resources/css/app.css')
    <style>
        @import url('https://fonts.cdnfonts.com/css/grotley');

        body {
            font-family: 'Grotley', serif;
        }
    </style>
</head>

<body
    class="bg-[#07091a] text-[#dde5ff] min-h-screen flex items-center justify-center overflow-hidden selection:bg-[#6b82ff]/30">
    <div id="stars" class="fixed inset-0 pointer-events-none z-0"></div>

    <div
        class="orb-1 fixed w-[600px] h-[600px] rounded-full blur-[120px] bg-[radial-gradient(circle,#1a2580_0%,transparent_70%)] -top-[200px] -left-[200px] pointer-events-none z-0">
    </div>
    <div
        class="orb-2 fixed w-[500px] h-[500px] rounded-full blur-[120px] bg-[radial-gradient(circle,#0e1a6e_0%,transparent_70%)] -bottom-[150px] -right-[100px] pointer-events-none z-0">
    </div>
    <main
        class="relative z-10 w-full max-w-[440px] p-12 bg-gradient-to-br from-[#0d1136]/85 to-[#07091a]/90 border border-[#6b82ff]/20 rounded-[20px] backdrop-blur-xl shadow-[0_30px_80px_rgba(0,0,0,0.6),inset_0_1px_0_rgba(143,163,255,0.12)] animate-[rise_0.9s_cubic-bezier(0.22,1,0.36,1)]">

        {{ $slot }}
    </main>
</body>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const container = document.getElementById('stars');
        if (container) {
            for (let i = 0; i < 130; i++) {
                const s = document.createElement('div');
                const size = Math.random() * 2 + 0.5;
                s.className = 'star absolute rounded-full bg-white pointer-events-none';
                s.style.width = `${size}px`; s.style.height = `${size}px`;
                s.style.top = `${Math.random() * 100}%`; s.style.left = `${Math.random() * 100}%`;
                s.style.setProperty('--d', `${3 + Math.random() * 6}s`);
                s.style.setProperty('--delay', `${-Math.random() * 8}s`);
                s.style.setProperty('--op', `${0.3 + Math.random() * 0.6}`);
                container.appendChild(s);
            }
        }
    });
</script>

</html>
