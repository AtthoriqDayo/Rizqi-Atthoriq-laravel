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
            body.theme-pagi { background-image: url('/images/backgrounds/ChatGPTPagi.png'); }
            body.theme-siang { background-image: url('/images/backgrounds/ChatGPTsiang.png'); }
            body.theme-sore { background-image: url('/images/backgrounds/ChatGPTSore.png'); }
            body.theme-malam { background-image: url('/images/backgrounds/ChatGPTMalam.png'); }
            body.theme-dini-hari { background-image: url('/images/backgrounds/ChatGPTMalam.png'); } /* Dini hari pakai gambar malam */
             /* Warna Teks untuk Tema Terang (Pagi & Siang) */
            body.theme-pagi,
            body.theme-siang {
                color: #1f2937; /* Abu-abu Gelap */
            }

            /* Warna Teks untuk Tema Redup (Sore) */
            body.theme-sore {
                color: #e5e7eb; /* Abu-abu Terang */
            }

            /* Warna Teks untuk Tema Gelap (Malam & Dini Hari) */
            body.theme-malam,
            body.theme-dini-hari {
                color: #f9fafb; /* Putih Cerah */
            }

            body {
                background-size: cover;
                background-position: center;
                background-attachment: fixed;
                transition: background-image 0.5s linear;
            }

        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen">
            @include('layouts.navigation')


            <main>
                 @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const hour = new Date().getHours();
                let theme = 'dini-hari';
                if (hour >= 5 && hour < 10) theme = 'pagi';
                else if (hour >= 10 && hour < 15) theme = 'siang';
                else if (hour >= 15 && hour < 19) theme = 'sore';
                else if (hour >= 19 && hour < 24) theme = 'malam';
                document.body.classList.add(`theme-${theme}`);
                if (theme === 'sore' || theme === 'malam' || theme === 'dini-hari') {
                    document.documentElement.classList.add('dark');
                }
            });
        </script>
    </body>
</html>
