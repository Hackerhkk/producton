<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Password Required - SR Library</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">
</head>

<body class="min-h-screen bg-[#f8fafc]">

    <div class="flex min-h-screen items-center justify-center px-4 py-10">

        <div class="w-full max-w-md">

            <!-- Logo -->
            <div class="mb-8 flex justify-center">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#2874b9] text-white shadow-sm">
                    <i data-lucide="lock-keyhole" class="h-6 w-6"></i>
                </div>
            </div>

            <!-- Card -->
            <div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">

                <div class="text-center">

                    <h1 class="text-xl font-bold text-[#111827]">
                        Password Required
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-[#667085]">
                        This short URL is password protected.
                        Enter the password to continue.
                    </p>

                </div>


                <!-- Errors -->
                @if ($errors->any())

                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

                        <div class="flex items-start gap-2">

                            <i
                                data-lucide="circle-alert"
                                class="mt-0.5 h-4 w-4 shrink-0 text-red-600"
                            ></i>

                            <div class="text-sm text-red-700">

                                @foreach ($errors->all() as $error)

                                    <p>{{ $error }}</p>

                                @endforeach

                            </div>

                        </div>

                    </div>

                @endif


                <!-- Form -->
                <form
                    method="POST"
                    action="{{ route('short-url.password.verify', $shortUrl->short_code) }}"
                    class="mt-6 space-y-5"
                >

                    @csrf


                    <!-- Short URL -->
                    <div>

                        <label class="mb-2 block text-sm font-medium text-[#344054]">
                            Short URL
                        </label>

                        <div class="flex items-center gap-2 rounded-xl border border-[#d0d5dd] bg-[#f9fafb] px-3 py-3">

                            <i
                                data-lucide="link"
                                class="h-4 w-4 shrink-0 text-[#667085]"
                            ></i>

                            <span class="truncate text-sm text-[#475467]">
                                {{ url('/s/' . $shortUrl->short_code) }}
                            </span>

                        </div>

                    </div>


                    <!-- Password -->
                    <div>

                        <label
                            for="password"
                            class="mb-2 block text-sm font-medium text-[#344054]"
                        >
                            Password
                        </label>

                        <div class="relative">

                            <i
                                data-lucide="key-round"
                                class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#98a2b3]"
                            ></i>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autofocus
                                autocomplete="current-password"
                                placeholder="Enter password"
                                class="w-full rounded-xl border border-[#d0d5dd] bg-white py-3 pl-10 pr-4 text-sm text-[#101828] outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
                            >

                        </div>

                    </div>


                    <!-- Button -->
                    <button
                        type="submit"
                        class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#21639d] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/30"
                    >

                        <i
                            data-lucide="unlock"
                            class="h-4 w-4"
                        ></i>

                        Continue

                    </button>

                </form>

            </div>


            <!-- Footer -->
            <p class="mt-6 text-center text-xs text-[#98a2b3]">
                Protected short link
            </p>

        </div>

    </div>


    <script>
        lucide.createIcons();
    </script>

</body>

</html>
