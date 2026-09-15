
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - {{ config('app.name', 'Library Management') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>

</head>

<body class="min-h-screen bg-[#f7f9fc] text-[#1f2937]">

    <!-- Navbar -->
    <nav class="border-b border-[#e4e8ef] bg-white">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            <div class="flex h-16 items-center justify-between">

                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9] text-white">
                        <i data-lucide="library-big" class="h-5 w-5"></i>
                    </div>

                    <div class="hidden sm:block">

                        <div class="text-base font-bold text-[#1f2937]">
                            SR Library
                        </div>

                        <div class="text-[11px] text-[#667085]">
                            Library Management
                        </div>

                    </div>

                </a>


                <!-- Right -->
                <div class="flex items-center gap-3">

                    <a
                        href="{{ route('profile.edit') }}"
                        class="hidden items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f7fa] hover:text-[#2874b9] sm:flex"
                    >

                        <i data-lucide="user-round" class="h-4 w-4"></i>

                        Profile

                    </a>


                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 rounded-lg border border-[#e4e8ef] bg-white px-3 py-2 text-sm font-semibold text-[#667085] transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                        >

                            <i data-lucide="log-out" class="h-4 w-4"></i>

                            <span class="hidden sm:inline">
                                Logout
                            </span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </nav>


    <!-- Main -->
    <main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">


        <!-- Header -->
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h1 class="text-2xl font-bold tracking-tight text-[#111827]">
                    Dashboard
                </h1>

                <p class="mt-1 text-sm text-[#667085]">
                    Welcome back, {{ auth()->user()->name }}.
                </p>

            </div>


            <!-- User -->
            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#eef6ff] text-[#2874b9]">
                    <i data-lucide="user-round" class="h-5 w-5"></i>
                </div>

                <div>

                    <p class="text-sm font-semibold text-[#1f2937]">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-[#667085]">
                        Library User
                    </p>

                </div>

            </div>

        </div>


        <!-- Welcome -->
        <div class="mb-6 overflow-hidden rounded-2xl bg-[#2874b9] shadow-sm">

            <div class="relative px-6 py-7 sm:px-8">

                <div class="absolute -right-16 -top-20 h-56 w-56 rounded-full bg-white/10"></div>

                <div class="absolute -bottom-28 right-24 h-56 w-56 rounded-full bg-white/5"></div>


                <div class="relative z-10 max-w-2xl">

                    <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-white/15">

                        <i data-lucide="library-big" class="h-6 w-6 text-white"></i>

                    </div>

                    <h2 class="text-xl font-bold text-white sm:text-2xl">
                        Welcome to SR Library
                    </h2>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-white/80">
                        Manage your account and access your library services
                        from one simple dashboard.
                    </p>

                </div>

            </div>

        </div>


        <!-- Quick Actions -->
        <div class="mb-6">

            <div class="mb-4">

                <h2 class="text-lg font-semibold text-[#1f2937]">
                    Quick Actions
                </h2>

                <p class="mt-1 text-sm text-[#667085]">
                    Manage your account quickly.
                </p>

            </div>


            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">


                <!-- Profile -->
                <a
                    href="{{ route('profile.edit') }}"
                    class="group rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#2874b9]/30 hover:shadow-md"
                >

                    <div class="flex items-start justify-between">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                            <i data-lucide="user-round" class="h-5 w-5"></i>

                        </div>

                        <i
                            data-lucide="arrow-up-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:text-[#2874b9]"
                        ></i>

                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-[#1f2937]">
                        My Profile
                    </h3>

                    <p class="mt-1 text-sm leading-5 text-[#667085]">
                        Update your name, email and account information.
                    </p>

                </a>


                <!-- Account -->
                <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#f0fdf4] text-green-600">

                        <i data-lucide="shield-check" class="h-5 w-5"></i>

                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-[#1f2937]">
                        Account Status
                    </h3>

                    <div class="mt-2 flex items-center gap-2">

                        <span class="h-2 w-2 rounded-full bg-green-500"></span>

                        <span class="text-sm font-semibold text-green-600">
                            Active
                        </span>

                    </div>

                    <p class="mt-1 text-sm text-[#667085]">
                        Your account is currently active.
                    </p>

                </div>


                <!-- Security -->
                <a
                    href="{{ route('profile.edit') }}"
                    class="group rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-[#2874b9]/30 hover:shadow-md"
                >

                    <div class="flex items-start justify-between">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#fff7ed] text-orange-600">

                            <i data-lucide="lock-keyhole" class="h-5 w-5"></i>

                        </div>

                        <i
                            data-lucide="arrow-up-right"
                            class="h-4 w-4 text-[#98a2b3] transition group-hover:text-[#2874b9]"
                        ></i>

                    </div>

                    <h3 class="mt-4 text-sm font-semibold text-[#1f2937]">
                        Account Security
                    </h3>

                    <p class="mt-1 text-sm leading-5 text-[#667085]">
                        Manage your password and security settings.
                    </p>

                </a>

            </div>

        </div>


        <!-- Account Information -->
        <div class="overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

            <div class="border-b border-[#edf0f4] px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                        <i data-lucide="circle-user-round" class="h-5 w-5"></i>

                    </div>

                    <div>

                        <h2 class="text-base font-semibold text-[#1f2937]">
                            Account Information
                        </h2>

                        <p class="mt-0.5 text-sm text-[#667085]">
                            Your registered account details.
                        </p>

                    </div>

                </div>

            </div>


            <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-3">


                <!-- Name -->
                <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-4">

                    <div class="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-[#98a2b3]">

                        <i data-lucide="user" class="h-4 w-4"></i>

                        Name

                    </div>

                    <p class="mt-2 text-sm font-semibold text-[#1f2937]">
                        {{ auth()->user()->name }}
                    </p>

                </div>


                <!-- Email -->
                <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-4">

                    <div class="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-[#98a2b3]">

                        <i data-lucide="mail" class="h-4 w-4"></i>

                        Email

                    </div>

                    <p class="mt-2 break-all text-sm font-semibold text-[#1f2937]">
                        {{ auth()->user()->email }}
                    </p>

                </div>


                <!-- Role -->
                <div class="rounded-xl border border-[#edf0f4] bg-[#fafbfc] p-4">

                    <div class="flex items-center gap-2 text-xs font-medium uppercase tracking-wide text-[#98a2b3]">

                        <i data-lucide="badge-check" class="h-4 w-4"></i>

                        Account Type

                    </div>

                    <p class="mt-2 text-sm font-semibold capitalize text-[#1f2937]">
                        {{ auth()->user()->role ?? 'User' }}
                    </p>

                </div>

            </div>

        </div>


    </main>


    <script>
        lucide.createIcons();
    </script>

</body>

</html>

