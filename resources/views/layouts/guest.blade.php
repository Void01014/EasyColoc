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

        /* Keyframes kept in CSS for smooth animation performance */
        @keyframes twinkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(0.8);
            }

            50% {
                opacity: var(--op, 0.6);
                transform: scale(1);
            }
        }

        @keyframes drift {

            0%,
            100% {
                transform: translate(0, 0);
            }

            33% {
                transform: translate(40px, -30px);
            }

            66% {
                transform: translate(-20px, 20px);
            }
        }

        @keyframes bloom {
            to {
                width: 500px;
                height: 500px;
                opacity: 0;
            }
        }

        .star {
            animation: twinkle var(--d, 4s) ease-in-out infinite var(--delay, 0s);
        }

        .orb-1 {
            animation: drift 18s ease-in-out infinite;
        }

        .orb-2 {
            animation: drift 22s ease-in-out infinite reverse;
        }

        .ripple-active::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            width: 0;
            height: 0;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            animation: bloom 0.55s ease-out forwards;
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
