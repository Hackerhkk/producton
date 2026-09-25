<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">

</head>

<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">

<div class="flex min-h-screen">

{{-- ================= LEFT PANEL ================= --}}
<div class="relative hidden overflow-hidden bg-[#2874b9] lg:flex lg:w-1/2">

    <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
    <div class="absolute -bottom-40 -right-32 h-[500px] w-[500px] rounded-full bg-white/10 blur-3xl"></div>

    <div class="relative z-10 flex w-full flex-col justify-between p-12 xl:p-16">

        {{-- Logo --}}
        <a href="{{ url('/') }}" class="flex items-center gap-3 text-white cursor-pointer">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 backdrop-blur">
                <i data-lucide="library-big" class="h-6 w-6"></i>
            </div>

            <div>
                <div class="text-base font-bold">
                    Library Management
                </div>

                <div class="text-xs text-blue-100">
                    Smart Library System
                </div>
            </div>
        </a>

        {{-- Center Content --}}
        <div class="max-w-lg">

            <div class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-1.5 text-xs font-medium text-blue-50">
                <span class="h-1.5 w-1.5 rounded-full bg-white"></span>
                Welcome back
            </div>

            <h1 class="text-4xl font-bold leading-tight text-white xl:text-5xl">
                Manage your library
                <span class="text-blue-100">
                    with confidence.
                </span>
            </h1>

            <p class="mt-5 max-w-md text-sm leading-7 text-blue-100 xl:text-base">
                Manage students, seats, fees and wallets from one simple
                and organized library management system.
            </p>

            {{-- Features --}}
            <div class="mt-8 space-y-4">

                <div class="flex items-center gap-3 text-sm text-white">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                        <i data-lucide="users" class="h-4 w-4"></i>
                    </div>
                    Student management
                </div>

                <div class="flex items-center gap-3 text-sm text-white">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                        <i data-lucide="armchair" class="h-4 w-4"></i>
                    </div>
                    Smart seat management
                </div>

                <div class="flex items-center gap-3 text-sm text-white">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">
                        <i data-lucide="wallet" class="h-4 w-4"></i>
                    </div>
                    Fees & wallet tracking
                </div>

            </div>
        </div>

        {{-- Footer --}}
        <p class="text-xs text-blue-100">
            © {{ date('Y') }} Library Management System
        </p>

    </div>
</div>

{{-- ================= RIGHT PANEL ================= --}}
<div class="flex w-full items-center justify-center px-5 py-10 sm:px-8 lg:w-1/2">

    <div class="w-full max-w-md">

        {{-- Mobile Logo --}}
        <div class="mb-8 flex justify-center lg:hidden">

            <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm">
                    <i data-lucide="library-big" class="h-6 w-6"></i>
                </div>

                <div>
                    <div class="text-base font-bold text-[#172033]">
                        Library Management
                    </div>

                    <div class="text-xs text-[#667085]">
                        Smart Library System
                    </div>
                </div>

            </a>

        </div>

        {{-- Login Card --}}
        <div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">

            {{-- Heading --}}
            <div class="mb-7">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                    <i data-lucide="log-in" class="h-5 w-5"></i>
                </div>

                <h2 class="text-2xl font-bold tracking-tight text-[#101828]">
                    Welcome back
                </h2>

                <p class="mt-1.5 text-sm text-[#667085]">
                    Sign in to access your library dashboard.
                </p>

            </div>

            {{-- ================= SESSION EXPIRED MESSAGE ================= --}}
            @if (session('error'))

                <div
                    id="sessionError"
                    class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3.5"
                >

                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">
                        <i data-lucide="shield-alert" class="h-4 w-4"></i>
                    </div>

                    <div class="min-w-0 flex-1">

                        <p class="text-sm font-semibold text-red-800">
                            Session ended
                        </p>

                        <p class="mt-0.5 text-xs leading-5 text-red-700">
                            {{ session('error') }}
                        </p>

                    </div>

                    <button
                        type="button"
                        onclick="document.getElementById('sessionError')?.remove()"
                        class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-red-500 transition hover:bg-red-100 hover:text-red-700 cursor-pointer"
                        aria-label="Close notification"
                    >
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>

                </div>

            @endif

            {{-- Session Status --}}
            <x-auth-session-status
                class="mb-5"
                :status="session('status')"
            />

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div>

                    <label
                        for="email"
                        class="mb-1.5 block text-sm font-medium text-[#344054]"
                    >
                        {{ __('Email') }}
                    </label>

                    <div class="relative">

                        <i
                            data-lucide="mail"
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                        ></i>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Enter your email"
                            class="block w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-10 pr-3.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >

                    </div>

                    @if ($errors->get('email'))

                        <div class="mt-1.5 space-y-1">

                            @foreach ($errors->get('email') as $error)

                                <p class="text-xs font-medium text-red-600">
                                    {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    @endif

                </div>

                {{-- Password --}}
                <div class="mt-5">

                    <label
                        for="password"
                        class="mb-1.5 block text-sm font-medium text-[#344054]"
                    >
                        {{ __('Password') }}
                    </label>

                    <div class="relative">

                        <i
                            data-lucide="lock-keyhole"
                            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                        ></i>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            class="block w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-10 pr-3.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >

                    </div>

                    @if ($errors->get('password'))

                        <div class="mt-1.5 space-y-1">

                            @foreach ($errors->get('password') as $error)

                                <p class="text-xs font-medium text-red-600">
                                    {{ $error }}
                                </p>

                            @endforeach

                        </div>

                    @endif

                </div>

                {{-- Remember + Forgot --}}
                <div class="mt-5 flex items-center justify-between gap-3">

                    <label class="flex cursor-pointer items-center gap-2">

                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-[#d0d5dd] text-[#2874b9] shadow-sm focus:ring-2 focus:ring-[#2874b9]/20"
                        >

                        <span class="text-sm text-[#667085]">
                            {{ __('Remember me') }}
                        </span>

                    </label>

                    @if (Route::has('password.request'))

                        <a
                            href="{{ route('password.request') }}"
                            class="text-sm font-semibold text-[#2874b9] transition hover:text-[#1f5d94] cursor-pointer"
                        >
                            {{ __('Forgot password?') }}
                        </a>

                    @endif

                </div>

                {{-- Login Button --}}
                <button
                    type="submit"
                    class="mt-6 flex w-full items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/20 cursor-pointer"
                >
                    <i data-lucide="log-in" class="h-4 w-4"></i>
                    {{ __('Log in') }}
                </button>

            </form>

            {{-- Register --}}
            @if (Route::has('register'))

                <div class="mt-6 border-t border-[#edf0f4] pt-6 text-center">

                    <p class="text-sm text-[#667085]">

                        Don't have an account?

                        <a
                            href="{{ route('register') }}"
                            class="ml-1 font-semibold text-[#2874b9] hover:text-[#1f5d94] cursor-pointer"
                        >
                            Create an account
                        </a>

                    </p>

                </div>

            @endif

        </div>

        {{-- Back Home --}}
        <div class="mt-5 text-center">

            <a
                href="{{ url('/') }}"
                class="inline-flex items-center gap-1.5 text-sm text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="arrow-left" class="h-3.5 w-3.5"></i>
                Back to home
            </a>

        </div>

    </div>

</div>

</div>

<script>
    lucide.createIcons();
</script>

</body>
</html>
