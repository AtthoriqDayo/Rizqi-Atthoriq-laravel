<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-g">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyActivity</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Page transition styles */
        .page-transition { animation: fadeIn 0.5s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

        /* Dynamic Backgrounds */
        body.theme-morning { background: linear-gradient(to bottom, #E0F7FA, #B2EBF2); }
        body.theme-afternoon { background: linear-gradient(to bottom, #FFF3E0, #FFCC80); }
        body.theme-evening { background: linear-gradient(to bottom, #F3E5F5, #CE93D8); }
        body.theme-night { background: linear-gradient(to bottom, #263238, #37474F); color: white; }
    </style>
</head>
<body class="antialiased">
    <div id="app" class="page-transition">
        @yield('content')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const hour = new Date().getHours();
            let theme = 'night';
            if (hour >= 5 && hour < 12) theme = 'morning';
            else if (hour >= 12 && hour < 18) theme = 'afternoon';
            else if (hour >= 18 && hour < 21) theme = 'evening';
            document.body.classList.add(`theme-${theme}`);
        });
    </script>
</body>
</html>