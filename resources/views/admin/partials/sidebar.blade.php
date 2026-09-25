<!-- =========================================================
     SIDEBAR
========================================================= -->

<aside id="sidebar"
       class="sidebar-transition fixed left-0 top-0 z-50 flex h-screen w-[304px] -translate-x-full flex-col border-r border-[#e3e7ee] bg-white lg:translate-x-0">

    <!-- Logo -->
    <div class="flex h-[82px] shrink-0 items-center border-b border-[#e7eaf0] px-6">

        <div class="flex items-center gap-2">

            <div class="flex h-9 w-9 items-center justify-center rounded-md bg-[#4b8bd8] text-white">
                <i data-lucide="user" class="h-5 w-5"></i>
            </div>

            <div class="text-[27px] font-extrabold tracking-tight">
                Sr<span class="text-[#4b8bd8]">library</span>
            </div>

        </div>

        <!-- Mobile close -->
        <button
            onclick="toggleSidebar()"
            class="ml-auto cursor-pointer rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden"
        >
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>

    </div>


    <!-- Sidebar Content -->
    <div class="hide-scrollbar flex-1 overflow-y-auto px-4 py-4">


        <!-- Dashboard -->
        <a
            href="{{ route('dashboard') }}"
            class="mb-1 flex h-12 cursor-pointer items-center gap-4 rounded-xl bg-[#edf5fd] px-4 text-[15px] font-semibold text-[#2168ae]"
        >

            <i data-lucide="layout-grid" class="h-5 w-5"></i>

            <span>Dashboard</span>

        </a>


        <!-- Student -->
        <a
            href="{{ route('admin.student.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i data-lucide="contact" class="h-5 w-5"></i>

            <span>Student</span>

            <i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>

        </a>


        <!-- Fee & Wallet Report -->
        <a
            href="{{ route('admin.fee-wallet-report') }}"
            class="sidebar-item cursor-pointer"
        >

            <i data-lucide="wallet-cards" class="h-5 w-5"></i>

            <span>Fee & Wallet Report</span>

            <i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>

        </a>


        <!-- Fees -->
        <a
            href="{{ route('admin.fees.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="credit-card-check"
                class="h-5 w-5 text-blue-600"
            ></i>

            <span>Fees</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>


        <!-- Library -->
        <a
            href="{{ route('admin.library.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="library"
                class="h-5 w-5 text-green-500"
            ></i>

            <span>Library</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>

        <!-- Library -->
        <a
            href="{{ route('admin.seat.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="armchair"
                class="h-5 w-5 text-green-500"
            ></i>

            <span>Seat</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>
        <!-- Library -->
        <a
            href="{{ route('admin.seat-map.editor') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="bed"
                class="h-5 w-5 text-green-500"
            ></i>

            <span>Map-create</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>
        <a
            href="{{ route('admin.seat-map.view') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="bed"
                class="h-5 w-5 text-green-500"
            ></i>

            <span>Seat-map</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>





        <!-- =====================================================
             TEST SERIES
        ====================================================== -->

        <a
            href="{{ route('admin.test-series.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="clipboard-list"
                class="h-5 w-5 text-[#2874b9]"
            ></i>

            <span>Test Series</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>


        <!-- =====================================================
             TEST RESULTS
        ====================================================== -->

        <a
            href="{{ route('admin.test-results.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="clipboard-check"
                class="h-5 w-5 text-green-600"
            ></i>

            <span>Test Results</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>


        <!-- =====================================================
             SUBSCRIPTION PLANS
        ====================================================== -->

        <a
            href="{{ route('admin.subscription-plans.index') }}"
            class="{{ request()->routeIs('admin.subscription-plans.*')
                ? 'flex h-12 cursor-pointer items-center gap-4 rounded-xl bg-[#edf5fd] px-4 text-[15px] font-semibold text-[#2168ae]'
                : 'sidebar-item cursor-pointer' }}"
        >

            <i
                data-lucide="crown"
                class="h-5 w-5 {{ request()->routeIs('admin.subscription-plans.*') ? 'text-[#2874b9]' : 'text-[#2874b9]' }}"
            ></i>

            <span>Subscription Plans</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>


        <!-- =====================================================
             USER ACCOUNTS
        ====================================================== -->

        <a
            href="{{ route('admin.users.index') }}"
            class="sidebar-item cursor-pointer"
        >

            <i
                data-lucide="users"
                class="h-5 w-5 text-[#2874b9]"
            ></i>

            <span>User Accounts</span>

            <i
                data-lucide="chevron-down"
                class="ml-auto h-4 w-4"
            ></i>

        </a>


    </div>

</aside>
