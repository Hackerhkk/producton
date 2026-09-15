<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>


<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Register - Library Management System</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script src="https://unpkg.com/lucide@latest"></script>


</head>

<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">


<div class="flex min-h-screen">


    {{-- ================= LEFT PANEL ================= --}}
    <div class="relative hidden overflow-hidden bg-[#2874b9] lg:flex lg:w-1/2">

        <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>

        <div class="absolute -bottom-40 -right-32 h-[500px] w-[500px] rounded-full bg-white/10 blur-3xl"></div>


        <div class="relative z-10 flex w-full flex-col justify-between p-12 xl:p-16">


            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-white">

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

                    Get started today

                </div>


                <h1 class="text-4xl font-bold leading-tight text-white xl:text-5xl">

                    Everything your library needs,

                    <span class="text-blue-100">
                        in one place.
                    </span>

                </h1>


                <p class="mt-5 max-w-md text-sm leading-7 text-blue-100 xl:text-base">

                    Create your account and start managing students,
                    seats, fees and wallets with a simple modern system.

                </p>


                {{-- Features --}}
                <div class="mt-8 space-y-4">

                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i data-lucide="users" class="h-4 w-4"></i>

                        </div>

                        Manage students easily

                    </div>


                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i data-lucide="armchair" class="h-4 w-4"></i>

                        </div>

                        Track library seats

                    </div>


                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i data-lucide="receipt" class="h-4 w-4"></i>

                        </div>

                        Manage monthly fees

                    </div>


                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i data-lucide="wallet" class="h-4 w-4"></i>

                        </div>

                        Track wallet transactions

                    </div>

                </div>

            </div>


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

                <a href="{{ url('/') }}" class="flex items-center gap-3">

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


            {{-- Register Card --}}
            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">


                {{-- Heading --}}
                <div class="mb-7">

                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                        <i data-lucide="user-plus" class="h-5 w-5"></i>

                    </div>


                    <h2 class="text-2xl font-bold tracking-tight text-[#101828]">
                        Create your account
                    </h2>

                    <p class="mt-1.5 text-sm text-[#667085]">
                        Register to start using the library system.
                    </p>

                </div>


                {{-- Register Form --}}
                <form method="POST" action="{{ route('register') }}">

                    @csrf


                    {{-- Name --}}
                    <div>

                        <label
                            for="name"
                            class="mb-1.5 block text-sm font-medium text-[#344054]"
                        >
                            {{ __('Name') }}
                        </label>


                        <div class="relative">

                            <i
                                data-lucide="user-round"
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                            ></i>


                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Enter your name"
                                class="block w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-10 pr-3.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                        </div>


                        @if ($errors->get('name'))

                            <div class="mt-1.5 space-y-1">

                                @foreach ($errors->get('name') as $error)

                                    <p class="text-xs font-medium text-red-600">
                                        {{ $error }}
                                    </p>

                                @endforeach

                            </div>

                        @endif

                    </div>


                    {{-- Email --}}
                    <div class="mt-5">

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
                                autocomplete="new-password"
                                placeholder="Create a password"
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


                    {{-- Confirm Password --}}
                    <div class="mt-5">

                        <label
                            for="password_confirmation"
                            class="mb-1.5 block text-sm font-medium text-[#344054]"
                        >
                            {{ __('Confirm Password') }}
                        </label>


                        <div class="relative">

                            <i
                                data-lucide="shield-check"
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                            ></i>


                            <input
                                id="password_confirmation"
                                name="password_confirmation"
                                type="password"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                                class="block w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-10 pr-3.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                        </div>


                        @if ($errors->get('password_confirmation'))

                            <div class="mt-1.5 space-y-1">

                                @foreach ($errors->get('password_confirmation') as $error)

                                    <p class="text-xs font-medium text-red-600">
                                        {{ $error }}
                                    </p>

                                @endforeach

                            </div>

                        @endif

                    </div>


                    {{-- Register Button --}}
                    <button
                        type="submit"
                        class="mt-6 flex w-full items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/20"
                    >

                        <i data-lucide="user-plus" class="h-4 w-4"></i>

                        {{ __('Create Account') }}

                    </button>

                </form>


                {{-- Login --}}
                <div class="mt-6 border-t border-[#edf0f4] pt-6 text-center">

                    <p class="text-sm text-[#667085]">

                        Already have an account?

                        <a
                            href="{{ route('login') }}"
                            class="ml-1 font-semibold text-[#2874b9] hover:text-[#1f5d94]"
                        >
                            {{ __('Log in') }}
                        </a>

                    </p>

                </div>


            </div>


            {{-- Back Home --}}
            <div class="mt-5 text-center">

                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-[#667085] transition hover:text-[#2874b9]"
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
