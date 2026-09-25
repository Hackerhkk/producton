

<nav class="hidden min-[816px]:block px-4 pt-4 sm:px-6 lg:px-8">

    <div
        class="mx-auto flex h-[68px] max-w-7xl items-center justify-between rounded-2xl border border-[#e4e8ef] bg-white/95 px-4 shadow-[0_8px_30px_rgba(16,24,40,0.06)] backdrop-blur-md sm:px-5"
    >

        {{-- ================= LOGO ================= --}}
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

                

            </div>

        </a>


        {{-- ================= DESKTOP NAVIGATION ================= --}}
        <div class="flex items-center gap-1">

            {{-- Dashboard --}}
            <a
                href="{{ route('dashboard') }}"
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#2874b9] transition hover:bg-[#eef6ff] cursor-pointer"
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
                class="flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium text-[#667085] transition hover:bg-[#f5f8fb] hover:text-[#2874b9] cursor-pointer"
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
                class="ml-1"
            >

                @csrf

                <button
                    type="submit"
                    class="flex items-center gap-2 rounded-xl bg-[#2874b9] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#205f98] cursor-pointer"
                >

                    <i
                        data-lucide="log-out"
                        class="h-4 w-4"
                    ></i>

                    <span>
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </div>

</nav>



{{-- =========================================================
     MOBILE BOTTOM NAVIGATION
     0 - 815px
========================================================= --}}

<nav
    class="fixed inset-x-0 bottom-0 z-50 min-[816px]:hidden border-t border-[#e4e8ef] bg-white/95 px-2 pb-[env(safe-area-inset-bottom)] pt-2 shadow-[0_-10px_30px_rgba(16,24,40,0.08)] backdrop-blur-md"
>

    <div class="mx-auto grid max-w-md grid-cols-5">


        {{-- ================= HOME ================= --}}
        <a
            href="{{ route('dashboard') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#2874b9] transition active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl bg-[#eef6ff]"
            >

                <i
                    data-lucide="home"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-bold">
                Home
            </span>

        </a>



        {{-- ================= TESTS ================= --}}
        <a
            href="{{ route('student.tests.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
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



        {{-- ================= SUBSCRIPTION ================= --}}
        <a
            href="{{ route('subscription.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
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



        {{-- ================= SHORT URL ================= --}}
        <a
            href="{{ route('short-url.index') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
        >

            <div
                class="flex h-8 w-8 items-center justify-center rounded-xl"
            >

                <i
                    data-lucide="link-2"
                    class="h-[18px] w-[18px]"
                ></i>

            </div>

            <span class="text-[10px] font-semibold">
                Links
            </span>

        </a>



        {{-- ================= PROFILE ================= --}}
        <a
            href="{{ route('profile.edit') }}"
            class="group flex cursor-pointer flex-col items-center justify-center gap-1 rounded-xl px-1 py-1.5 text-[#667085] transition hover:text-[#2874b9] active:scale-95"
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
