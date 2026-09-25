<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        Profile Settings - {{ config('app.name', 'SR Library') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

</head>


<body class="min-h-screen bg-[#f8fafc] font-sans text-[#1f2937]">

    {{-- ================= SHARED NAVBAR ================= --}}
    @include('partials.user-navbar')


    {{-- ================= MAIN CONTENT ================= --}}
    <main
        class="mx-auto max-w-5xl px-4 py-8 pb-28 sm:px-6 lg:px-8 min-[816px]:pb-8"
    >

        {{-- ================= PAGE HEADER ================= --}}
        <div class="mb-6">

            {{-- Breadcrumb --}}
            <div class="flex items-center gap-2">

                <a
                    href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-[#667085] transition hover:text-[#2874b9] cursor-pointer"
                >
                    Dashboard
                </a>

                <i
                    data-lucide="chevron-right"
                    class="h-4 w-4 text-[#98a2b3]"
                ></i>

                <span class="text-sm font-medium text-[#344054]">
                    Profile
                </span>

            </div>


            {{-- Heading --}}
            <div class="mt-4">

                <h1
                    class="text-2xl font-bold tracking-tight text-[#111827] sm:text-3xl"
                >
                    Profile Settings
                </h1>

                <p class="mt-1 text-sm text-[#667085]">
                    Manage your account information, password and security.
                </p>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- PROFILE INFORMATION --}}
        {{-- ========================================================= --}}
        <div
            class="mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm"
        >

            {{-- Header --}}
            <div
                class="flex items-center gap-4 border-b border-[#edf0f4] px-5 py-4 sm:px-6"
            >

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]"
                >
                    <i
                        data-lucide="user-round"
                        class="h-5 w-5"
                    ></i>
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


            {{-- Content --}}
            <div class="p-5 sm:p-6">

                <div class="max-w-2xl">

                    @include(
                        'profile.partials.update-profile-information-form'
                    )

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- PASSWORD --}}
        {{-- ========================================================= --}}
        <div
            class="mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm"
        >

            {{-- Header --}}
            <div
                class="flex items-center gap-4 border-b border-[#edf0f4] px-5 py-4 sm:px-6"
            >

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]"
                >
                    <i
                        data-lucide="lock-keyhole"
                        class="h-5 w-5"
                    ></i>
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


            {{-- Content --}}
            <div class="p-5 sm:p-6">

                <div class="max-w-2xl">

                    @include(
                        'profile.partials.update-password-form'
                    )

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- TWO FACTOR AUTHENTICATION --}}
        {{-- ========================================================= --}}
        <div
            class="mb-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm"
        >

            {{-- Header --}}
            <div
                class="border-b border-[#edf0f4] px-5 py-4 sm:px-6"
            >

                <div
                    class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
                >

                    {{-- Left --}}
                    <div>

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]"
                            >

                                <i
                                    data-lucide="shield-check"
                                    class="h-5 w-5"
                                ></i>

                            </div>


                            <div>

                                <h2
                                    class="text-base font-semibold text-[#1f2937]"
                                >
                                    Two-Factor Authentication
                                </h2>

                                <p
                                    class="mt-1 text-sm text-[#667085]"
                                >
                                    Add an extra layer of security to your account.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Right --}}
                    <div class="flex items-center gap-3">

                        @if (auth()->user()->two_factor_enabled)

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700"
                            >

                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-green-500"
                                ></span>

                                Enabled

                            </span>

                        @else

                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-600"
                            >

                                <span
                                    class="h-1.5 w-1.5 rounded-full bg-gray-400"
                                ></span>

                                Disabled

                            </span>

                        @endif


                        <a
                            href="{{ route('two-factor.setup') }}"
                            class="inline-flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#205f98] cursor-pointer"
                        >

                            <i
                                data-lucide="shield"
                                class="h-4 w-4"
                            ></i>

                            @if (auth()->user()->two_factor_enabled)
                                Manage 2FA
                            @else
                                Enable 2FA
                            @endif

                        </a>

                    </div>

                </div>

            </div>


            {{-- 2FA Information --}}
            <div class="px-5 py-5 sm:px-6">

                <div
                    class="flex items-start gap-3 rounded-xl border border-[#e4e8ef] bg-[#f8fafc] p-4"
                >

                    <i
                        data-lucide="info"
                        class="mt-0.5 h-4 w-4 shrink-0 text-[#2874b9]"
                    ></i>

                    <p class="text-sm leading-6 text-[#667085]">

                        Two-factor authentication adds an additional verification
                        step when you sign in. Use Google Authenticator or another
                        compatible authenticator app.

                    </p>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- DELETE ACCOUNT --}}
        {{-- ========================================================= --}}
        <div
            class="overflow-hidden rounded-2xl border border-red-100 bg-white shadow-sm"
        >

            {{-- Header --}}
            <div
                class="flex items-center gap-4 border-b border-red-100 bg-red-50/40 px-5 py-4 sm:px-6"
            >

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-100 text-red-600"
                >
                    <i
                        data-lucide="shield-alert"
                        class="h-5 w-5"
                    ></i>
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


            {{-- Content --}}
            <div class="p-5 sm:p-6">

                <div class="max-w-2xl">

                    @include(
                        'profile.partials.delete-user-form'
                    )

                </div>

            </div>

        </div>

    </main>



    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}
    <footer class="border-t border-[#e4e8ef] bg-white">

        <div
            class="mx-auto max-w-7xl px-4 py-5 text-center text-xs text-[#667085] sm:px-6 lg:px-8"
        >

            © {{ date('Y') }} SR Library. All rights reserved.

        </div>

    </footer>



    {{-- ========================================================= --}}
    {{-- LUCIDE ICONS --}}
    {{-- ========================================================= --}}
    <script>

        document.addEventListener('DOMContentLoaded', function () {

            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

        });

    </script>


</body>

</html>
