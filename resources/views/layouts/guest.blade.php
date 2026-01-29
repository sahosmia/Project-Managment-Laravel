<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    body {
        background-image: url('https://i.ytimg.com/vi/-ZQXYhbMiXM/maxresdefault.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
</style>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-900/70 ">
        <div>
            <a href="/">
                <img class=" w-48 flex items-center justify-center"
                    src="https://upload.wikimedia.org/wikipedia/en/e/ed/Green_University_of_Bangladesh_logo.svg"
                    alt="Logo" />
            </a>
        </div>

        <div
            class="w-full sm:max-w-lg mt-6 px-8 py-6 bg-white/80  shadow-xl overflow-hidden sm:rounded-2xl backdrop-blur-sm">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
