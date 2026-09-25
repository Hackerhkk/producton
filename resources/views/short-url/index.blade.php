<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, viewport-fit=cover"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

    <title>Short URLs - {{ config('app.name', 'Library Management') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="min-h-screen bg-[#f8fafc] text-[#1f2937]">


{{-- =========================================================
     DESKTOP NAVBAR
     816px AND ABOVE
========================================================= --}}

<nav class="hidden min-[816px]:block px-4 pt-4 sm:px-6 lg:px-8">

    <div
        class="mx-auto flex h-[68px] max-w-7xl items-center justify-between rounded-2xl border border-[#e4e8ef] bg-white/95 px-4 shadow-[0_8px_30px_rgba(16,24,40,0.06)] backdrop-blur-md sm:px-5"
    >

        {{-- LOGO --}}

        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 cursor-pointer"
        >

            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff]"
            >

                <i
                    data-lucide="layout-dashboard"
                    class="h-5 w-5 text-[#2874b9]"
                ></i>

            </div>


            <div>

                <p class="text-sm font-bold text-[#111827]">
                    {{ config('app.name', 'Library Management') }}
                </p>

                <p class="text-[11px] text-[#98a2b3]">
                    User Dashboard
                </p>

            </div>

        </a>


        {{-- NAVIGATION --}}

        <div class="flex items-center gap-1">

            {{-- Dashboard --}}

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >

                <i
                    data-lucide="home"
                    class="h-4 w-4"
                ></i>

                Dashboard

            </a>


            {{-- Tests --}}

            <a
                href="{{ route('student.tests.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >

                <i
                    data-lucide="file-question"
                    class="h-4 w-4"
                ></i>

                Tests

            </a>


            {{-- Plans --}}

            <a
                href="{{ route('subscription.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >

                <i
                    data-lucide="credit-card"
                    class="h-4 w-4"
                ></i>

                Plans

            </a>


            {{-- Short URL --}}

            <a
                href="{{ route('short-url.index') }}"
                class="flex items-center gap-2 rounded-xl bg-[#eef6ff] px-4 py-2 text-sm font-semibold text-[#2874b9] transition hover:bg-[#e5f1fc] cursor-pointer"
            >

                <i
                    data-lucide="link-2"
                    class="h-4 w-4"
                ></i>

                Short URL

            </a>


            {{-- Profile --}}

            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >

                <i
                    data-lucide="user-round"
                    class="h-4 w-4"
                ></i>

                Profile

            </a>


            {{-- Logout --}}

            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="ml-1 flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#205f98] cursor-pointer"
                >

                    <i
                        data-lucide="log-out"
                        class="h-4 w-4"
                    ></i>

                </button>

            </form>

        </div>

    </div>

</nav>


{{-- =========================================================
     MAIN
========================================================= --}}

<main
    class="mx-auto max-w-7xl px-4 py-6 pb-28 min-[816px]:px-6 min-[816px]:py-8 min-[816px]:pb-8 lg:px-8"
>


    {{-- PAGE HEADER --}}

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-[#111827]">
            Short URLs
        </h1>

        <p class="mt-1 text-sm text-[#667085]">
            Create and manage your short links.
        </p>

    </div>


    {{-- SUCCESS MESSAGE --}}

    @if(session('success'))

        <div
            class="mb-6 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700"
        >

            <i
                data-lucide="circle-check"
                class="mt-0.5 h-4 w-4 shrink-0"
            ></i>

            <span>
                {{ session('success') }}
            </span>

        </div>

    @endif


    {{-- VALIDATION ERRORS --}}

    @if ($errors->any())

        <div
            class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3"
        >

            <div class="flex items-start gap-3">

                <i
                    data-lucide="circle-alert"
                    class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                ></i>

                <div>

                    <p class="text-sm font-semibold text-red-700">
                        Please fix the following errors:
                    </p>

                    <ul class="mt-2 space-y-1 text-sm text-red-600">

                        @foreach ($errors->all() as $error)

                            <li>
                                • {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- =====================================================
         STATISTICS
    ====================================================== --}}

    <div class="mb-8 grid grid-cols-2 gap-4 lg:grid-cols-4">


        {{-- TOTAL URLS --}}

        <div
            class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-[#667085]">
                        Total URLs
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        {{ number_format($totalUrls ?? 0) }}
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9]/10 text-[#2874b9]"
                >

                    <i
                        data-lucide="link-2"
                        class="h-5 w-5"
                    ></i>

                </div>

            </div>

        </div>


        {{-- TOTAL CLICKS --}}

        <div
            class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-[#667085]">
                        Total Clicks
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        {{ number_format($totalClicks ?? 0) }}
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-600"
                >

                    <i
                        data-lucide="mouse-pointer-click"
                        class="h-5 w-5"
                    ></i>

                </div>

            </div>

        </div>


        {{-- TODAY CLICKS --}}

        <div
            class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-[#667085]">
                        Today's Clicks
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        {{ number_format($todayClicks ?? 0) }}
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-50 text-purple-600"
                >

                    <i
                        data-lucide="chart-no-axes-combined"
                        class="h-5 w-5"
                    ></i>

                </div>

            </div>

        </div>


        {{-- ACTIVE URLS --}}

        <div
            class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-xs font-medium text-[#667085]">
                        Active URLs
                    </p>

                    <p class="mt-2 text-2xl font-bold text-[#111827]">
                        {{ number_format($activeUrls ?? 0) }}
                    </p>

                </div>

                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-600"
                >

                    <i
                        data-lucide="circle-check"
                        class="h-5 w-5"
                    ></i>

                </div>

            </div>

        </div>

    </div>


    {{-- =====================================================
         CREATE SHORT URL
    ====================================================== --}}

    <div
        class="mb-6 overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm"
    >


        {{-- CARD HEADER --}}

        <div class="border-b border-[#e4e8ef] px-4 py-3">

            <div class="flex items-center gap-2.5">

                <div
                    class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#2874b9]/10 text-[#2874b9]"
                >

                    <i
                        data-lucide="link-2"
                        class="h-4 w-4"
                    ></i>

                </div>

                <div>

                    <h2 class="text-sm font-semibold text-[#111827]">
                        Create Short URL
                    </h2>

                    <p class="mt-0.5 text-[11px] text-[#667085]">
                        Create a secure and trackable short link.
                    </p>

                </div>

            </div>

        </div>


        {{-- FORM --}}

        <form
            method="POST"
            action="{{ route('short-url.store') }}"
            class="space-y-4 p-4"
        >

            @csrf


            {{-- ORIGINAL URL --}}

            <div>

                <label
                    for="original_url"
                    class="mb-1.5 block text-xs font-medium text-[#344054]"
                >
                    Original URL
                </label>

                <div class="relative">

                    <i
                        data-lucide="globe"
                        class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#98a2b3]"
                    ></i>

                    <input
                        id="original_url"
                        type="url"
                        name="original_url"
                        value="{{ old('original_url') }}"
                        required
                        placeholder="https://example.com/page"
                        class="w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-9 pr-3 text-xs text-[#101828] outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                    >

                </div>

                @error('original_url')

                    <p class="mt-1 text-[11px] text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- CUSTOM URL --}}

            <div>

                <label
                    for="custom_url"
                    class="mb-1.5 block text-xs font-medium text-[#344054]"
                >

                    Custom URL

                    <span class="font-normal text-[#98a2b3]">
                        (Optional)
                    </span>

                </label>

                <div
                    class="flex overflow-hidden rounded-lg border border-[#d0d5dd] bg-white focus-within:border-[#2874b9] focus-within:ring-2 focus-within:ring-[#2874b9]/10"
                >

                    <div
                        class="flex shrink-0 items-center border-r border-[#d0d5dd] bg-[#f9fafb] px-2.5 text-[11px] text-[#667085]"
                    >

                        {{ url('/s') }}/

                    </div>

                    <input
                        id="custom_url"
                        type="text"
                        name="custom_url"
                        value="{{ old('custom_url') }}"
                        placeholder="my-link"
                        class="min-w-0 flex-1 border-0 bg-transparent px-2.5 py-2.5 text-xs text-[#101828] outline-none focus:ring-0"
                    >

                </div>

                <p class="mt-1 text-[11px] text-[#98a2b3]">
                    Letters, numbers, hyphens and underscores only.
                </p>

                @error('custom_url')

                    <p class="mt-1 text-[11px] text-red-600">
                        {{ $message }}
                    </p>

                @enderror

            </div>


            {{-- START / EXPIRY --}}

            <div class="grid gap-3 sm:grid-cols-2">


                {{-- START --}}

                <div>

                    <label
                        for="starts_at"
                        class="mb-1.5 block text-xs font-medium text-[#344054]"
                    >

                        Start Date

                        <span class="font-normal text-[#98a2b3]">
                            (Optional)
                        </span>

                    </label>

                    <div class="relative">

                        <i
                            data-lucide="calendar-clock"
                            class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#98a2b3]"
                        ></i>

                        <input
                            id="starts_at"
                            type="datetime-local"
                            name="starts_at"
                            value="{{ old('starts_at') }}"
                            class="w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-9 pr-2 text-xs text-[#101828] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >

                    </div>

                    @error('starts_at')

                        <p class="mt-1 text-[11px] text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>


                {{-- EXPIRY --}}

                <div>

                    <label
                        for="expires_at"
                        class="mb-1.5 block text-xs font-medium text-[#344054]"
                    >

                        Expiry Date

                        <span class="font-normal text-[#98a2b3]">
                            (Optional)
                        </span>

                    </label>

                    <div class="relative">

                        <i
                            data-lucide="calendar-x"
                            class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#98a2b3]"
                        ></i>

                        <input
                            id="expires_at"
                            type="datetime-local"
                            name="expires_at"
                            value="{{ old('expires_at') }}"
                            class="w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-9 pr-2 text-xs text-[#101828] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                        >

                    </div>

                    @error('expires_at')

                        <p class="mt-1 text-[11px] text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>


            {{-- ADVANCED OPTIONS --}}

            <div class="border-t border-[#e4e8ef] pt-4">

                <div class="mb-3">

                    <h3 class="text-xs font-semibold text-[#111827]">
                        Advanced Options
                    </h3>

                    <p class="mt-0.5 text-[11px] text-[#667085]">
                        Add extra controls to your short URL.
                    </p>

                </div>


                <div class="grid gap-3 sm:grid-cols-2">


                    {{-- CLICK LIMIT --}}

                    <div>

                        <label
                            for="click_limit"
                            class="mb-1.5 block text-xs font-medium text-[#344054]"
                        >
                            Click Limit
                        </label>

                        <div class="relative">

                            <i
                                data-lucide="mouse-pointer-click"
                                class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#98a2b3]"
                            ></i>

                            <input
                                id="click_limit"
                                type="number"
                                name="click_limit"
                                value="{{ old('click_limit') }}"
                                min="1"
                                placeholder="Unlimited"
                                class="w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-9 pr-3 text-xs text-[#101828] outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                        </div>

                        <p class="mt-1 text-[11px] text-[#98a2b3]">
                            Empty = unlimited.
                        </p>

                        @error('click_limit')

                            <p class="mt-1 text-[11px] text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- PASSWORD --}}

                    <div>

                        <label
                            for="password"
                            class="mb-1.5 block text-xs font-medium text-[#344054]"
                        >

                            Password

                            <span class="font-normal text-[#98a2b3]">
                                (Optional)
                            </span>

                        </label>

                        <div class="relative">

                            <i
                                data-lucide="lock-keyhole"
                                class="pointer-events-none absolute left-3 top-1/2 h-3.5 w-3.5 -translate-y-1/2 text-[#98a2b3]"
                            ></i>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                minlength="4"
                                maxlength="255"
                                placeholder="Enter password"
                                class="w-full rounded-lg border border-[#d0d5dd] bg-white py-2.5 pl-9 pr-3 text-xs text-[#101828] outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                        </div>

                        <p class="mt-1 text-[11px] text-[#98a2b3]">
                            Password required before opening.
                        </p>

                        @error('password')

                            <p class="mt-1 text-[11px] text-red-600">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>

                </div>


                {{-- QR OPTION --}}

                <label
                    class="mt-3 flex cursor-pointer items-center gap-2.5 rounded-lg border border-[#e4e8ef] bg-[#f9fafb] p-3 transition hover:border-[#2874b9]/40 hover:bg-white"
                >

                    <input
                        type="checkbox"
                        name="qr_enabled"
                        value="1"
                        {{ old('qr_enabled') ? 'checked' : '' }}
                        class="h-3.5 w-3.5 cursor-pointer rounded border-[#d0d5dd] text-[#2874b9] focus:ring-[#2874b9]"
                    >

                    <span class="flex min-w-0 flex-1 items-center gap-2">

                        <i
                            data-lucide="qr-code"
                            class="h-3.5 w-3.5 shrink-0 text-[#2874b9]"
                        ></i>

                        <span>

                            <span class="block text-xs font-medium text-[#344054]">
                                Generate QR Code
                            </span>

                            <span class="block text-[10px] text-[#667085]">
                                Enable QR Code for this short URL.
                            </span>

                        </span>

                    </span>

                </label>

            </div>


            {{-- SUBMIT --}}

            <div class="flex justify-end border-t border-[#e4e8ef] pt-4">

                <button
                    type="submit"
                    class="inline-flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg bg-[#2874b9] px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-[#21639d] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/30 sm:w-auto"
                >

                    <i
                        data-lucide="plus"
                        class="h-3.5 w-3.5"
                    ></i>

                    Create Short URL

                </button>

            </div>

        </form>

    </div>


    {{-- =====================================================
         SHORT URL LIST
    ====================================================== --}}

    <div
        class="overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm"
    >


        {{-- LIST HEADER --}}

        <div class="border-b border-[#e4e8ef] px-5 py-4 sm:px-6">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <h2 class="font-semibold text-[#111827]">
                        Your Short URLs
                    </h2>

                    <p class="mt-1 text-xs text-[#667085]">
                        Manage and track your short links.
                    </p>

                </div>


                <div
                    class="hidden rounded-lg bg-[#f9fafb] px-3 py-2 text-xs font-medium text-[#667085] sm:block"
                >

                    {{ $shortUrls->total() }} URLs

                </div>

            </div>

        </div>


        {{-- =================================================
             DESKTOP TABLE
        ================================================== --}}

        <div class="hidden overflow-x-auto md:block">

            <table class="w-full min-w-[1100px]">

                <thead>

                    <tr
                        class="border-b border-[#e4e8ef] bg-[#f9fafb] text-left"
                    >

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Short URL
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Original URL
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Clicks
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Limit
                        </th>

                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Expiry
                        </th>

                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#667085]">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-[#e4e8ef]">

                    @forelse($shortUrls as $shortUrl)

                        <tr class="transition hover:bg-[#f9fafb]">

                            {{-- SHORT URL --}}

                            <td class="px-5 py-4">

                                <div class="max-w-[230px]">

                                    <a
                                        href="{{ url('/s/' . $shortUrl->short_code) }}"
                                        target="_blank"
                                        class="block cursor-pointer truncate text-sm font-semibold text-[#2874b9] hover:underline"
                                    >

                                        {{ url('/s/' . $shortUrl->short_code) }}

                                    </a>


                                    <div class="mt-1 flex flex-wrap items-center gap-2">

                                        @if($shortUrl->password)

                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2 py-0.5 text-[11px] font-medium text-amber-700"
                                            >

                                                <i
                                                    data-lucide="lock-keyhole"
                                                    class="h-3 w-3"
                                                ></i>

                                                Protected

                                            </span>

                                        @endif


                                        @if($shortUrl->qr_enabled)

                                            <span
                                                class="inline-flex items-center gap-1 rounded-full bg-blue-50 px-2 py-0.5 text-[11px] font-medium text-blue-700"
                                            >

                                                <i
                                                    data-lucide="qr-code"
                                                    class="h-3 w-3"
                                                ></i>

                                                QR

                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- ORIGINAL URL --}}

                            <td class="px-5 py-4">

                                <div
                                    class="max-w-[260px] truncate text-sm text-[#667085]"
                                    title="{{ $shortUrl->original_url }}"
                                >

                                    {{ $shortUrl->original_url }}

                                </div>

                            </td>


                            {{-- CLICKS --}}

                            <td class="px-5 py-4">

                                <div class="text-sm font-semibold text-[#111827]">

                                    {{ number_format($shortUrl->clicks) }}

                                </div>

                            </td>


                            {{-- LIMIT --}}

                            <td class="px-5 py-4">

                                @if($shortUrl->click_limit)

                                    <div class="text-sm text-[#344054]">

                                        {{ number_format($shortUrl->click_limit) }}

                                    </div>


                                    @if($shortUrl->clicks >= $shortUrl->click_limit)

                                        <span
                                            class="mt-1 inline-flex rounded-full bg-red-50 px-2 py-0.5 text-[11px] font-medium text-red-600"
                                        >
                                            Limit reached
                                        </span>

                                    @else

                                        <span
                                            class="mt-1 inline-flex rounded-full bg-green-50 px-2 py-0.5 text-[11px] font-medium text-green-600"
                                        >

                                            {{ number_format($shortUrl->click_limit - $shortUrl->clicks) }}
                                            left

                                        </span>

                                    @endif

                                @else

                                    <span class="text-sm text-[#667085]">
                                        Unlimited
                                    </span>

                                @endif

                            </td>


                            {{-- EXPIRY --}}

                            <td class="px-5 py-4">

                                @if($shortUrl->expires_at)

                                    @if(now()->gte($shortUrl->expires_at))

                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600"
                                        >
                                            Expired
                                        </span>

                                    @else

                                        <div class="text-sm text-[#344054]">

                                            {{ $shortUrl->expires_at->format('d M Y') }}

                                        </div>

                                        <div class="mt-1 text-xs text-[#98a2b3]">

                                            {{ $shortUrl->expires_at->format('h:i A') }}

                                        </div>

                                    @endif

                                @else

                                    <span class="text-sm text-[#667085]">
                                        Never
                                    </span>

                                @endif

                            </td>


                            {{-- ACTIONS --}}

                            <td class="px-5 py-4">

                                <div class="flex justify-end gap-2">


                                    {{-- COPY --}}

                                    <button
                                        type="button"
                                        onclick="copyShortUrl('{{ url('/s/' . $shortUrl->short_code) }}', this)"
                                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-xs font-medium text-[#344054] transition hover:bg-[#f9fafb]"
                                    >

                                        <i
                                            data-lucide="copy"
                                            class="h-4 w-4"
                                        ></i>

                                        Copy

                                    </button>


                                    {{-- ANALYTICS --}}

                                    <a
                                        href="{{ route('short-url.analytics', $shortUrl) }}"
                                        class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-xs font-medium text-[#344054] transition hover:bg-[#f9fafb]"
                                    >

                                        <i
                                            data-lucide="chart-no-axes-combined"
                                            class="h-4 w-4"
                                        ></i>

                                        Analytics

                                    </a>


                                    {{-- QR --}}

                                    @if($shortUrl->qr_enabled)

                                        <a
                                            href="{{ route('short-url.qr', $shortUrl) }}"
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-blue-200 bg-blue-50 px-3 py-2 text-xs font-medium text-[#2874b9] transition hover:bg-blue-100"
                                        >

                                            <i
                                                data-lucide="qr-code"
                                                class="h-4 w-4"
                                            ></i>

                                            QR

                                        </a>

                                    @endif


                                    {{-- DELETE --}}

                                    <form
                                        method="POST"
                                        action="{{ route('short-url.destroy', $shortUrl) }}"
                                        class="delete-short-url-form"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex cursor-pointer items-center gap-2 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                        >

                                            <i
                                                data-lucide="trash-2"
                                                class="h-4 w-4"
                                            ></i>

                                            Delete

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-5 py-14 text-center"
                            >

                                <div
                                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#98a2b3]"
                                >

                                    <i
                                        data-lucide="link-2-off"
                                        class="h-6 w-6"
                                    ></i>

                                </div>


                                <h3
                                    class="mt-4 text-sm font-semibold text-[#344054]"
                                >
                                    No short URLs yet
                                </h3>


                                <p class="mt-1 text-sm text-[#667085]">
                                    Create your first short URL above.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- =================================================
             MOBILE CARDS
        ================================================== --}}

        <div class="divide-y divide-[#e4e8ef] md:hidden">

            @forelse($shortUrls as $shortUrl)

                <div class="p-4">


                    {{-- URL --}}

                    <div class="flex items-start justify-between gap-3">

                        <div class="min-w-0 flex-1">

                            <a
                                href="{{ url('/s/' . $shortUrl->short_code) }}"
                                target="_blank"
                                class="block cursor-pointer truncate text-sm font-semibold text-[#2874b9]"
                            >

                                {{ url('/s/' . $shortUrl->short_code) }}

                            </a>


                            <p
                                class="mt-1 truncate text-xs text-[#667085]"
                                title="{{ $shortUrl->original_url }}"
                            >

                                {{ $shortUrl->original_url }}

                            </p>

                        </div>


                        <div class="flex shrink-0 items-center gap-2">

                            @if($shortUrl->password)

                                <span
                                    class="inline-flex items-center justify-center rounded-lg bg-amber-50 p-2 text-amber-700"
                                >

                                    <i
                                        data-lucide="lock-keyhole"
                                        class="h-4 w-4"
                                    ></i>

                                </span>

                            @endif


                            @if($shortUrl->qr_enabled)

                                <span
                                    class="inline-flex items-center justify-center rounded-lg bg-blue-50 p-2 text-[#2874b9]"
                                >

                                    <i
                                        data-lucide="qr-code"
                                        class="h-4 w-4"
                                    ></i>

                                </span>

                            @endif

                        </div>

                    </div>


                    {{-- DETAILS --}}

                    <div class="mt-4 grid grid-cols-2 gap-3">


                        <div class="rounded-xl bg-[#f9fafb] p-3">

                            <p class="text-[11px] font-medium text-[#98a2b3]">
                                Clicks
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#111827]">
                                {{ number_format($shortUrl->clicks) }}
                            </p>

                        </div>


                        <div class="rounded-xl bg-[#f9fafb] p-3">

                            <p class="text-[11px] font-medium text-[#98a2b3]">
                                Limit
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#111827]">

                                @if($shortUrl->click_limit)

                                    {{ number_format($shortUrl->click_limit) }}

                                @else

                                    Unlimited

                                @endif

                            </p>

                        </div>


                        <div class="rounded-xl bg-[#f9fafb] p-3">

                            <p class="text-[11px] font-medium text-[#98a2b3]">
                                Starts
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#111827]">

                                @if($shortUrl->starts_at)

                                    {{ $shortUrl->starts_at->format('d M Y') }}

                                @else

                                    Now

                                @endif

                            </p>

                        </div>


                        <div class="rounded-xl bg-[#f9fafb] p-3">

                            <p class="text-[11px] font-medium text-[#98a2b3]">
                                Expires
                            </p>

                            <p class="mt-1 text-sm font-semibold text-[#111827]">

                                @if($shortUrl->expires_at)

                                    {{ $shortUrl->expires_at->format('d M Y') }}

                                @else

                                    Never

                                @endif

                            </p>

                        </div>

                    </div>


                    {{-- ACTIONS --}}

                    <div
                        class="mt-4 grid gap-2 @if($shortUrl->qr_enabled) grid-cols-4 @else grid-cols-3 @endif"
                    >


                        {{-- COPY --}}

                        <button
                            type="button"
                            onclick="copyShortUrl('{{ url('/s/' . $shortUrl->short_code) }}', this)"
                            class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-2 py-2.5 text-xs font-medium text-[#344054] transition hover:bg-[#f9fafb]"
                        >

                            <i
                                data-lucide="copy"
                                class="h-4 w-4"
                            ></i>

                            <span>
                                Copy
                            </span>

                        </button>


                        {{-- ANALYTICS --}}

                        <a
                            href="{{ route('short-url.analytics', $shortUrl) }}"
                            class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-2 py-2.5 text-xs font-medium text-[#344054] transition hover:bg-[#f9fafb]"
                        >

                            <i
                                data-lucide="chart-no-axes-combined"
                                class="h-4 w-4"
                            ></i>

                            <span>
                                Analytics
                            </span>

                        </a>


                        {{-- QR --}}

                        @if($shortUrl->qr_enabled)

                            <a
                                href="{{ route('short-url.qr', $shortUrl) }}"
                                class="inline-flex cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-blue-200 bg-blue-50 px-2 py-2.5 text-xs font-medium text-[#2874b9] transition hover:bg-blue-100"
                            >

                                <i
                                    data-lucide="qr-code"
                                    class="h-4 w-4"
                                ></i>

                                <span>
                                    QR
                                </span>

                            </a>

                        @endif


                        {{-- DELETE --}}

                        <form
                            method="POST"
                            action="{{ route('short-url.destroy', $shortUrl) }}"
                            class="delete-short-url-form"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="inline-flex w-full cursor-pointer items-center justify-center gap-1.5 rounded-lg border border-red-200 bg-white px-2 py-2.5 text-xs font-medium text-red-600 transition hover:bg-red-50"
                            >

                                <i
                                    data-lucide="trash-2"
                                    class="h-4 w-4"
                                ></i>

                                <span>
                                    Delete
                                </span>

                            </button>

                        </form>

                    </div>

                </div>


            @empty

                <div class="px-5 py-14 text-center">

                    <div
                        class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#f2f4f7] text-[#98a2b3]"
                    >

                        <i
                            data-lucide="link-2-off"
                            class="h-6 w-6"
                        ></i>

                    </div>


                    <h3
                        class="mt-4 text-sm font-semibold text-[#344054]"
                    >
                        No short URLs yet
                    </h3>


                    <p class="mt-1 text-sm text-[#667085]">
                        Create your first short URL above.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- PAGINATION --}}

        @if($shortUrls->hasPages())

            <div class="border-t border-[#e4e8ef] px-5 py-4 sm:px-6">

                {{ $shortUrls->links() }}

            </div>

        @endif

    </div>

</main>


{{-- =========================================================
     MOBILE BOTTOM NAVIGATION
     0 - 815px
========================================================= --}}

<nav
    class="fixed inset-x-0 bottom-0 z-50 border-t border-[#e4e8ef] bg-white/95 px-2 pb-[env(safe-area-inset-bottom)] pt-2 shadow-[0_-10px_30px_rgba(16,24,40,0.08)] backdrop-blur-md min-[816px]:hidden"
>

    <div class="mx-auto grid max-w-md grid-cols-5">


        {{-- HOME --}}

        <a
            href="{{ route('dashboard') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition active:scale-95 hover:text-[#2874b9]"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="home"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Home
            </span>

        </a>


        {{-- TESTS --}}

        <a
            href="{{ route('student.tests.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition active:scale-95 hover:text-[#2874b9]"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="clipboard-check"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Tests
            </span>

        </a>


        {{-- PLANS --}}

        <a
            href="{{ route('subscription.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition active:scale-95 hover:text-[#2874b9]"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="crown"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Plans
            </span>

        </a>


        {{-- SHORT URL ACTIVE --}}

        <a
            href="{{ route('short-url.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#2874b9] transition active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#eef6ff]"
            >

                <i
                    data-lucide="link-2"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-bold">
                Links
            </span>

        </a>


        {{-- PROFILE --}}

        <a
            href="{{ route('profile.edit') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition active:scale-95 hover:text-[#2874b9]"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="user-round"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Profile
            </span>

        </a>

    </div>

</nav>


{{-- =========================================================
     DELETE CONFIRMATION MODAL
========================================================= --}}

<div
    id="deleteModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/40 px-4 backdrop-blur-sm"
>

    <div
        class="w-full max-w-sm rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-[0_20px_60px_rgba(16,24,40,0.18)]"
    >

        <div
            class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600"
        >

            <i
                data-lucide="trash-2"
                class="h-6 w-6"
            ></i>

        </div>


        <h3
            class="mt-4 text-center text-lg font-bold text-[#111827]"
        >
            Delete Short URL?
        </h3>


        <p
            class="mt-2 text-center text-sm leading-6 text-[#667085]"
        >
            This short URL and its related data will be permanently deleted.
        </p>


        <div class="mt-6 grid grid-cols-2 gap-3">

            <button
                type="button"
                id="cancelDelete"
                class="cursor-pointer rounded-xl border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] transition hover:bg-[#f9fafb]"
            >
                Cancel
            </button>


            <button
                type="button"
                id="confirmDelete"
                class="cursor-pointer rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700"
            >
                Delete
            </button>

        </div>

    </div>

</div>


{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Lucide
    |--------------------------------------------------------------------------
    */

    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }


    /*
    |--------------------------------------------------------------------------
    | Copy Short URL
    |--------------------------------------------------------------------------
    */

    window.copyShortUrl = function (url, button) {

        if (!navigator.clipboard) {

            return;

        }

        navigator.clipboard.writeText(url)

            .then(function () {

                const originalHTML = button.innerHTML;

                button.innerHTML = `
                    <i data-lucide="check" class="h-4 w-4"></i>
                    <span>Copied</span>
                `;

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }


                setTimeout(function () {

                    button.innerHTML = originalHTML;

                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }

                }, 1500);

            })

            .catch(function () {

                /*
                No browser alert.
                */

                button.innerHTML = `
                    <i data-lucide="circle-x" class="h-4 w-4"></i>
                    <span>Failed</span>
                `;

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }


                setTimeout(function () {

                    window.location.reload();

                }, 1200);

            });

    };


    /*
    |--------------------------------------------------------------------------
    | Delete Confirmation Modal
    |--------------------------------------------------------------------------
    */

    const deleteModal =
        document.getElementById('deleteModal');

    const cancelDelete =
        document.getElementById('cancelDelete');

    const confirmDelete =
        document.getElementById('confirmDelete');

    let deleteForm = null;


    document
        .querySelectorAll('.delete-short-url-form')
        .forEach(function (form) {

            form.addEventListener('submit', function (event) {

                event.preventDefault();

                deleteForm = form;

                deleteModal.classList.remove('hidden');

                deleteModal.classList.add('flex');

                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }

            });

        });


    /*
    |--------------------------------------------------------------------------
    | Cancel Delete
    |--------------------------------------------------------------------------
    */

    cancelDelete.addEventListener('click', function () {

        deleteForm = null;

        deleteModal.classList.add('hidden');

        deleteModal.classList.remove('flex');

    });


    /*
    |--------------------------------------------------------------------------
    | Confirm Delete
    |--------------------------------------------------------------------------
    */

    confirmDelete.addEventListener('click', function () {

        if (!deleteForm) {
            return;
        }

        confirmDelete.disabled = true;

        confirmDelete.innerHTML = `
            <span class="inline-flex items-center gap-2">
                <i data-lucide="loader-circle" class="h-4 w-4 animate-spin"></i>
                Deleting...
            </span>
        `;

        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        deleteForm.submit();

    });


    /*
    |--------------------------------------------------------------------------
    | Close modal when clicking outside
    |--------------------------------------------------------------------------
    */

    deleteModal.addEventListener('click', function (event) {

        if (event.target === deleteModal) {

            deleteForm = null;

            deleteModal.classList.add('hidden');

            deleteModal.classList.remove('flex');

        }

    });

});

</script>


</body>

</html>
