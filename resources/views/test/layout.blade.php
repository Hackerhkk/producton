<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Tests') - {{ config('app.name', 'Library Management') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">


    @stack('styles')
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


<body class="min-h-screen bg-[#f7f9fc] text-[#1f2937]">

           {{-- ================= PAGE LOADER ================= --}}
<div id="pageLoader" class="fixed inset-0 z-[99999] bg-white">
    <div class="loader"></div>
</div>
    {{-- Same User Navbar as Dashboard --}}
    @include('partials.user-navbar')


    {{-- Page Content --}}
    <main>

        @yield('content')

    </main>


    @stack('scripts')


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        });

    </script>
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
