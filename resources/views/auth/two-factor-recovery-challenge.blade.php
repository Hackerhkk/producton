<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Recovery Code</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="min-h-screen bg-gray-50">

    <div class="flex min-h-screen items-center justify-center px-4">

        <div class="w-full max-w-md">

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8"
            >

                <div class="mb-6 text-center">

                    <div
                        class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-[#2874b9]/10"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            class="text-[#2874b9]"
                        >
                            <rect
                                width="18"
                                height="11"
                                x="3"
                                y="11"
                                rx="2"
                                ry="2"
                            />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                    </div>

                    <h1
                        class="text-xl font-bold text-gray-900"
                    >
                        Use Recovery Code
                    </h1>

                    <p
                        class="mt-2 text-sm text-gray-500"
                    >
                        Enter one of your unused recovery codes.
                    </p>

                </div>


                @if ($errors->any())

                    <div
                        class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3"
                    >

                        @foreach ($errors->all() as $error)

                            <p class="text-sm text-red-700">
                                {{ $error }}
                            </p>

                        @endforeach

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('two-factor.recovery-verify') }}"
                >

                    @csrf

                    <div>

                        <label
                            for="recovery_code"
                            class="mb-2 block text-sm font-medium text-gray-700"
                        >
                            Recovery Code
                        </label>

                        <input
                            id="recovery_code"
                            name="recovery_code"
                            type="text"
                            value="{{ old('recovery_code') }}"
                            autocomplete="off"
                            autofocus
                            placeholder="XXXX-XXXX"
                            class="block w-full rounded-xl border border-gray-300 px-4 py-3 text-center text-lg tracking-widest uppercase outline-none transition focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20"
                        >

                    </div>


                    <button
                        type="submit"
                        class="mt-5 flex w-full items-center justify-center rounded-xl bg-[#2874b9] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#205f98] cursor-pointer"
                    >
                        Verify Recovery Code
                    </button>

                </form>


                <div class="mt-5 text-center">

                    <a
                        href="{{ route('two-factor.challenge') }}"
                        class="text-sm font-medium text-[#2874b9] hover:underline cursor-pointer"
                    >
                        ← Use Google Authenticator instead
                    </a>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
