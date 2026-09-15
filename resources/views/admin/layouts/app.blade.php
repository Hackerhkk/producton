<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

    
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

    <div id="sidebarOverlay"
         class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden"
         onclick="toggleSidebar()">
    </div>

    @include('admin.partials.sidebar')

    <div class="min-h-screen lg:pl-[304px]">

        @include('admin.partials.navbar')

        <main class="px-4 py-6 sm:px-6 lg:px-7">

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

</body>
</html>