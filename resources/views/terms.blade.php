<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="icon" type="image/png" href="{{ asset('svg.svg') }}">

<title>Terms & Conditions - Library Management System</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="min-h-screen bg-[#f8fafc] text-[#1f2937] antialiased">


{{-- ================= NAVBAR ================= --}}
<header class="border-b border-[#e4e8ef] bg-white">

    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-5 sm:px-8">

        <a
            href="{{ url('/') }}"
            class="flex items-center gap-3 cursor-pointer"
        >
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


{{-- ================= CONTENT ================= --}}
<main class="mx-auto max-w-4xl px-5 py-10 sm:px-8 sm:py-14">

    {{-- Header --}}
    <div class="mb-8">

        <div class="mb-4 inline-flex items-center gap-2 rounded-full bg-[#eef6ff] px-3 py-1.5 text-xs font-semibold text-[#2874b9]">
            <i data-lucide="file-text" class="h-3.5 w-3.5"></i>
            Legal Information
        </div>

        <h1 class="text-3xl font-bold tracking-tight text-[#101828] sm:text-4xl">
            Terms & Conditions
        </h1>

        <p class="mt-3 text-sm leading-6 text-[#667085] sm:text-base">
            Please read these terms carefully before using our library
            management and online test subscription services.
        </p>

        <p class="mt-2 text-xs text-[#98a2b3]">
            Last updated: {{ date('F Y') }}
        </p>

    </div>


    {{-- Main Card --}}
    <div class="rounded-2xl border border-[#e4e8ef] bg-white p-6 shadow-sm sm:p-8">

        {{-- 1 --}}
        <section>

            <h2 class="text-lg font-bold text-[#101828]">
                1. Acceptance of Terms
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                By accessing or using this website and its services, you
                agree to comply with these Terms & Conditions. If you do
                not agree with any part of these terms, please do not use
                the website or its services.
            </p>

        </section>


        {{-- 2 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                2. Account Registration
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Users may be required to create an account to access
                certain services, including online tests and subscription
                features. Users are responsible for providing accurate
                information and maintaining the confidentiality of their
                login credentials.
            </p>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Users must not share their account credentials with other
                individuals. An account may be restricted or terminated
                if misuse or unauthorized access is detected.
            </p>

        </section>


        {{-- 3 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                3. Online Test Subscription
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Certain online tests and study resources may be available
                only to users with an active subscription. Subscription
                access is provided according to the plan selected by the
                user at the time of purchase.
            </p>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Subscription validity, available tests and other features
                may vary depending on the selected plan.
            </p>

        </section>


        {{-- 4 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                4. Payments
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Payments for subscriptions or other paid services are
                processed through the payment gateway available on the
                website. The payment amount displayed at checkout is the
                amount applicable to the selected service or subscription.
            </p>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                We do not store your complete card, UPI or banking
                credentials on our servers. Payment processing is handled
                by the applicable payment service provider.
            </p>

        </section>


        {{-- 5 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                5. Payment Confirmation
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                A subscription is considered successfully purchased only
                after payment has been successfully verified by our
                payment system.
            </p>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                If money is deducted from your account but the subscription
                is not activated, please contact us with the relevant
                payment details so that the transaction can be checked.
            </p>

        </section>


        {{-- 6 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                6. Refund & Cancellation
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Refunds and cancellations are handled according to our
                Refund & Cancellation Policy. Users should review that
                policy before purchasing a subscription.
            </p>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                In case of duplicate payment, failed activation after
                successful payment, or another payment-related issue,
                users may contact support for verification.
            </p>

        </section>


        {{-- 7 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                7. Test Content
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Test papers, questions, explanations, images, documents
                and other educational content available through the
                platform are intended for personal educational use.
            </p>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                Users must not reproduce, redistribute, sell, publish or
                commercially exploit protected content without
                authorization.
            </p>

        </section>


        {{-- 8 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                8. Prohibited Activities
            </h2>

            <ul class="mt-3 space-y-2 text-sm leading-7 text-[#667085]">

                <li class="flex gap-2">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#2874b9]"></span>
                    Unauthorized access to another user's account.
                </li>

                <li class="flex gap-2">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#2874b9]"></span>
                    Sharing subscription access with other individuals.
                </li>

                <li class="flex gap-2">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#2874b9]"></span>
                    Attempting to bypass access restrictions.
                </li>

                <li class="flex gap-2">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#2874b9]"></span>
                    Copying or distributing protected test content without permission.
                </li>

                <li class="flex gap-2">
                    <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-[#2874b9]"></span>
                    Using the website for unlawful or fraudulent activities.
                </li>

            </ul>

        </section>


        {{-- 9 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                9. Account Suspension
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                We reserve the right to suspend or restrict an account
                where there is evidence of unauthorized access, misuse,
                fraudulent activity, violation of these terms, or other
                activity that may affect the security or operation of the
                platform.
            </p>

        </section>


        {{-- 10 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                10. Service Availability
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                We aim to keep the website and services available and
                functional. However, temporary interruptions may occur due
                to maintenance, technical issues, hosting problems,
                internet connectivity or circumstances beyond our
                reasonable control.
            </p>

        </section>


        {{-- 11 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                11. Changes to These Terms
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                These Terms & Conditions may be updated from time to time.
                Updated terms will be published on this page. Continued
                use of the website after an update indicates acceptance of
                the revised terms.
            </p>

        </section>


        {{-- 12 --}}
        <section class="mt-8">

            <h2 class="text-lg font-bold text-[#101828]">
                12. Contact Us
            </h2>

            <p class="mt-3 text-sm leading-7 text-[#667085]">
                If you have questions regarding these Terms & Conditions,
                payments, subscriptions or account access, please contact
                our support team through the contact details provided on
                the website.
            </p>

        </section>


        {{-- Important Notice --}}
        <div class="mt-10 rounded-xl border border-[#d9eafb] bg-[#f5faff] p-4">

            <div class="flex items-start gap-3">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-[#e4f1ff] text-[#2874b9]">
                    <i data-lucide="info" class="h-4 w-4"></i>
                </div>

                <div>

                    <p class="text-sm font-semibold text-[#1f5d94]">
                        Important
                    </p>

                    <p class="mt-1 text-xs leading-5 text-[#667085]">
                        Please also review our Privacy Policy and Refund &
                        Cancellation Policy before purchasing any paid
                        subscription or service.
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Footer Links --}}
    <div class="mt-8 flex flex-wrap items-center justify-center gap-x-5 gap-y-2 text-xs text-[#667085]">

        <a
            href="{{ route('terms') }}"
            class="hover:text-[#2874b9] cursor-pointer"
        >
            Terms & Conditions
        </a>

        <span class="text-[#d0d5dd]">•</span>

        <a
            href="#"
            class="hover:text-[#2874b9] cursor-pointer"
        >
            Privacy Policy
        </a>

        <span class="text-[#d0d5dd]">•</span>

        <a
            href="#"
            class="hover:text-[#2874b9] cursor-pointer"
        >
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
