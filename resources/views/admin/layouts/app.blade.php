<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">



    
<!-- =========================================================
     CUSTOM CLASSES
========================================================= -->

<style>

    .sidebar-item {
        display: flex;
        height: 48px;
        align-items: center;
        gap: 16px;
        border-radius: 12px;
        padding-left: 16px;
        padding-right: 12px;
        color: #344054;
        font-size: 15px;
        font-weight: 500;
        transition: 0.15s;
    }

    .sidebar-item:hover {
        background: #f5f8fb;
        color: #2168ae;
    }

    .sidebar-item svg {
        width: 21px;
        height: 21px;
        stroke-width: 1.8;
    }


    .stat-card {
        min-height: 194px;
        border: 1px solid #e6eaf0;
        background: white;
        border-radius: 18px;
        padding: 23px;
        box-shadow: 0 1px 3px rgba(16,24,40,0.025);
    }


    .large-stat-card {
        min-height: 194px;
        border: 1px solid #e6eaf0;
        background: white;
        border-radius: 18px;
        padding: 23px;
        box-shadow: 0 1px 3px rgba(16,24,40,0.025);
    }


    .icon-box {
        display: flex;
        height: 49px;
        width: 49px;
        align-items: center;
        justify-content: center;
        border-radius: 13px;
    }

    .icon-box svg {
        width: 22px;
        height: 22px;
        stroke-width: 1.8;
    }


    .stat-title {
        margin-top: 16px;
        font-size: 12px;
        font-weight: 500;
        letter-spacing: 0.04em;
        color: #8190a6;
    }


    .stat-number {
        margin-top: 5px;
        font-size: 28px;
        line-height: 1.1;
        font-weight: 800;
        color: #111827;
    }


    .stat-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 12px;
        color: #8a98ab;
        font-size: 12px;
    }

    .stat-bottom svg {
        width: 15px;
        height: 15px;
    }


    @media (max-width: 640px) {

        .stat-card,
        .large-stat-card {
            min-height: 175px;
            padding: 19px;
        }

        .stat-number {
            font-size: 25px;
        }

    }


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


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

    lucide.createIcons();


    function toggleSidebar() {

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        const isClosed = sidebar.classList.contains('-translate-x-full');

        if (isClosed) {

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');

        } else {

            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');

        }

    }


    // Close mobile sidebar when window becomes desktop
    window.addEventListener('resize', function () {

        if (window.innerWidth >= 1024) {

            document
                .getElementById('sidebar')
                .classList.remove('-translate-x-full');

            document
                .getElementById('sidebarOverlay')
                .classList.add('hidden');

        } else {

            document
                .getElementById('sidebar')
                .classList.add('-translate-x-full');

        }

    });

</script>
</head>

<body class="bg-[#f7f9fc] text-[#172033]">


{{-- ================= PAGE LOADER ================= --}}
<div id="pageLoader" class="fixed inset-0 z-[99999] bg-white">
    <div class="loader"></div>
</div>




    <div id="sidebarOverlay"
         class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden"
         onclick="toggleSidebar()">
    </div>

    @include('admin.partials.sidebar')

<div class="min-h-screen min-w-0 lg:pl-[304px]">
        @include('admin.partials.navbar')

        <main class="min-w-0 px-4 py-6 sm:px-6 lg:px-7">
    @yield('content')
</main>

    </div>

    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            const isClosed = sidebar.classList.contains('-translate-x-full');

            if (isClosed) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                document.getElementById('sidebar')
                    .classList.remove('-translate-x-full');

                document.getElementById('sidebarOverlay')
                    .classList.add('hidden');
            } else {
                document.getElementById('sidebar')
                    .classList.add('-translate-x-full');
            }
        });
    </script>
    @stack('scripts')

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