<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Standard PNG Favicon -->
<link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
.loader {
    position: absolute;
    top: calc(50% - 1.25em);
    left: calc(50% - 1.25em);

    width: 2.5em;
    height: 2.5em;

    transform: rotate(165deg);
}

.loader:before,
.loader:after {
    content: "";

    position: absolute;
    top: 50%;
    left: 50%;

    display: block;

    width: 0.5em;
    height: 0.5em;

    border-radius: 0.25em;

    transform: translate(-50%, -50%);
}

.loader:before {
    animation: before8 2s infinite;
}

.loader:after {
    animation: after6 2s infinite;
}

@keyframes before8 {
    0% {
        width: 0.5em;
        box-shadow:
            1em -0.5em rgba(225, 20, 98, 0.75),
            -1em 0.5em rgba(111, 202, 220, 0.75);
    }

    35% {
        width: 2.5em;
        box-shadow:
            0 -0.5em rgba(225, 20, 98, 0.75),
            0 0.5em rgba(111, 202, 220, 0.75);
    }

    70% {
        width: 0.5em;
        box-shadow:
            -1em -0.5em rgba(225, 20, 98, 0.75),
            1em 0.5em rgba(111, 202, 220, 0.75);
    }

    100% {
        box-shadow:
            1em -0.5em rgba(225, 20, 98, 0.75),
            -1em 0.5em rgba(111, 202, 220, 0.75);
    }
}

@keyframes after6 {
    0% {
        height: 0.5em;
        box-shadow:
            0.5em 1em rgba(61, 184, 143, 0.75),
            -0.5em -1em rgba(233, 169, 32, 0.75);
    }

    35% {
        height: 2.5em;
        box-shadow:
            0.5em 0 rgba(61, 184, 143, 0.75),
            -0.5em 0 rgba(233, 169, 32, 0.75);
    }

    70% {
        height: 0.5em;
        box-shadow:
            0.5em -1em rgba(61, 184, 143, 0.75),
            -0.5em 1em rgba(233, 169, 32, 0.75);
    }

    100% {
        box-shadow:
            0.5em 1em rgba(61, 184, 143, 0.75),
            -0.5em -1em rgba(233, 169, 32, 0.75);
    }
}

        </style>
    </head>
    <body class="font-sans antialiased">

        {{-- ================= PAGE LOADER ================= --}}
<div id="pageLoader" class="fixed inset-0 z-[99999] bg-white">
    <div class="loader"></div>
</div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const loader = document.getElementById('pageLoader');

    if (!loader) {
        return;
    }

    loader.style.transition = 'opacity 0.3s ease';
    loader.style.opacity = '0';

    setTimeout(function () {
        loader.remove();
    }, 300);

});
</script>

    </body>
</html>
