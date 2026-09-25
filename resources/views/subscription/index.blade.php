<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Subscription - {{ config('app.name', 'Library Management') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
      <link
        rel="icon"
        type="image/png"
        href="{{ asset('svg.svg') }}"
    >

    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <style>
.loader {
    position: absolute;
    top: calc(50% - 1.25em);
    left: calc(50% - 1.25em);

    width: 2.5em;
    height: 2.5em;

    transform: rotate(165deg);
}

.loader:before,
.loader:after {
    content: "";

    position: absolute;
    top: 50%;
    left: 50%;

    display: block;

    width: 0.5em;
    height: 0.5em;

    border-radius: 0.25em;

    transform: translate(-50%, -50%);
}

.loader:before {
    animation: before8 2s infinite;
}

.loader:after {
    animation: after6 2s infinite;
}

@keyframes before8 {
    0% {
        width: 0.5em;
        box-shadow:
            1em -0.5em rgba(225, 20, 98, 0.75),
            -1em 0.5em rgba(111, 202, 220, 0.75);
    }

    35% {
        width: 2.5em;
        box-shadow:
            0 -0.5em rgba(225, 20, 98, 0.75),
            0 0.5em rgba(111, 202, 220, 0.75);
    }

    70% {
        width: 0.5em;
        box-shadow:
            -1em -0.5em rgba(225, 20, 98, 0.75),
            1em 0.5em rgba(111, 202, 220, 0.75);
    }

    100% {
        box-shadow:
            1em -0.5em rgba(225, 20, 98, 0.75),
            -1em 0.5em rgba(111, 202, 220, 0.75);
    }
}

@keyframes after6 {
    0% {
        height: 0.5em;
        box-shadow:
            0.5em 1em rgba(61, 184, 143, 0.75),
            -0.5em -1em rgba(233, 169, 32, 0.75);
    }

    35% {
        height: 2.5em;
        box-shadow:
            0.5em 0 rgba(61, 184, 143, 0.75),
            -0.5em 0 rgba(233, 169, 32, 0.75);
    }

    70% {
        height: 0.5em;
        box-shadow:
            0.5em -1em rgba(61, 184, 143, 0.75),
            -0.5em 1em rgba(233, 169, 32, 0.75);
    }

    100% {
        box-shadow:
            0.5em 1em rgba(61, 184, 143, 0.75),
            -0.5em -1em rgba(233, 169, 32, 0.75);
    }
}

        </style>
</head>

<body class="min-h-screen bg-[#f7f9fc] text-[#1f2937]">
           {{-- ================= PAGE LOADER ================= --}}
<div id="pageLoader" class="fixed inset-0 z-[99999] bg-white">
    <div class="loader"></div>
</div>

<nav class="hidden sm:block px-4 pt-4 sm:px-6 lg:px-8">

    <div class="mx-auto flex h-[68px] max-w-7xl items-center justify-between rounded-2xl border border-[#e4e8ef] bg-white/95 px-4 shadow-[0_8px_30px_rgba(16,24,40,0.06)] backdrop-blur-md sm:px-5">

        {{-- ================= LOGO ================= --}}
        <a
            href="{{ route('dashboard') }}"
            class="flex items-center gap-3 cursor-pointer"
        >
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff]">
                <i
                    data-lucide="layout-dashboard"
                    class="h-5 w-5 text-[#2874b9]"
                ></i>
            </div>

            <div>
                <p class="text-sm font-bold text-[#111827]">
                    {{ config('app.name', 'Library Management') }}
                </p>

                
            </div>
        </a>


        {{-- ================= NAVIGATION ================= --}}
        <div class="flex items-center gap-1">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#2874b9] transition hover:bg-[#eef6ff] cursor-pointer"
            >
                <i data-lucide="home" class="h-4 w-4"></i>
                Dashboard
            </a>


            {{-- Tests --}}
            <a
                href="{{ route('student.tests.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="file-question" class="h-4 w-4"></i>
                Tests
            </a>


            {{-- Plans --}}
            <a
                href="{{ route('subscription.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="credit-card" class="h-4 w-4"></i>
                Plans
            </a>


            {{-- Short URL --}}
            <a
                href="{{ route('short-url.index') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="link-2" class="h-4 w-4"></i>
                Short URL
            </a>


            {{-- Profile --}}
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
            >
                <i data-lucide="user-round" class="h-4 w-4"></i>
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
                    <i data-lucide="log-out" class="h-4 w-4"></i>
                    
                </button>
            </form>

        </div>

    </div>

</nav>

<!-- Main -->
<main class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">

    <!-- Header -->
    <div class="mb-5 flex items-center justify-between gap-4">

        <div class="min-w-0">

            <div class="flex items-center gap-2">

                <a
                    href="{{ route('dashboard') }}"
                    class="cursor-pointer text-xs font-semibold text-[#667085] hover:text-[#2874b9]"
                >
                    Dashboard
                </a>

                <i
                    data-lucide="chevron-right"
                    class="h-3.5 w-3.5 text-[#98a2b3]"
                ></i>

                <span class="text-xs font-semibold text-[#2874b9]">
                    Subscription
                </span>

            </div>

            <h1 class="mt-2 text-xl font-bold tracking-tight text-[#111827] sm:text-2xl">
                Test Subscription
            </h1>

            <p class="mt-0.5 text-sm text-[#667085]">
                Get access to all available tests with an active subscription.
            </p>

        </div>

        <div class="hidden shrink-0 items-center gap-2 sm:flex">

            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#eef6ff] text-[#2874b9]">
                <i data-lucide="credit-card" class="h-4 w-4"></i>
            </div>

            

        </div>

    </div>

    <!-- Success -->
    @if(session('success'))
        <div class="mb-4 flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 px-4 py-3">

            <div class="mt-0.5 text-green-600">
                <i data-lucide="circle-check" class="h-4.5 w-4.5"></i>
            </div>

            <div>
                <p class="text-sm font-semibold text-green-700">
                    Success
                </p>

                <p class="mt-0.5 text-xs text-green-700">
                    {{ session('success') }}
                </p>
            </div>

        </div>
    @endif

    <!-- Error -->
    @if(session('error'))
        <div class="mb-4 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3">

            <div class="mt-0.5 text-red-600">
                <i data-lucide="circle-alert" class="h-4.5 w-4.5"></i>
            </div>

            <div>
                <p class="text-sm font-semibold text-red-700">
                    Error
                </p>

                <p class="mt-0.5 text-xs text-red-700">
                    {{ session('error') }}
                </p>
            </div>

        </div>
    @endif

    <!-- Current Subscription -->
    @if($latestSubscription)

        @php
            $isActive = $latestSubscription->isActive();

            $daysRemaining = $isActive && $latestSubscription->expires_at
                ? max(0, now()->diffInDays($latestSubscription->expires_at))
                : 0;
        @endphp

        <section class="mb-5 overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm">

            <div class="border-b border-[#edf0f4] px-4 py-3 sm:px-5">

                <div class="flex items-center justify-between gap-3">

                    <div class="flex items-center gap-2.5">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#eef6ff] text-[#2874b9]">
                            <i data-lucide="badge-check" class="h-4.5 w-4.5"></i>
                        </div>

                        <div>

                            <h2 class="text-sm font-semibold text-[#1f2937]">
                                Current Subscription
                            </h2>

                            <p class="text-xs text-[#667085]">
                                Your latest test access plan.
                            </p>

                        </div>

                    </div>

                    @if($isActive)

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-2.5 py-1 text-[11px] font-bold text-green-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>
                            Active
                        </span>

                    @else

                        <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-2.5 py-1 text-[11px] font-bold text-red-700">
                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                            Expired
                        </span>

                    @endif

                </div>

            </div>

            <div class="grid gap-3 p-4 sm:grid-cols-4 sm:p-5">

                <!-- Plan -->
                <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                    <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                        <i data-lucide="package" class="h-3.5 w-3.5"></i>
                        Plan
                    </div>

                    <p class="mt-1.5 truncate text-sm font-semibold text-[#1f2937]">
                        {{ $latestSubscription->plan->name ?? 'Test Access' }}
                    </p>

                </div>

                <!-- Amount -->
                <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                    <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                        <i data-lucide="indian-rupee" class="h-3.5 w-3.5"></i>
                        Amount
                    </div>

                    <p class="mt-1.5 text-sm font-semibold text-[#1f2937]">
                        ₹{{ number_format((float) $latestSubscription->amount, 2) }}
                    </p>

                </div>

                <!-- Expiry -->
                <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                    <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                        <i data-lucide="calendar-clock" class="h-3.5 w-3.5"></i>
                        Expiry
                    </div>

                    <p class="mt-1.5 text-sm font-semibold text-[#1f2937]">
                        {{ $latestSubscription->expires_at?->format('d M Y, h:i A') ?? '—' }}
                    </p>

                </div>

                <!-- Days -->
                <div class="rounded-lg border border-[#edf0f4] bg-[#fafbfc] p-3">

                    <div class="flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide text-[#98a2b3]">
                        <i data-lucide="hourglass" class="h-3.5 w-3.5"></i>
                        Remaining
                    </div>

                    <p class="mt-1.5 text-sm font-semibold {{ $isActive ? 'text-green-600' : 'text-red-600' }}">
                        {{ $isActive ? $daysRemaining . ' days' : 'Expired' }}
                    </p>

                </div>

            </div>

        </section>

    @endif

    <!-- Plans -->
    <section>

        <div class="mb-3">

            <h2 class="text-base font-semibold text-[#1f2937]">
                Available Plans
            </h2>

            <p class="mt-0.5 text-xs text-[#667085]">
                Choose a plan to access all available tests.
            </p>

        </div>

        @if($plans->count())

            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">

                @foreach($plans as $plan)

                    <div class="relative overflow-hidden rounded-xl border border-[#e4e8ef] bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-[#2874b9]/30 hover:shadow-md">

                        <div class="absolute right-0 top-0 h-24 w-24 translate-x-8 -translate-y-8 rounded-full bg-[#eef6ff]"></div>

                        <div class="relative p-5">

                            <div class="flex items-start justify-between gap-3">

                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#eef6ff] text-[#2874b9]">
                                    <i data-lucide="crown" class="h-5 w-5"></i>
                                </div>

                                <span class="rounded-full bg-[#eef6ff] px-2.5 py-1 text-[10px] font-bold text-[#2874b9]">
                                    ALL TESTS
                                </span>

                            </div>

                            <h3 class="mt-4 text-base font-bold text-[#1f2937]">
                                {{ $plan->name }}
                            </h3>

                            <div class="mt-2 flex items-end gap-1">

                                <span class="text-3xl font-bold tracking-tight text-[#111827]">
                                    ₹{{ number_format((float) $plan->price, 0) }}
                                </span>

                                <span class="mb-1 text-xs text-[#667085]">
                                    / {{ $plan->duration_days }} days
                                </span>

                            </div>

                            <div class="mt-4 space-y-2.5">

                                <div class="flex items-center gap-2 text-xs text-[#667085]">

                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-green-50 text-green-600">
                                        <i data-lucide="check" class="h-3 w-3"></i>
                                    </div>

                                    Access to all available tests

                                </div>

                                <div class="flex items-center gap-2 text-xs text-[#667085]">

                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-green-50 text-green-600">
                                        <i data-lucide="check" class="h-3 w-3"></i>
                                    </div>

                                    New tests included automatically

                                </div>

                                <div class="flex items-center gap-2 text-xs text-[#667085]">

                                    <div class="flex h-5 w-5 items-center justify-center rounded-full bg-green-50 text-green-600">
                                        <i data-lucide="check" class="h-3 w-3"></i>
                                    </div>

                                    Valid for {{ $plan->duration_days }} days

                                </div>

                            </div>

                            <!-- Terms -->
                            <div class="mt-5 rounded-lg border border-[#e4e8ef] bg-[#fafbfc] p-3">

                                <label class="flex cursor-pointer items-start gap-2.5">

                                    <input
                                        type="checkbox"
                                        class="terms-checkbox mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded border-[#d0d5dd] text-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/20"
                                    >

                                    <span class="text-[11px] leading-5 text-[#667085]">

                                        I agree to the

                                        <a
                                            href="{{ route('terms') }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="cursor-pointer font-semibold text-[#2874b9] hover:text-[#1f5d94]"
                                        >
                                            Terms & Conditions
                                        </a>,

                                        <a
                                            href="{{ route('privacy') }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="cursor-pointer font-semibold text-[#2874b9] hover:text-[#1f5d94]"
                                        >
                                            Privacy Policy
                                        </a>

                                        and

                                        <a
                                            href="{{ route('refund') }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="cursor-pointer font-semibold text-[#2874b9] hover:text-[#1f5d94]"
                                        >
                                            Refund & Cancellation Policy
                                        </a>.

                                    </span>

                                </label>

                            </div>

                            <!-- Subscribe -->
                            <button
                                type="button"
                                onclick="startPayment(
                                    {{ $plan->id }},
                                    '{{ addslashes($plan->name) }}',
                                    {{ (float) $plan->price }},
                                    this
                                )"
                                class="mt-3 inline-flex w-full cursor-pointer items-center justify-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#22669f] disabled:cursor-not-allowed disabled:opacity-60"
                            >

                                <i
                                    data-lucide="credit-card"
                                    class="h-4 w-4"
                                ></i>

                                Subscribe Now

                            </button>

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="rounded-xl border border-[#e4e8ef] bg-white px-5 py-10 text-center shadow-sm">

                <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-[#f5f7fa] text-[#98a2b3]">
                    <i data-lucide="package-open" class="h-5 w-5"></i>
                </div>

                <h3 class="mt-3 text-sm font-semibold text-[#1f2937]">
                    No plans available
                </h3>

                <p class="mt-1 text-xs text-[#667085]">
                    Subscription plans are currently unavailable.
                </p>

            </div>

        @endif

    </section>

</main>

<!-- Processing Modal -->
<div
    id="processingModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 px-4"
>
    <div class="w-full max-w-sm rounded-xl border border-[#e4e8ef] bg-white p-5 shadow-xl">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#eef6ff] text-[#2874b9]">
                <i
                    data-lucide="loader-circle"
                    class="h-5 w-5 animate-spin"
                ></i>
            </div>

            <div>

                <h3 class="text-sm font-bold text-[#1f2937]">
                    Processing Payment
                </h3>

                <p class="mt-0.5 text-xs text-[#667085]">
                    Please wait while we verify your payment.
                </p>

            </div>

        </div>

    </div>
</div>

<!-- Message Modal -->
<div
    id="messageModal"
    class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/40 px-4"
>
    <div class="w-full max-w-sm rounded-xl border border-[#e4e8ef] bg-white p-5 shadow-xl">

        <div
            id="messageIcon"
            class="flex h-10 w-10 items-center justify-center rounded-full"
        >
            <i
                id="messageIconSvg"
                data-lucide="circle-alert"
                class="h-5 w-5"
            ></i>
        </div>

        <h3
            id="messageTitle"
            class="mt-4 text-base font-bold text-[#1f2937]"
        >
            Payment Status
        </h3>

        <p
            id="messageText"
            class="mt-1.5 text-sm leading-6 text-[#667085]"
        ></p>

        <button
            type="button"
            onclick="closeMessageModal()"
            class="mt-5 w-full cursor-pointer rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#22669f]"
        >
            Continue
        </button>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();
});

const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

let paymentInProgress = false;

function showProcessingModal() {
    const modal = document.getElementById('processingModal');

    if (!modal) {
        return;
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');

    lucide.createIcons();
}

function hideProcessingModal() {
    const modal = document.getElementById('processingModal');

    if (!modal) {
        return;
    }

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.classList.remove('overflow-hidden');
}

function showMessageModal(
    title,
    message,
    type = 'error'
) {
    const modal = document.getElementById('messageModal');
    const iconBox = document.getElementById('messageIcon');
    const icon = document.getElementById('messageIconSvg');
    const titleElement = document.getElementById('messageTitle');
    const textElement = document.getElementById('messageText');

    if (
        !modal ||
        !iconBox ||
        !icon ||
        !titleElement ||
        !textElement
    ) {
        return;
    }

    titleElement.textContent = title;
    textElement.textContent = message;

    if (type === 'success') {
        iconBox.className =
            'flex h-10 w-10 items-center justify-center rounded-full bg-green-50 text-green-600';

        icon.setAttribute(
            'data-lucide',
            'circle-check'
        );
    } else {
        iconBox.className =
            'flex h-10 w-10 items-center justify-center rounded-full bg-red-50 text-red-600';

        icon.setAttribute(
            'data-lucide',
            'circle-alert'
        );
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    document.body.classList.add('overflow-hidden');

    lucide.createIcons();
}

function closeMessageModal() {
    const modal = document.getElementById('messageModal');

    if (!modal) {
        return;
    }

    modal.classList.add('hidden');
    modal.classList.remove('flex');

    document.body.classList.remove('overflow-hidden');
}

async function startPayment(
    planId,
    planName,
    planPrice,
    button
) {
    if (paymentInProgress) {
        return;
    }

    if (!button) {
        showMessageModal(
            'Payment Error',
            'Unable to start payment. Please refresh the page and try again.'
        );

        return;
    }

    const card = button.closest('.relative');

    const termsCheckbox = card
        ? card.querySelector('.terms-checkbox')
        : null;

    if (!termsCheckbox || !termsCheckbox.checked) {

        showMessageModal(
            'Terms Required',
            'Please agree to the Terms & Conditions, Privacy Policy and Refund & Cancellation Policy before continuing.'
        );

        return;
    }

    if (typeof Razorpay === 'undefined') {

        showMessageModal(
            'Payment Error',
            'Payment service could not be loaded. Please refresh the page and try again.'
        );

        return;
    }

    paymentInProgress = true;

    try {

        showProcessingModal();

        const response = await fetch(
            "{{ route('subscription.create-order') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },

                body: JSON.stringify({
                    plan_id: planId,
                }),
            }
        );

        const data = await response.json();

        hideProcessingModal();

        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'Unable to create payment order.'
            );
        }

        const options = {

            key: data.key,

            amount: data.amount,

            currency: data.currency,

            name: 'SR Library',

            description:
                `${data.plan_name || planName} - All Tests Access`,

            order_id: data.order_id,

            handler: async function (paymentResponse) {
                await verifyPayment(paymentResponse);
            },

            modal: {
                ondismiss: function () {
                    paymentInProgress = false;
                }
            },

            theme: {
                color: '#2874b9'
            }
        };

        const razorpay = new Razorpay(options);

        razorpay.on(
            'payment.failed',
            function (response) {

                paymentInProgress = false;

                console.error(
                    'Razorpay payment failed:',
                    response
                );

                const error = response?.error || {};

                showMessageModal(
                    'Payment Failed',
                    error.description
                        ? `${error.description}${error.code ? ` (${error.code})` : ''}`
                        : 'Your payment could not be completed. Please try again.'
                );
            }
        );

        razorpay.open();

    } catch (error) {

        hideProcessingModal();

        paymentInProgress = false;

        showMessageModal(
            'Payment Error',
            error.message ||
            'Something went wrong. Please try again.'
        );
    }
}

async function verifyPayment(paymentResponse) {

    showProcessingModal();

    try {

        const response = await fetch(
            "{{ route('subscription.verify-payment') }}",
            {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },

                body: JSON.stringify({

                    razorpay_payment_id:
                        paymentResponse.razorpay_payment_id,

                    razorpay_order_id:
                        paymentResponse.razorpay_order_id,

                    razorpay_signature:
                        paymentResponse.razorpay_signature,

                }),
            }
        );

        const data = await response.json();

        hideProcessingModal();

        paymentInProgress = false;

        if (!response.ok || !data.success) {

            throw new Error(
                data.message ||
                'Payment verification failed.'
            );
        }

        showMessageModal(
            'Payment Successful',
            data.message ||
            'Your test access is now active.',
            'success'
        );

        setTimeout(function () {
            window.location.reload();
        }, 1800);

    } catch (error) {

        hideProcessingModal();

        paymentInProgress = false;

        showMessageModal(
            'Verification Failed',
            error.message ||
            'Payment could not be verified. Please contact support if money was deducted.'
        );
    }
}
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const loader = document.getElementById('pageLoader');

    if (!loader) {
        return;
    }

    loader.style.transition = 'opacity 0.3s ease';
    loader.style.opacity = '0';

    setTimeout(function () {
        loader.remove();
    }, 300);

});
</script>

</body>
</html>
