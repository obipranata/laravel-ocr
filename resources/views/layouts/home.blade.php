<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel OCR</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body class="antialiased" >

<div class="relative sm:flex sm:justify-center lg:flex-col lg:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-green-500 selection:text-white">
    {{ $slot }}
<footer class="py-12 bg-gray-50 dark:bg-gray-800 w-full fixed bottom-0">
    <div class="w-full px-4 mx-auto max-w-8xl">
        <span class="block text-center text-gray-600 dark:text-gray-400 font-">© <a href="https://www.instagram.com/obipranataa/">Obi Pranata</a>. All Rights Reserved.
        </span>
    </div>
</footer>
</div>
</body>
</html>
