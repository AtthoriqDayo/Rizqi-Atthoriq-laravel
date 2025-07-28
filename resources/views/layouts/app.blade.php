<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                transition: background-image 0.5s linear;
            }
            /* Ganti 'pagi.jpg' dst. dengan nama file gambar Anda */
            body.theme-pagi { background-image: url('/images/backgrounds/ChatGPTPagi.png'); }
            body.theme-siang { background-image: url('/images/backgrounds/ChatGPTsiang.png'); }
            body.theme-sore { background-image: url('/images/backgrounds/ChatGPTSore.png'); }
            body.theme-malam { background-image: url('/images/backgrounds/ChatGPTMalam.png'); }
            body.theme-dini-hari { background-image: url('/images/backgrounds/malam.jpg'); } /* Dini hari pakai gambar malam */
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-200" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-black/20 backdrop-blur-lg shadow-md overflow-hidden sm:rounded-lg border-2 border-white">
                {{ $slot }}
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const hour = new Date().getHours();
                let theme = 'dini-hari';

                // Definisikan periode waktu yang baru
                if (hour >= 5 && hour < 10) theme = 'pagi';       // 05:00 - 09:59
                else if (hour >= 10 && hour < 15) theme = 'siang'; // 10:00 - 14:59
                else if (hour >= 15 && hour < 19) theme = 'sore';  // 15:00 - 18:59
                else if (hour >= 19 && hour < 24) theme = 'malam'; // 19:00 - 23:59
                // (00:00 - 04:59 akan otomatis menjadi 'dini-hari')

                // Tambahkan class tema untuk background gambar
                document.body.classList.add(`theme-${theme}`);

                // Tambahkan class 'dark' untuk style Tailwind saat sore/malam/dini hari
                if (theme === 'sore' || theme === 'malam' || theme === 'dini-hari') {
                    document.documentElement.classList.add('dark');
                }
            });
        </script>
    </body>
</html>
