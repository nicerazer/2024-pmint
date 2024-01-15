@php
    use Illuminate\Support\Facades\Route;
@endphp

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
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body @class([
    'min-h-screen antialiased',
    'bg-white' => Route::currentRouteName() == 'workLogs.create',
    'bg-sky-50' => Route::currentRouteName() != 'workLogs.create',
])>

    @if (Route::currentRouteName() == 'workLogs.create')
        <x-layouts.navbar-worklogs-create />
    @else
        <x-layouts.navbar-main />
    @endif

    <main class="flex flex-col w-11/12 py-4 mx-auto">
        {{ $slot }}
    </main>

    @livewireScriptConfig
    @stack('scripts')
</body>

</html>
