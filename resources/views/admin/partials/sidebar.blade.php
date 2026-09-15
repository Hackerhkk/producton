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
        <button onclick="toggleSidebar()"
                class="ml-auto rounded-lg p-2 text-gray-500 hover:bg-gray-100 lg:hidden">
            <i data-lucide="x" class="h-5 w-5"></i>
        </button>

    </div>


    <!-- Sidebar Content -->
    <div class="hide-scrollbar flex-1 overflow-y-auto px-4 py-4">

        

        <!-- Dashboard -->
        <a href="{{route('dashboard')}}"
           class="mb-1 flex h-12 items-center gap-4 rounded-xl bg-[#edf5fd] px-4 text-[15px] font-semibold text-[#2168ae]">

            <i data-lucide="layout-grid" class="h-5 w-5"></i>

            <span>Dashboard</span>

        </a>


        
       <a href="{{route('admin.student.index')}}"
   class="sidebar-item">

    <i data-lucide="contact" class="h-5 w-5"></i>

    <span>Student</span>

    <i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>

</a>

<a href="{{ route('admin.fee-wallet-report') }}"
   class="sidebar-item">

    <i data-lucide="wallet-cards" class="h-5 w-5"></i>

    <span>Fee & Wallet Report</span>
<i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>
</a>


        
        <a href="{{ route('admin.fees.index') }}"
   class="sidebar-item">

    <i data-lucide="credit-card-check" class="h-5 w-5 text-blue-600"></i>

    <span>Fees</span>

    <i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>

</a>


        

      
        <a href="{{route('admin.library.index')}}"
           class="sidebar-item">

            <i data-lucide="library" class="h-5 w-5 text-green-500"></i>

            <span>Library</span>

            <i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>

        </a>
      
        <a href="{{route('admin.seat.index')}}"
           class="sidebar-item">

            <i data-lucide="armchair" class="h-5 w-5 text-grey-500"></i>

            <span>Seat</span>

            <i data-lucide="chevron-down" class="ml-auto h-4 w-4"></i>

        </a>


       

    </div>

</aside>