{{-- =====================================================
     TOP NAVBAR
====================================================== --}}

<header class="sticky top-0 z-20 h-[82px] border-b border-[#e4e8ef] bg-white">
    <div class="flex h-full items-center px-5 sm:px-7">

        {{-- Hamburger --}}
        <button
            type="button"
            onclick="toggleSidebar()"
            class="mr-auto flex h-10 w-10 cursor-pointer items-center justify-center rounded-lg text-[#667085] transition hover:bg-gray-100 lg:mr-0"
        >
            <i data-lucide="menu" class="h-6 w-6"></i>
        </button>

        {{-- Right Navigation --}}
        <div class="ml-auto flex items-center gap-2 sm:gap-3">

            {{-- User Menu --}}
            <div class="relative" id="userMenu">

                {{-- User Button --}}
                <button
                    type="button"
                    id="userMenuButton"
                    class="flex cursor-pointer items-center gap-2 rounded-lg px-1 py-1 transition hover:bg-gray-50"
                >
                    {{-- Avatar --}}
                    <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-200 bg-blue-50 text-sm font-semibold text-[#3576b7]">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>

                    {{-- Name & Role --}}
                    <div class="hidden text-left md:block">
                        <p class="text-sm font-semibold text-[#27364b]">
                            {{ Auth::user()->name }}
                        </p>

                        <p class="text-xs text-[#8995a8]">
                            {{ Auth::user()->role }}
                        </p>
                    </div>

                    {{-- Arrow --}}
                    <i
                        data-lucide="chevron-down"
                        id="userMenuIcon"
                        class="hidden h-4 w-4 text-[#8995a8] transition-transform md:block"
                    ></i>
                </button>

                {{-- Dropdown --}}
                <div
                    id="userDropdown"
                    class="absolute right-0 top-full z-50 mt-2 hidden w-52 rounded-xl border border-[#e4e8ef] bg-white p-2 shadow-lg"
                >

                    {{-- Profile --}}
                    <a
                        href="{{ route('profile.edit') }}"
                        class="flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-[#344054] transition hover:bg-[#f5f8fb] hover:text-[#2874b9]"
                    >
                        <i data-lucide="user-pen" class="h-4 w-4"></i>
                        <span>Profile Settings</span>
                    </a>

                    {{-- Divider --}}
                    <div class="my-1 border-t border-[#edf0f4]"></div>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="flex w-full cursor-pointer items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50"
                        >
                            <i data-lucide="log-out" class="h-4 w-4"></i>
                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');
    const userMenuIcon = document.getElementById('userMenuIcon');

    if (!userMenuButton || !userDropdown) {
        return;
    }

    userMenuButton.addEventListener('click', function (event) {
        event.stopPropagation();

        const isHidden = userDropdown.classList.contains('hidden');

        userDropdown.classList.toggle('hidden');

        if (userMenuIcon) {
            userMenuIcon.classList.toggle('rotate-180', isHidden);
        }
    });

    document.addEventListener('click', function (event) {
        const userMenu = document.getElementById('userMenu');

        if (!userMenu.contains(event.target)) {
            userDropdown.classList.add('hidden');

            if (userMenuIcon) {
                userMenuIcon.classList.remove('rotate-180');
            }
        }
    });
});
</script>
