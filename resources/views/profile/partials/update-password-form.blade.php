<section>


{{-- Header --}}
<div class="mb-6">

    <div class="flex items-center gap-2">
        <i
            data-lucide="lock-keyhole"
            class="h-4 w-4 text-[#2874b9]"
        ></i>

        <h2 class="text-base font-semibold text-[#1f2937]">
            {{ __('Update Password') }}
        </h2>
    </div>

    <p class="mt-1 text-sm text-[#667085]">
        {{ __('Ensure your account is using a long, random password to stay secure.') }}
    </p>

</div>


{{-- Password Form --}}
<form
    method="post"
    action="{{ route('password.update') }}"
    class="space-y-5"
>

    @csrf
    @method('put')


    {{-- Current Password --}}
    <div>

        <label
            for="update_password_current_password"
            class="mb-1.5 block text-sm font-medium text-[#344054]"
        >
            {{ __('Current Password') }}
        </label>

        <div class="relative">

            <input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="block w-full rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2.5 pr-11 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
            >

        </div>

        @if ($errors->updatePassword->get('current_password'))
            <div class="mt-1.5 space-y-1">
                @foreach ($errors->updatePassword->get('current_password') as $error)
                    <p class="text-xs font-medium text-red-600">
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

    </div>


    {{-- New Password --}}
    <div>

        <label
            for="update_password_password"
            class="mb-1.5 block text-sm font-medium text-[#344054]"
        >
            {{ __('New Password') }}
        </label>

        <input
            id="update_password_password"
            name="password"
            type="password"
            autocomplete="new-password"
            class="block w-full rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
        >

        @if ($errors->updatePassword->get('password'))
            <div class="mt-1.5 space-y-1">
                @foreach ($errors->updatePassword->get('password') as $error)
                    <p class="text-xs font-medium text-red-600">
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

    </div>


    {{-- Confirm Password --}}
    <div>

        <label
            for="update_password_password_confirmation"
            class="mb-1.5 block text-sm font-medium text-[#344054]"
        >
            {{ __('Confirm Password') }}
        </label>

        <input
            id="update_password_password_confirmation"
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
            class="block w-full rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
        >

        @if ($errors->updatePassword->get('password_confirmation'))
            <div class="mt-1.5 space-y-1">
                @foreach ($errors->updatePassword->get('password_confirmation') as $error)
                    <p class="text-xs font-medium text-red-600">
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

    </div>


    {{-- Save --}}
    <div class="flex flex-wrap items-center gap-3 pt-1">

        <button
            type="submit"
            class="inline-flex items-center gap-2 rounded-lg bg-[#2874b9] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#21659f] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/20"
        >

            <i
                data-lucide="save"
                class="h-4 w-4"
            ></i>

            {{ __('Save Changes') }}

        </button>


        @if (session('status') === 'password-updated')

            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="flex items-center gap-1.5 text-sm font-medium text-green-600"
            >

                <i
                    data-lucide="circle-check"
                    class="h-4 w-4"
                ></i>

                {{ __('Saved successfully.') }}

            </p>

        @endif

    </div>

</form>


</section>
