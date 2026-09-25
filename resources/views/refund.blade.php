<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">

   
<title>Refund & Cancellation Policy - Library Management System</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])
   

</head>

<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">

<header class="border-b border-[#e4e8ef] bg-white">

   
<div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 sm:px-8">

    <a href="{{ url('/') }}" class="flex items-center gap-3 cursor-pointer">

        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-[#2874b9] text-white">
            <i data-lucide="library-big" class="h-5 w-5"></i>
        </div>

        <div>
            <div class="text-sm font-bold text-[#172033] sm:text-base">
                Library Management
            </div>

            <div class="text-[11px] text-[#667085]">
                Smart Library System
            </div>
        </div>

    </a>

    <a
        href="{{ url('/') }}"
        class="inline-flex items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2 text-sm font-medium text-[#344054] transition hover:bg-[#f8fafc] cursor-pointer"
    >
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Back to Home
    </a>

</div>
   

</header>

<main class="mx-auto max-w-4xl px-5 py-10 sm:px-8 sm:py-14">

   
<div class="mb-8">

    <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-[#eef6ff] px-3 py-1.5 text-xs font-semibold text-[#2874b9]">
        <i data-lucide="rotate-ccw" class="h-3.5 w-3.5"></i>
        Payments
    </div>

    <h1 class="text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">
        Refund & Cancellation Policy
    </h1>

    <p class="mt-3 text-sm leading-6 text-[#667085] sm:text-base">
        This policy explains how payment issues, cancellations and refund
        requests are handled for our paid services.
    </p>

    <p class="mt-2 text-xs text-[#98a2b3]">
        Last updated: {{ date('F Y') }}
    </p>

</div>

<div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">

    <section>
        <h2 class="text-lg font-bold text-[#101828]">
            1. Subscription Cancellation
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Once a subscription has been successfully purchased and
            activated, cancellation requests are subject to the terms of
            the applicable subscription plan.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            2. Refund Eligibility
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Refund requests may be considered in situations such as
            duplicate payments, successful payment where the purchased
            service was not activated, or other verified payment-related
            technical issues.
        </p>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            A refund is not automatically guaranteed merely because a
            subscription has been purchased or partially used. Requests
            are reviewed according to the circumstances of the transaction.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            3. Duplicate Payments
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            If the same subscription is accidentally paid for more than
            once, the duplicate transaction may be reviewed for refund
            after the payment records are verified.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            4. Payment Deducted but Subscription Not Activated
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            If your bank account or payment method has been charged but
            your subscription is not activated, please contact support
            with your transaction details.
        </p>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We will verify the transaction with the payment records and
            take appropriate action, which may include activating the
            service or processing an eligible refund.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            5. Refund Processing
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Where a refund is approved, it will normally be initiated
            through the applicable payment channel. The time taken for the
            refunded amount to appear in the user's account may depend on
            the payment provider or bank.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            6. Non-Refundable Situations
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Refunds may not be available for normal usage of a service,
            completed tests, or situations where the subscription was
            successfully activated and used, except where required by
            applicable law or where otherwise specifically approved.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            7. How to Request a Refund
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            To request a refund or report a payment issue, contact our
            support team with your registered email address and relevant
            transaction information.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            8. Fraudulent Transactions
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Transactions suspected to involve fraud, unauthorized use or
            misuse may be investigated before any refund or account action
            is taken.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            9. Policy Changes
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            This Refund & Cancellation Policy may be updated when required.
            Changes will be published on this page.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            10. Contact Us
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            For refund requests, payment issues or cancellation questions,
            please contact us using the support/contact details provided
            on the website.
        </p>
    </section>

    <div class="mt-10 rounded-xl border border-[#d9eafb] bg-[#f5faff] p-4">

        <div class="flex items-start gap-3">

            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#e4f1ff] text-[#2874b9]">
                <i data-lucide="info" class="h-4 w-4"></i>
            </div>

            <div>

                <p class="text-sm font-semibold text-[#1f5d94]">
                    Payment support
                </p>

                <p class="mt-1 text-xs leading-5 text-[#667085]">
                    Please keep your payment transaction ID or receipt
                    available when contacting support about a payment issue.
                </p>

            </div>

        </div>

    </div>

</div>

<div class="mt-8 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-[#667085]">

    <a href="{{ route('terms') }}" class="hover:text-[#2874b9] cursor-pointer">
        Terms & Conditions
    </a>

    <span class="text-[#d0d5dd]">•</span>

    <a href="{{ route('privacy') }}" class="hover:text-[#2874b9] cursor-pointer">
        Privacy Policy
    </a>

    <span class="text-[#d0d5dd]">•</span>

    <a href="{{ route('refund') }}" class="hover:text-[#2874b9] cursor-pointer">
        Refund & Cancellation
    </a>

</div>

<p class="mt-3 text-center text-xs text-[#98a2b3]">
    © {{ date('Y') }} Library Management System. All rights reserved.
</p>

</main>

<script>
    lucide.createIcons();
</script>

</body>
</html>
