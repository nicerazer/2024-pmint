<!DOCTYPE html>
<html data-theme="cupcake">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Log Kerja') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen antialiased bg-sky-50">

    <x-layouts.navbar-main />


    @if (request()->route()->getName() == 'home')
        {{ $header }}
        <main class="flex w-8/12 mx-auto my-8">
            {{ $slot }}
        </main>
    @else
        <main class="flex w-11/12 mx-auto my-8">
            {{ $slot }}
        </main>
    @endif
    @livewireScripts
</body>

</html>
