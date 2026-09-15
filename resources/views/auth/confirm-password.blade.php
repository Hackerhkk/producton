
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Library Management') }} - Confirm Password</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-[#f7f9fc]">

    <div class="min-h-screen flex">

        <!-- Left Panel -->
        <div class="hidden lg:flex lg:w-[46%] bg-[#2874b9] relative overflow-hidden">

            <!-- Background decoration -->
            <div class="absolute -right-24 -top-24 h-72 w-72 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-32 -left-20 h-80 w-80 rounded-full bg-white/5"></div>

            <div class="relative z-10 flex w-full flex-col justify-between p-10 xl:p-14">

                <!-- Logo -->
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3 w-fit">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 text-white">
                        <i data-lucide="library-big" class="h-6 w-6"></i>
                    </div>

                    <div>
                        <div class="text-lg font-bold text-white">
                            Library Management
                        </div>

                        <div class="text-xs text-white/70">
                            Smart. Simple. Organized.
                        </div>
                    </div>

                </a>

                <!-- Main Content -->
                <div class="max-w-lg">

                    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-2xl bg-white/15">
                        <i data-lucide="shield-check" class="h-7 w-7 text-white"></i>
                    </div>

                    <h1 class="text-4xl font-bold leading-tight text-white xl:text-5xl">
                        Your account is protected.
                    </h1>

                    <p class="mt-5 max-w-md text-base leading-7 text-white/80">
                        For your security, please confirm your password before
                        accessing this protected area of the application.
                    </p>

                    <div class="mt-8 space-y-4">

                        <div class="flex items-center gap-3 text-sm text-white/85">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <i data-lucide="lock-keyhole" class="h-4 w-4"></i>
                            </div>
                            Secure account verification
                        </div>

                        <div class="flex items-center gap-3 text-sm text-white/85">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <i data-lucide="shield-check" class="h-4 w-4"></i>
                            </div>
                            Protects sensitive information
                        </div>

                        <div class="flex items-center gap-3 text-sm text-white/85">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/10">
                                <i data-lucide="user-check" class="h-4 w-4"></i>
                            </div>
                            Verifies your identity
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="text-sm text-white/60">
                    © {{ date('Y') }} Library Management. All rights reserved.
                </div>

            </div>
        </div>

        <!-- Right Panel -->
        <div class="flex w-full items-center justify-center px-5 py-10 sm:px-8 lg:w-[54%]">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="mb-8 lg:hidden">

                    <a href="{{ url('/') }}" class="inline-flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm">
                            <i data-lucide="library-big" class="h-6 w-6"></i>
                        </div>

                        <div>
                            <div class="text-lg font-bold text-[#1f2937]">
                                Library Management
                            </div>

                            <div class="text-xs text-[#667085]">
                                Smart. Simple. Organized.
                            </div>
                        </div>

                    </a>

                </div>

                <!-- Card -->
                <div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">

                    <!-- Heading -->
                    <div class="mb-7">

                        <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                            <i data-lucide="shield-check" class="h-6 w-6"></i>
                        </div>

                        <h2 class="text-2xl font-bold tracking-tight text-[#111827]">
                            Confirm your password
                        </h2>

                        <p class="mt-2 text-sm leading-6 text-[#667085]">
                            This is a secure area of the application.
                            Please confirm your password before continuing.
                        </p>

                    </div>

                    <!-- Form -->
                    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                        @csrf

                        <!-- Password -->
                        <div>

                            <label
                                for="password"
                                class="mb-1.5 block text-sm font-medium text-[#344054]"
                            >
                                {{ __('Password') }}
                            </label>

                            <div class="relative">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#98a2b3]">
                                    <i data-lucide="lock-keyhole" class="h-4.5 w-4.5"></i>
                                </div>

                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    required
                                    autofocus
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

                        <!-- Confirm Button -->
                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/20"
                        >
                            <i data-lucide="shield-check" class="h-4 w-4"></i>
                            {{ __('Confirm Password') }}
                        </button>

                    </form>

                    <!-- Back to Dashboard -->
                    <div class="mt-6 border-t border-[#edf0f4] pt-5 text-center">

                        <a
                            href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-1.5 text-sm font-semibold text-[#2874b9] hover:text-[#1f5d94]"
                        >
                            <i data-lucide="arrow-left" class="h-4 w-4"></i>
                            Back to dashboard
                        </a>

                    </div>

                </div>

                <!-- Home -->
                <div class="mt-6 text-center">

                    <a
                        href="{{ url('/') }}"
                        class="inline-flex items-center gap-1.5 text-sm text-[#667085] transition hover:text-[#2874b9]"
                    >
                        <i data-lucide="house" class="h-4 w-4"></i>
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

