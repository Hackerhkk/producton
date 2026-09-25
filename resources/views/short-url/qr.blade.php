<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>QR Code - SR Library</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">

</head>


<body class="min-h-screen bg-[#f8fafc]">


    <!-- HEADER -->

    <header class="border-b border-[#e4e8ef] bg-white">

        <div class="mx-auto flex h-14 max-w-6xl items-center justify-between px-4 sm:px-6">

            <!-- Logo -->

            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-2.5"
            >

                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-[#2874b9] text-white">

                    <i
                        data-lucide="qr-code"
                        class="h-4 w-4"
                    ></i>

                </div>

                <div>

                    <div class="text-sm font-bold text-[#1f2937]">
                        SR Library
                    </div>

                    <div class="text-[10px] text-[#667085]">
                        QR Code
                    </div>

                </div>

            </a>


            <!-- Actions -->

            <div class="flex items-center gap-2">

                <a
                    href="{{ route('short-url.index') }}"
                    class="inline-flex items-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-2.5 py-1.5 text-xs font-medium text-[#344054] transition hover:bg-[#f9fafb]"
                >

                    <i
                        data-lucide="arrow-left"
                        class="h-3.5 w-3.5"
                    ></i>

                    <span class="hidden sm:inline">
                        Back
                    </span>

                </a>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-2.5 py-1.5 text-xs font-medium text-red-600 transition hover:bg-red-50"
                    >

                        <i
                            data-lucide="log-out"
                            class="h-3.5 w-3.5"
                        ></i>

                        <span class="hidden sm:inline">
                            Logout
                        </span>

                    </button>

                </form>

            </div>

        </div>

    </header>


    <!-- MAIN -->

    <main class="mx-auto max-w-3xl px-4 py-6 sm:px-6">


        <!-- HEADING -->

        <div class="mb-5 text-center">

            <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9]/10 text-[#2874b9]">

                <i
                    data-lucide="qr-code"
                    class="h-5 w-5"
                ></i>

            </div>

            <h1 class="mt-2.5 text-xl font-bold text-[#111827]">
                QR Code
            </h1>

            <p class="mt-1 text-xs text-[#667085]">
                Scan to open your short URL.
            </p>

        </div>


        <!-- QR CARD -->

        <div class="mx-auto max-w-md overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">


            <!-- SHORT URL -->

            <div class="border-b border-[#e4e8ef] px-4 py-3">

                <div class="flex items-center gap-2.5">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#2874b9]/10 text-[#2874b9]">

                        <i
                            data-lucide="link-2"
                            class="h-4 w-4"
                        ></i>

                    </div>

                    <div class="min-w-0">

                        <h2 class="text-xs font-semibold text-[#111827]">
                            Short URL
                        </h2>

                        <a
                            href="{{ $shortUrlLink }}"
                            target="_blank"
                            class="block truncate text-xs text-[#2874b9] hover:underline"
                        >
                            {{ $shortUrlLink }}
                        </a>

                    </div>

                </div>

            </div>


            <!-- QR -->

            <div class="flex justify-center px-4 py-5">

                <div class="rounded-xl border border-[#e4e8ef] bg-white p-2 shadow-sm">

                    {!! QrCode::format('svg')
                        ->size(180)
                        ->margin(1)
                        ->errorCorrection('H')
                        ->generate($shortUrlLink)
                    !!}

                </div>

            </div>


            <!-- STATS -->

            <div class="border-t border-[#e4e8ef] bg-[#f9fafb] px-4 py-3">

                <div class="grid grid-cols-2 gap-2.5">


                    <!-- CLICKS -->

                    <div class="rounded-lg border border-[#e4e8ef] bg-white p-3">

                        <div class="flex items-center gap-1.5">

                            <i
                                data-lucide="mouse-pointer-click"
                                class="h-3.5 w-3.5 text-[#2874b9]"
                            ></i>

                            <span class="text-[11px] font-medium text-[#667085]">
                                Total Clicks
                            </span>

                        </div>

                        <p class="mt-1 text-base font-bold text-[#111827]">
                            {{ number_format($shortUrl->clicks) }}
                        </p>

                    </div>


                    <!-- LIMIT -->

                    <div class="rounded-lg border border-[#e4e8ef] bg-white p-3">

                        <div class="flex items-center gap-1.5">

                            <i
                                data-lucide="gauge"
                                class="h-3.5 w-3.5 text-[#2874b9]"
                            ></i>

                            <span class="text-[11px] font-medium text-[#667085]">
                                Click Limit
                            </span>

                        </div>

                        <p class="mt-1 text-base font-bold text-[#111827]">

                            @if($shortUrl->click_limit)

                                {{ number_format($shortUrl->click_limit) }}

                            @else

                                Unlimited

                            @endif

                        </p>

                    </div>

                </div>

            </div>


            <!-- ACTIONS -->

            <div class="border-t border-[#e4e8ef] px-4 py-3">

                <div class="grid grid-cols-2 gap-2.5">


                    <!-- DOWNLOAD -->

                    <a
                        href="{{ route('short-url.qr.download', $shortUrl) }}"
                        class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-[#2874b9] px-3 py-2.5 text-xs font-semibold text-white transition hover:bg-[#21639d] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/30"
                    >

                        <i
                            data-lucide="download"
                            class="h-3.5 w-3.5"
                        ></i>

                        Download QR

                    </a>


                    <!-- OPEN -->

                    <a
                        href="{{ $shortUrlLink }}"
                        target="_blank"
                        class="inline-flex items-center justify-center gap-1.5 rounded-lg border border-[#d0d5dd] bg-white px-3 py-2.5 text-xs font-semibold text-[#344054] transition hover:bg-[#f9fafb]"
                    >

                        <i
                            data-lucide="external-link"
                            class="h-3.5 w-3.5"
                        ></i>

                        Open URL

                    </a>

                </div>

            </div>

        </div>


        <!-- NOTE -->

        <div class="mx-auto mt-3 max-w-md rounded-lg border border-blue-100 bg-blue-50 px-3 py-2.5">

            <div class="flex items-start gap-1.5">

                <i
                    data-lucide="info"
                    class="mt-0.5 h-3.5 w-3.5 shrink-0 text-[#2874b9]"
                ></i>

                <p class="text-[11px] leading-4 text-[#475467]">

                    Scanning this QR opens the same short URL.
                    Password, expiry and click-limit rules still apply.

                </p>

            </div>

        </div>

    </main>


    <!-- LUCIDE -->

    <script>

        lucide.createIcons();

    </script>

</body>

</html>
