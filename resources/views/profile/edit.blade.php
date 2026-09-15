
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Profile Settings - {{ config('app.name', 'SR Library') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-[#f8fafc] font-sans text-[#1f2937]">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 border-b border-[#e4e8ef] bg-white">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

            <!-- Logo -->
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm">
                    <i data-lucide="library-big" class="h-5 w-5"></i>
                </div>

                <div class="hidden sm:block">
                    <div class="text-base font-bold tracking-tight text-[#1f2937]">
                        SR Library
                    </div>

                    <div class="text-[11px] text-[#667085]">
                        Library Management
                    </div>
                </div>
            </a>


            <!-- Right Side -->
            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-sm font-medium text-[#344054] transition hover:bg-[#f9fafb]">

                    <i data-lucide="layout-dashboard" class="h-4 w-4"></i>

                    <span class="hidden sm:inline">
                        Dashboard
                    </span>
                </a>


                <!-- User -->
                <div class="hidden items-center gap-2 border-l border-[#e4e8ef] pl-3 sm:flex">

                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#eef6ff] text-sm font-semibold text-[#2874b9]">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>

                    <div class="max-w-[140px]">
                        <div class="truncate text-sm font-semibold text-[#1f2937]">
                            {{ Auth::user()->name }}
                        </div>

                        <div class="text-xs text-[#667085]">
                            User Account
                        </div>
                    </div>

                </div>


                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50">

                        <i data-lucide="log-out" class="h-4 w-4"></i>

                        <span class="hidden sm:inline">
                            Logout
                        </span>
                    </button>
                </form>

            </div>

        </div>
    </header>


    <!-- Main Content -->
    <main class="mx-auto max-w-5xl px-4 py-8 sm:px-6 lg:px-8">

        <!-- Page Header -->
        <div class="mb-6">

            <div class="flex items-center gap-2">

                <a href="{{ route('dashboard') }}"
                   class="text-sm font-medium text-[#667085] hover:text-[#2874b9]">
                    Dashboard
                </a>

                <i data-lucide="chevron-right"
                   class="h-4 w-4 text-[#98a2b3]"></i>

                <span class="text-sm font-medium text-[#344054]">
                    Profile
                </span>

            </div>


            <div class="mt-4">

                <h1 class="text-2xl font-bold tracking-tight text-[#111827] sm:text-3xl">
                    Profile Settings
                </h1>

                <p class="mt-1 text-sm text-[#667085]">
                    Manage your account information, password and security.
                </p>

            </div>

        </div>


        <!-- Profile Information -->
        <div class="mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

            <div class="flex items-center gap-4 border-b border-[#edf0f4] px-5 py-4 sm:px-6">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                    <i data-lucide="user-round" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-[#1f2937]">
                        Profile Information
                    </h2>

                    <p class="mt-0.5 text-sm text-[#667085]">
                        Update your name and email address.
                    </p>
                </div>

            </div>


            <div class="p-5 sm:p-6">

                <div class="max-w-2xl">

                    @include('profile.partials.update-profile-information-form')

                </div>

            </div>

        </div>


        <!-- Password -->
        <div class="mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

            <div class="flex items-center gap-4 border-b border-[#edf0f4] px-5 py-4 sm:px-6">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                    <i data-lucide="lock-keyhole" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-[#1f2937]">
                        Update Password
                    </h2>

                    <p class="mt-0.5 text-sm text-[#667085]">
                        Use a strong password to keep your account secure.
                    </p>
                </div>

            </div>


            <div class="p-5 sm:p-6">

                <div class="max-w-2xl">

                    @include('profile.partials.update-password-form')

                </div>

            </div>

        </div>


        <!-- Delete Account -->
        <div class="overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm">

            <div class="flex items-center gap-4 border-b border-red-100 bg-red-50/40 px-5 py-4 sm:px-6">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600">
                    <i data-lucide="shield-alert" class="h-5 w-5"></i>
                </div>

                <div>
                    <h2 class="text-base font-semibold text-[#1f2937]">
                        Delete Account
                    </h2>

                    <p class="mt-0.5 text-sm text-[#667085]">
                        Permanently delete your account and all associated data.
                    </p>
                </div>

            </div>


            <div class="p-5 sm:p-6">

                <div class="max-w-2xl">

                    @include('profile.partials.delete-user-form')

                </div>

            </div>

        </div>

    </main>


    <!-- Footer -->
    <footer class="border-t border-[#e4e8ef] bg-white">
        <div class="mx-auto max-w-7xl px-4 py-5 text-center text-xs text-[#667085] sm:px-6 lg:px-8">

            © {{ date('Y') }} SR Library. All rights reserved.

        </div>
    </footer>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>

</body>
</html>

