<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>Two-Factor Authentication - Library Management System</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

</head>

<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">

<div class="flex min-h-screen">

    {{-- ========================================================= --}}
    {{-- LEFT PANEL --}}
    {{-- ========================================================= --}}

    <div class="relative hidden overflow-hidden bg-[#2874b9] lg:flex lg:w-1/2">

        {{-- Decorative Background --}}
        <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>

        <div class="absolute -bottom-40 -right-32 h-[500px] w-[500px] rounded-full bg-white/10 blur-3xl"></div>


        <div class="relative z-10 flex w-full flex-col justify-between p-12 xl:p-16">

            {{-- Logo --}}
            <a
                href="{{ url('/') }}"
                class="flex items-center gap-3 text-white cursor-pointer"
            >

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-white/15 backdrop-blur">

                    <i
                        data-lucide="library-big"
                        class="h-6 w-6"
                    ></i>

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

                    Account Security

                </div>


                <h1 class="text-4xl font-bold leading-tight text-white xl:text-5xl">

                    Protect your account
                    <span class="text-blue-100">
                        with two-factor authentication.
                    </span>

                </h1>


                <p class="mt-5 max-w-md text-sm leading-7 text-blue-100 xl:text-base">

                    Enter the verification code from your
                    Google Authenticator app to securely
                    continue to your dashboard.

                </p>


                {{-- Security Features --}}
                <div class="mt-8 space-y-4">

                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i
                                data-lucide="shield-check"
                                class="h-4 w-4"
                            ></i>

                        </div>

                        Secure account verification

                    </div>


                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i
                                data-lucide="smartphone"
                                class="h-4 w-4"
                            ></i>

                        </div>

                        Google Authenticator protection

                    </div>


                    <div class="flex items-center gap-3 text-sm text-white">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10">

                            <i
                                data-lucide="lock-keyhole"
                                class="h-4 w-4"
                            ></i>

                        </div>

                        Additional login security

                    </div>

                </div>

            </div>


            {{-- Footer --}}
            <p class="text-xs text-blue-100">

                © {{ date('Y') }} Library Management System

            </p>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RIGHT PANEL --}}
    {{-- ========================================================= --}}

    <div class="flex w-full items-center justify-center px-5 py-10 sm:px-8 lg:w-1/2">

        <div class="w-full max-w-md">


            {{-- ================================================= --}}
            {{-- MOBILE LOGO --}}
            {{-- ================================================= --}}

            <div class="mb-8 flex justify-center lg:hidden">

                <a
                    href="{{ url('/') }}"
                    class="flex items-center gap-3 cursor-pointer"
                >

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm">

                        <i
                            data-lucide="library-big"
                            class="h-6 w-6"
                        ></i>

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


            {{-- ================================================= --}}
            {{-- 2FA CARD --}}
            {{-- ================================================= --}}

            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">


                {{-- Heading --}}
                <div class="mb-7">

                    <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                        <i
                            data-lucide="shield-check"
                            class="h-5 w-5"
                        ></i>

                    </div>


                    <h2 class="text-2xl font-bold tracking-tight text-[#101828]">

                        Two-Factor Authentication

                    </h2>


                    <p class="mt-1.5 text-sm leading-6 text-[#667085]">

                        Enter the 6-digit verification code from
                        your Google Authenticator app.

                    </p>

                </div>


                {{-- ================================================= --}}
                {{-- ERRORS --}}
                {{-- ================================================= --}}

                @if ($errors->any())

                    <div
                        class="mb-5 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3.5"
                    >

                        <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">

                            <i
                                data-lucide="shield-alert"
                                class="h-4 w-4"
                            ></i>

                        </div>


                        <div class="min-w-0 flex-1">

                            <p class="text-sm font-semibold text-red-800">

                                Verification failed

                            </p>


                            <div class="mt-0.5 space-y-0.5">

                                @foreach ($errors->all() as $error)

                                    <p class="text-xs leading-5 text-red-700">

                                        {{ $error }}

                                    </p>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- 2FA FORM --}}
                {{-- ================================================= --}}

                <form
                    method="POST"
                    action="{{ route('two-factor.verify') }}"
                >

                    @csrf


                    {{-- Authentication Code --}}
                    <div>

                        <label
                            for="code"
                            class="mb-1.5 block text-sm font-medium text-[#344054]"
                        >

                            Authentication Code

                        </label>


                        <div class="relative">

                            <i
                                data-lucide="key-round"
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                            ></i>


                            <input
                                id="code"
                                name="code"
                                type="text"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                required
                                autofocus
                                value="{{ old('code') }}"
                                placeholder="000000"
                                class="block w-full rounded-lg border border-[#d0d5dd] bg-white py-3 pl-10 pr-3.5 text-center text-xl font-semibold tracking-[0.45em] text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                        </div>


                        <p class="mt-2 text-xs leading-5 text-[#667085]">

                            Open Google Authenticator and enter the
                            current 6-digit code.

                        </p>

                    </div>


                    {{-- Verify Button --}}
                    <button
                        type="submit"
                        class="mt-6 flex w-full items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/20 cursor-pointer"
                    >

                        <i
                            data-lucide="shield-check"
                            class="h-4 w-4"
                        ></i>

                        Verify & Continue

                    </button>

                </form>


                {{-- ================================================= --}}
                {{-- RECOVERY CODE --}}
                {{-- ================================================= --}}

                <div class="mt-6 border-t border-[#edf0f4] pt-6">

                    <div class="rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-white text-[#2874b9] shadow-sm">

                                <i
                                    data-lucide="key-round"
                                    class="h-4 w-4"
                                ></i>

                            </div>


                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-[#344054]">

                                    Can't access your authenticator?

                                </p>


                                <p class="mt-1 text-xs leading-5 text-[#667085]">

                                    You can use one of your saved recovery
                                    codes to sign in.

                                </p>


                                <a
                                    href="{{ route('two-factor.recovery-challenge') }}"
                                    class="mt-2 inline-flex items-center gap-1.5 text-sm font-semibold text-[#2874b9] transition hover:text-[#1f5d94] cursor-pointer"
                                >

                                    Use a recovery code

                                    <i
                                        data-lucide="arrow-right"
                                        class="h-3.5 w-3.5"
                                    ></i>

                                </a>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BACK TO LOGIN --}}
                {{-- ================================================= --}}

                <div class="mt-6 text-center">

                    <a
                        href="{{ route('login') }}"
                        class="inline-flex items-center gap-1.5 text-sm font-medium text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
                    >

                        <i
                            data-lucide="arrow-left"
                            class="h-3.5 w-3.5"
                        ></i>

                        Back to Login

                    </a>

                </div>

            </div>


            {{-- Back Home --}}
            <div class="mt-5 text-center">

                <a
                    href="{{ url('/') }}"
                    class="inline-flex items-center gap-1.5 text-sm text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
                >

                    <i
                        data-lucide="arrow-left"
                        class="h-3.5 w-3.5"
                    ></i>

                    Back to home

                </a>

            </div>

        </div>

    </div>

</div>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

    });

</script>

</body>

</html>
