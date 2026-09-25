<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Two-Factor Authentication</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="mx-auto w-full max-w-3xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#2874b9] cursor-pointer"
            >
                ← Back to Dashboard
            </a>

            <h1 class="mt-5 text-2xl font-bold text-gray-900">
                Two-Factor Authentication
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Protect your account with Google Authenticator.
            </p>

        </div>

        {{-- Success --}}
        @if (session('success'))

            <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3">

                <p class="text-sm font-medium text-green-700">
                    {{ session('success') }}
                </p>

            </div>

        @endif

        {{-- Errors --}}
        @if ($errors->any())

            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                <ul class="space-y-1 text-sm text-red-700">

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

        {{-- Enabled --}}
        @if ($enabled)

            <div class="rounded-2xl border border-green-200 bg-white p-6 shadow-sm">

                <div class="flex items-start gap-4">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-100">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-green-600"
                        >
                            <path d="M20 6 9 17l-5-5"/>
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            Two-factor authentication is enabled
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Your account is protected by Google Authenticator.
                        </p>

                    </div>

                </div>

                {{-- Disable --}}
                <div class="mt-6 border-t border-gray-100 pt-6">

                    <h3 class="text-sm font-semibold text-gray-900">
                        Disable 2FA
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Enter your account password to disable two-factor authentication.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('two-factor.disable') }}"
                        class="mt-4"
                    >

                        @csrf

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <input
                                type="password"
                                name="password"
                                required
                                placeholder="Account password"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20"
                            >

                            <button
                                type="submit"
                                class="rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white hover:bg-red-700 cursor-pointer"
                            >
                                Disable 2FA
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        @else

            {{-- Setup --}}
            <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

                <div class="grid gap-8 md:grid-cols-2">

                    {{-- QR --}}
                    <div class="flex flex-col items-center">

                        <div class="rounded-2xl border border-gray-200 bg-white p-4">

                            {!! $qrCode !!}

                        </div>

                        <p class="mt-4 text-center text-xs text-gray-500">
                            Scan this QR code using Google Authenticator.
                        </p>

                    </div>

                    {{-- Instructions --}}
                    <div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            Set up Google Authenticator
                        </h2>

                        <ol class="mt-4 space-y-4 text-sm text-gray-600">

                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-[#2874b9]">
                                    1
                                </span>

                                <span>
                                    Install Google Authenticator on your phone.
                                </span>
                            </li>

                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-[#2874b9]">
                                    2
                                </span>

                                <span>
                                    Scan the QR code shown here.
                                </span>
                            </li>

                            <li class="flex gap-3">
                                <span class="flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-blue-50 text-xs font-bold text-[#2874b9]">
                                    3
                                </span>

                                <span>
                                    Enter the 6-digit code generated by the app.
                                </span>
                            </li>

                        </ol>

                        {{-- Manual Secret --}}
                        <div class="mt-6">

                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Can't scan?
                            </p>

                            <div class="mt-2 rounded-xl bg-gray-50 px-4 py-3">

                                <p class="break-all font-mono text-sm font-semibold text-gray-800">
                                    {{ $secretKey }}
                                </p>

                            </div>

                            <p class="mt-2 text-xs text-gray-500">
                                You can manually enter this key in Google Authenticator.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Confirm --}}
                <div class="mt-8 border-t border-gray-100 pt-6">

                    <h3 class="text-sm font-semibold text-gray-900">
                        Verify setup
                    </h3>

                    <p class="mt-1 text-sm text-gray-500">
                        Enter the current 6-digit code to activate 2FA.
                    </p>

                    <form
                        method="POST"
                        action="{{ route('two-factor.confirm') }}"
                        class="mt-4"
                    >

                        @csrf

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <input
                                type="text"
                                name="code"
                                inputmode="numeric"
                                autocomplete="one-time-code"
                                maxlength="6"
                                pattern="[0-9]{6}"
                                required
                                placeholder="6-digit code"
                                class="w-full rounded-xl border border-gray-300 px-4 py-3 text-center text-xl font-semibold tracking-[0.3em] outline-none focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20 sm:max-w-xs"
                            >

                            <button
                                type="submit"
                                class="rounded-xl bg-[#2874b9] px-6 py-3 text-sm font-semibold text-white hover:bg-[#21649f] cursor-pointer"
                            >
                                Enable 2FA
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        @endif

    </div>

</body>

</html>
