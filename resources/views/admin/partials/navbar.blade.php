    <!-- =====================================================
         TOP NAVBAR
    ====================================================== -->

    <header class="sticky top-0 z-30 h-[82px] border-b border-[#e4e8ef] bg-white">

        <div class="flex h-full items-center px-5 sm:px-7">

            <!-- Hamburger -->
            <button onclick="toggleSidebar()"
                    class="mr-auto flex h-10 w-10 items-center justify-center rounded-lg text-[#667085] hover:bg-gray-100 lg:mr-0">

                <i data-lucide="menu" class="h-6 w-6"></i>

            </button>


            <!-- Right Navigation -->
            <div class="ml-auto flex items-center gap-2 sm:gap-3">


                


                


                


               

                




               <div x-data="{ open: false }" class="relative">

    <!-- User -->
    <button
        @click="open = !open"
        type="button"
        class="flex items-center gap-2 rounded-lg px-1 py-1 hover:bg-gray-50"
    >

        <div class="flex h-10 w-10 items-center justify-center rounded-full border border-blue-200 bg-blue-50 text-sm font-semibold text-[#3576b7]">
            {{substr(Auth::user()->name,0,1)}}
        </div>

        <div class="hidden text-left md:block">
            <p class="text-sm font-semibold text-[#27364b]">
                {{Auth::user()->name}}
            </p>

            <p class="text-xs text-[#8995a8]">
                {{Auth::user()->role}}
            </p>
        </div>

        <i
            data-lucide="chevron-down"
            class="hidden h-4 w-4 text-[#8995a8] md:block"
        ></i>

    </button>


    <!-- Dropdown -->
    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute right-0 z-50 mt-2 w-48 rounded-xl border border-gray-200 bg-white p-2 shadow-lg"
    >

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50"
            >
                <i data-lucide="log-out" class="h-4 w-4"></i>

                <span>Logout</span>
            </button>
            

        </form>
        <a
                type="submit" href="{{route('profile.edit')}}"
                class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-red-600 hover:bg-red-50"
            >
                <i data-lucide="user-pen" class="h-4 w-4"></i>

                <span>setting</span>
            </a>
    </div>

</div>
                

            </div>

        </div>

    </header>
