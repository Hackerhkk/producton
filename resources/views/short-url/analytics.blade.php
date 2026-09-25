<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Analytics - SR Library</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">
</head>

<body class="min-h-screen bg-[#f8fafc]">

    <!-- Navbar -->
    <header class="border-b border-[#e4e8ef] bg-white">

        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9] text-white">
                    <i data-lucide="chart-no-axes-combined" class="h-5 w-5"></i>
                </div>

                <div>
                    <div class="font-bold text-[#1f2937]">
                        SR Library
                    </div>

                    <div class="text-[11px] text-[#667085]">
                        Short URL Analytics
                    </div>
                </div>

            </a>


            <div class="flex items-center gap-2">

                <a href="{{ route('short-url.index') }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2 text-sm font-medium text-[#344054] hover:bg-[#f9fafb]">

                    <i data-lucide="arrow-left" class="h-4 w-4"></i>

                    <span class="hidden sm:inline">
                        Back
                    </span>

                </a>


                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center gap-2 rounded-lg border border-red-200 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50"
                    >

                        <i data-lucide="log-out" class="h-4 w-4"></i>

                        <span class="hidden sm:inline">
                            Logout
                        </span>

                    </button>

                </form>

            </div>

        </div>

    </header>


    <!-- Main -->
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">


        <!-- Header -->
        <div class="mb-6">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">

                <div>

                    <h1 class="text-2xl font-bold text-[#111827]">
                        Short URL Analytics
                    </h1>

                    <p class="mt-1 text-sm text-[#667085]">
                        Detailed click information for your short URL.
                    </p>

                </div>

            </div>


            <!-- Short URL -->
            <div class="mt-4 rounded-xl border border-[#dbeafe] bg-[#eef6ff] px-4 py-3">

                <div class="flex items-start gap-3">

                    <i data-lucide="link" class="mt-0.5 h-5 w-5 shrink-0 text-[#2874b9]"></i>

                    <div class="min-w-0">

                        <p class="text-xs font-medium text-[#667085]">
                            Short URL
                        </p>

                        <a
                            href="{{ url('/s/' . $shortUrl->short_code) }}"
                            target="_blank"
                            class="mt-1 block truncate text-sm font-semibold text-[#2874b9] hover:underline"
                        >
                            {{ url('/s/' . $shortUrl->short_code) }}
                        </a>

                        <p class="mt-1 truncate text-xs text-[#667085]">
                            {{ $shortUrl->original_url }}
                        </p>

                    </div>

                </div>

            </div>

        </div>


        <!-- Stats -->
        <div class="grid grid-cols-2 gap-4 lg:grid-cols-4">


            <!-- Total -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                        <i data-lucide="mouse-pointer-click" class="h-5 w-5"></i>

                    </div>

                    <span class="text-xs font-medium text-[#667085]">
                        Total
                    </span>

                </div>

                <p class="mt-4 text-2xl font-bold text-[#111827]">
                    {{ number_format($totalClicks) }}
                </p>

                <p class="mt-1 text-xs text-[#667085]">
                    All clicks
                </p>

            </div>


            <!-- Mobile -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f0fdf4] text-green-600">

                        <i data-lucide="smartphone" class="h-5 w-5"></i>

                    </div>

                    <span class="text-xs font-medium text-[#667085]">
                        Mobile
                    </span>

                </div>

                <p class="mt-4 text-2xl font-bold text-[#111827]">
                    {{ number_format($mobileClicks) }}
                </p>

                <p class="mt-1 text-xs text-[#667085]">
                    Mobile clicks
                </p>

            </div>


            <!-- Desktop -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#f5f3ff] text-purple-600">

                        <i data-lucide="monitor" class="h-5 w-5"></i>

                    </div>

                    <span class="text-xs font-medium text-[#667085]">
                        Desktop
                    </span>

                </div>

                <p class="mt-4 text-2xl font-bold text-[#111827]">
                    {{ number_format($desktopClicks) }}
                </p>

                <p class="mt-1 text-xs text-[#667085]">
                    Desktop clicks
                </p>

            </div>


            <!-- Tablet -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#fff7ed] text-orange-600">

                        <i data-lucide="tablet" class="h-5 w-5"></i>

                    </div>

                    <span class="text-xs font-medium text-[#667085]">
                        Tablet
                    </span>

                </div>

                <p class="mt-4 text-2xl font-bold text-[#111827]">
                    {{ number_format($tabletClicks) }}
                </p>

                <p class="mt-1 text-xs text-[#667085]">
                    Tablet clicks
                </p>

            </div>

        </div>


        <!-- Daily + Device -->
        <div class="mt-6 grid gap-6 lg:grid-cols-2">


            <!-- Last 30 Days -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

                <div class="border-b border-[#edf0f4] px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">

                            <i data-lucide="calendar-days" class="h-4 w-4"></i>

                        </div>

                        <div>

                            <h2 class="font-semibold text-[#1f2937]">
                                Last 30 Days
                            </h2>

                            <p class="text-xs text-[#667085]">
                                Date-wise click activity
                            </p>

                        </div>

                    </div>

                </div>


                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="border-b border-[#edf0f4] bg-[#fafbfc]">

                            <tr>

                                <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                    Date
                                </th>

                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                    Clicks
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($dailyClicks as $day)

                                <tr class="border-b border-[#edf0f4] last:border-b-0">

                                    <td class="px-5 py-3 text-[#344054]">
                                        {{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}
                                    </td>

                                    <td class="px-5 py-3 text-right font-semibold text-[#1f2937]">
                                        {{ number_format($day->total) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="2"
                                        class="px-5 py-10 text-center text-sm text-[#667085]">

                                        No clicks in the last 30 days.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            <!-- Device -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

                <div class="border-b border-[#edf0f4] px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">

                            <i data-lucide="smartphone" class="h-4 w-4"></i>

                        </div>

                        <div>

                            <h2 class="font-semibold text-[#1f2937]">
                                Devices
                            </h2>

                            <p class="text-xs text-[#667085]">
                                Clicks by device type
                            </p>

                        </div>

                    </div>

                </div>


                <div class="divide-y divide-[#edf0f4]">

                    @forelse($deviceStats as $device)

                        <div class="flex items-center justify-between px-5 py-4">

                            <div class="flex items-center gap-3">

                                @if($device->device === 'Mobile')

                                    <i data-lucide="smartphone" class="h-5 w-5 text-[#2874b9]"></i>

                                @elseif($device->device === 'Tablet')

                                    <i data-lucide="tablet" class="h-5 w-5 text-[#2874b9]"></i>

                                @elseif($device->device === 'Desktop')

                                    <i data-lucide="monitor" class="h-5 w-5 text-[#2874b9]"></i>

                                @else

                                    <i data-lucide="circle-help" class="h-5 w-5 text-[#667085]"></i>

                                @endif

                                <span class="text-sm font-medium text-[#344054]">
                                    {{ $device->device ?: 'Unknown' }}
                                </span>

                            </div>

                            <span class="rounded-full bg-[#f2f4f7] px-3 py-1 text-xs font-semibold text-[#344054]">
                                {{ number_format($device->total) }}
                            </span>

                        </div>

                    @empty

                        <div class="px-5 py-10 text-center text-sm text-[#667085]">
                            No device data yet.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        <!-- Browser + OS -->
        <div class="mt-6 grid gap-6 lg:grid-cols-2">


            <!-- Browser -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

                <div class="border-b border-[#edf0f4] px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">

                            <i data-lucide="globe" class="h-4 w-4"></i>

                        </div>

                        <div>

                            <h2 class="font-semibold text-[#1f2937]">
                                Browsers
                            </h2>

                            <p class="text-xs text-[#667085]">
                                Clicks by browser
                            </p>

                        </div>

                    </div>

                </div>


                <div class="divide-y divide-[#edf0f4]">

                    @forelse($browserStats as $browser)

                        <div class="flex items-center justify-between px-5 py-4">

                            <span class="text-sm font-medium text-[#344054]">
                                {{ $browser->browser ?: 'Unknown' }}
                            </span>

                            <span class="rounded-full bg-[#f2f4f7] px-3 py-1 text-xs font-semibold text-[#344054]">
                                {{ number_format($browser->total) }}
                            </span>

                        </div>

                    @empty

                        <div class="px-5 py-10 text-center text-sm text-[#667085]">
                            No browser data yet.
                        </div>

                    @endforelse

                </div>

            </div>


            <!-- OS -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

                <div class="border-b border-[#edf0f4] px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">

                            <i data-lucide="laptop" class="h-4 w-4"></i>

                        </div>

                        <div>

                            <h2 class="font-semibold text-[#1f2937]">
                                Operating Systems
                            </h2>

                            <p class="text-xs text-[#667085]">
                                Clicks by operating system
                            </p>

                        </div>

                    </div>

                </div>


                <div class="divide-y divide-[#edf0f4]">

                    @forelse($osStats as $os)

                        <div class="flex items-center justify-between px-5 py-4">

                            <span class="text-sm font-medium text-[#344054]">
                                {{ $os->os ?: 'Unknown' }}
                            </span>

                            <span class="rounded-full bg-[#f2f4f7] px-3 py-1 text-xs font-semibold text-[#344054]">
                                {{ number_format($os->total) }}
                            </span>

                        </div>

                    @empty

                        <div class="px-5 py-10 text-center text-sm text-[#667085]">
                            No OS data yet.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        <!-- Recent Clicks -->
        <div class="mt-6 overflow-hidden rounded-2xl border border-[#e4e8ef] bg-white shadow-sm">

            <div class="border-b border-[#edf0f4] px-5 py-4 sm:px-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">

                        <i data-lucide="clock-3" class="h-4 w-4"></i>

                    </div>

                    <div>

                        <h2 class="font-semibold text-[#1f2937]">
                            Recent Clicks
                        </h2>

                        <p class="text-xs text-[#667085]">
                            Latest visitor activity
                        </p>

                    </div>

                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full min-w-[850px] text-left text-sm">

                    <thead class="border-b border-[#edf0f4] bg-[#fafbfc]">

                        <tr>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Device
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Browser
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                OS
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                IP
                            </th>

                            <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wide text-[#667085]">
                                Date & Time
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($recentClicks as $click)

                            <tr class="border-b border-[#edf0f4] last:border-b-0 hover:bg-[#fafbfc]">

                                <td class="px-5 py-4">

                                    <span class="inline-flex items-center gap-2 font-medium text-[#344054]">

                                        @if($click->device === 'Mobile')

                                            <i data-lucide="smartphone" class="h-4 w-4 text-[#2874b9]"></i>

                                        @elseif($click->device === 'Tablet')

                                            <i data-lucide="tablet" class="h-4 w-4 text-[#2874b9]"></i>

                                        @else

                                            <i data-lucide="monitor" class="h-4 w-4 text-[#2874b9]"></i>

                                        @endif

                                        {{ $click->device ?: 'Unknown' }}

                                    </span>

                                </td>


                                <td class="px-5 py-4 text-[#344054]">
                                    {{ $click->browser ?: 'Unknown' }}
                                </td>


                                <td class="px-5 py-4 text-[#344054]">
                                    {{ $click->os ?: 'Unknown' }}
                                </td>


                                <td class="px-5 py-4 font-mono text-xs text-[#667085]">
                                    {{ $click->ip_address ?: 'Unknown' }}
                                </td>


                                <td class="px-5 py-4 text-[#667085]">
                                    {{ $click->clicked_at?->format('d M Y, h:i A') }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="px-5 py-12 text-center">

                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">

                                        <i data-lucide="mouse-pointer-2" class="h-6 w-6"></i>

                                    </div>

                                    <p class="mt-4 text-sm font-medium text-[#344054]">
                                        No clicks yet
                                    </p>

                                    <p class="mt-1 text-xs text-[#667085]">
                                        Click your short URL to generate analytics.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if($recentClicks->hasPages())

                <div class="border-t border-[#edf0f4] px-5 py-4">

                    {{ $recentClicks->links() }}

                </div>

            @endif

        </div>

    </main>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            lucide.createIcons();

        });

    </script>

</body>

</html>