<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Recovery Codes</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="min-h-screen bg-gray-50">

    <div class="mx-auto w-full max-w-2xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6">

            <h1 class="text-2xl font-bold text-gray-900">
                Recovery Codes
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Save these codes somewhere safe. Each code can be used only once.
            </p>

        </div>

        {{-- Warning --}}
        <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 px-4 py-4">

            <div class="flex gap-3">

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
                    class="mt-0.5 shrink-0 text-amber-600"
                >
                    <path d="M10.3 2.9 1.8 17a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 2.9a2 2 0 0 0-3.4 0Z"/>
                    <path d="M12 9v4"/>
                    <path d="M12 17h.01"/>
                </svg>

                <div>

                    <p class="text-sm font-semibold text-amber-800">
                        Save these codes now
                    </p>

                    <p class="mt-1 text-sm text-amber-700">
                        For security, these codes are shown only once.
                    </p>

                </div>

            </div>

        </div>

        {{-- Codes --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm">

            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                @foreach ($recoveryCodes as $code)

                    <div
                        class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-center font-mono text-lg font-semibold tracking-wider text-gray-800"
                    >
                        {{ $code }}
                    </div>

                @endforeach

            </div>

            {{-- Actions --}}
            <div class="mt-6 flex flex-col gap-3 sm:flex-row">

                <button
                    type="button"
                    onclick="copyRecoveryCodes()"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 cursor-pointer"
                >
                    Copy Codes
                </button>

                <button
                    type="button"
                    onclick="window.print()"
                    class="inline-flex items-center justify-center rounded-xl bg-[#2874b9] px-5 py-3 text-sm font-semibold text-white hover:bg-[#21649f] cursor-pointer"
                >
                    Print / Save
                </button>

                <a
                    href="{{ route('dashboard') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-gray-200 px-5 py-3 text-sm font-semibold text-gray-600 hover:bg-gray-50 cursor-pointer"
                >
                    Continue
                </a>

            </div>

        </div>

    </div>

<script>
    function copyRecoveryCodes() {

        const codes = @json($recoveryCodes);
        const text = codes.join('\n');

        navigator.clipboard.writeText(text)
            .then(function () {
                showCopyMessage();
            })
            .catch(function () {

                const textarea =
                    document.createElement('textarea');

                textarea.value = text;

                textarea.style.position = 'fixed';
                textarea.style.opacity = '0';

                document.body.appendChild(textarea);

                textarea.select();

                document.execCommand('copy');

                textarea.remove();

                showCopyMessage();
            });
    }

    function showCopyMessage() {

        const message =
            document.createElement('div');

        message.textContent =
            'Recovery codes copied successfully.';

        message.className =
            'fixed bottom-5 left-1/2 z-50 -translate-x-1/2 rounded-xl bg-gray-900 px-5 py-3 text-sm font-medium text-white shadow-lg';

        document.body.appendChild(message);

        setTimeout(function () {
            message.remove();
        }, 2500);
    }
</script>


</body>

</html>
