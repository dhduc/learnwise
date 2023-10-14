<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite([
    "node_modules/fastbootstrap/dist/css/fastbootstrap.min.css",
    "resources/css/app.css",
    "resources/js/app.js",
    ])
</head>

<body>
    @include('layouts.navigations.navigation')

    <div class="layout">
        @include('layouts.navigations.sidebarnav')
        <main class="p-5 bg-neutral-10">
            {{ $slot }}
        </main>
    </div>
</body>

</html>