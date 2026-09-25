<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">


<title>Privacy Policy - Library Management System</title>

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
        <i data-lucide="shield-check" class="h-3.5 w-3.5"></i>
        Privacy
    </div>

    <h1 class="text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">
        Privacy Policy
    </h1>

    <p class="mt-3 text-sm leading-6 text-[#667085] sm:text-base">
        This Privacy Policy explains how we collect, use and protect
        information when you use our website and services.
    </p>

    <p class="mt-2 text-xs text-[#98a2b3]">
        Last updated: {{ date('F Y') }}
    </p>

</div>

<div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">

    <section>
        <h2 class="text-lg font-bold text-[#101828]">
            1. Information We Collect
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We may collect information that you provide when creating an
            account, using our services, contacting support or purchasing
            a subscription.
        </p>

        <ul class="mt-3 space-y-2 text-sm leading-7 text-[#667085]">
            <li>• Name and email address</li>
            <li>• Mobile number, where provided</li>
            <li>• Account and login information</li>
            <li>• Test and subscription activity</li>
            <li>• Payment and transaction information</li>
            <li>• Information submitted through support requests</li>
        </ul>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            2. How We Use Information
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Information may be used to create and manage your account,
            provide subscriptions and tests, process transactions,
            maintain security, provide customer support and improve our
            services.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            3. Payment Information
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Payments may be processed through third-party payment
            providers such as Razorpay. Payment information required to
            complete a transaction is processed by the applicable payment
            provider according to its own policies and security practices.
        </p>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We do not intentionally store complete card numbers, CVV
            information, UPI PINs or banking passwords on our application
            servers.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            4. Cookies and Sessions
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Our website may use cookies and session technologies to keep
            users logged in, maintain security and provide required
            functionality.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            5. Data Security
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We take reasonable technical and organizational measures to
            protect information against unauthorized access, alteration,
            disclosure or destruction. However, no internet-based system
            can be guaranteed to be completely secure.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            6. Sharing of Information
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We may share information with service providers when necessary
            to operate the website, process payments, provide hosting,
            maintain security or comply with applicable legal requirements.
        </p>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We do not sell personal information to third parties for their
            independent marketing purposes.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            7. Account Security
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            You are responsible for keeping your account credentials
            secure. If you believe that your account has been accessed
            without authorization, please contact us as soon as possible.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            8. Data Retention
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            We may retain account, transaction and service-related
            information for as long as reasonably necessary to provide
            services, maintain records, resolve disputes, prevent fraud or
            comply with applicable legal obligations.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            9. Your Rights
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            Depending on applicable law, you may have rights regarding
            access, correction or deletion of certain personal information.
            Requests may be submitted through our support/contact channel.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            10. Policy Updates
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            This Privacy Policy may be updated from time to time. Any
            changes will be published on this page with an updated date.
        </p>
    </section>

    <section class="mt-8">
        <h2 class="text-lg font-bold text-[#101828]">
            11. Contact Us
        </h2>

        <p class="mt-3 text-sm leading-7 text-[#667085]">
            For privacy-related questions or requests, please contact us
            using the support/contact details provided on the website.
        </p>
    </section>

    <div class="mt-10 rounded-xl border border-[#d9eafb] bg-[#f5faff] p-4">

        <div class="flex items-start gap-3">

            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#e4f1ff] text-[#2874b9]">
                <i data-lucide="info" class="h-4 w-4"></i>
            </div>

            <div>
                <p class="text-sm font-semibold text-[#1f5d94]">
                    Privacy matters
                </p>

                <p class="mt-1 text-xs leading-5 text-[#667085]">
                    We use personal information only as reasonably required
                    to provide and secure our services.
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
