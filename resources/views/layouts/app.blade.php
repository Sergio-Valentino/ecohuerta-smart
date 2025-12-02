<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EcoHuerta Smart</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-100">

<div class="flex min-h-screen">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-green-700 text-white shadow-md">
        @include('livewire.dashboard.sidebar')
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="flex flex-col flex-1">

        <!-- TOPBAR -->
        <header class="bg-white shadow">
            @include('livewire.dashboard.topbar')
        </header>

        <!-- ÁREA DE CONTENIDO -->
        <main class="p-8">
            {{ $slot }}
        </main>

    </div>

</div>

@livewireScripts
</body>
</html>