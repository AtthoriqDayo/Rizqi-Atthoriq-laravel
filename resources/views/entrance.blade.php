<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyActivity</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Style untuk background dinamis */
        body { transition: background 0.5s linear; }
        body.theme-morning { background: linear-gradient(to bottom, #E0F7FA, #B2EBF2); }
        body.theme-afternoon { background: linear-gradient(to bottom, #FFF3E0, #FFCC80); }
        body.theme-evening { background: linear-gradient(to bottom, #F3E5F5, #CE93D8); }
        body.theme-night { background: linear-gradient(to bottom, #263238, #37474F); }

        /* Keyframes untuk animasi */
        @keyframes fadeInScaleUp {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        .animate-entrance {
            animation: fadeInScaleUp 1.5s ease-in-out forwards;
        }
    </style>
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center animate-entrance">
            {{-- Anda bisa mengganti SVG ini dengan logo Anda --}}
            <svg class="w-32 h-32 mx-auto text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <h1 class="text-5xl font-bold text-white mt-4">MyActivity</h1>
        </div>
    </div>

    <script>
        // Script untuk background dinamis
        document.addEventListener('DOMContentLoaded', function () {
            const hour = new Date().getHours();
            let theme = 'night';
            if (hour >= 5 && hour < 12) theme = 'morning';
            else if (hour >= 12 && hour < 18) theme = 'afternoon';
            else if (hour >= 18 && hour < 21) theme = 'evening';
            document.body.classList.add(`theme-${theme}`);

            // Arahkan ke halaman login setelah 2.5 detik
            setTimeout(() => {
                window.location.href = "{{ route('login') }}";
            }, 2500); // 2500 milidetik = 2.5 detik
        });
    </script>
</body>
</html>
