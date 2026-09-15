<section>


{{-- Header --}}
<div class="mb-6">

    <div class="flex items-center gap-2">
        <i
            data-lucide="user-round"
            class="h-4 w-4 text-[#2874b9]"
        ></i>

        <h2 class="text-base font-semibold text-[#1f2937]">
            {{ __('Profile Information') }}
        </h2>
    </div>

    <p class="mt-1 text-sm text-[#667085]">
        {{ __("Update your account's profile information and email address.") }}
    </p>

</div>


{{-- Email Verification --}}
<form
    id="send-verification"
    method="post"
    action="{{ route('verification.send') }}"
>
    @csrf
</form>


{{-- Profile Form --}}
<form
    method="post"
    action="{{ route('profile.update') }}"
    class="space-y-5"
>

    @csrf
    @method('patch')


    {{-- Name --}}
    <div>

        <label
            for="name"
            class="mb-1.5 block text-sm font-medium text-[#344054]"
        >
            {{ __('Name') }}
        </label>

        <input
            id="name"
            name="name"
            type="text"
            value="{{ old('name', $user->name) }}"
            required
            autofocus
            autocomplete="name"
            class="block w-full rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
        >

        @if ($errors->get('name'))
            <div class="mt-1.5 space-y-1">
                @foreach ($errors->get('name') as $error)
                    <p class="text-xs font-medium text-red-600">
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif

    </div>


    {{-- Email --}}
    <div>

        <label
            for="email"
            class="mb-1.5 block text-sm font-medium text-[#344054]"
        >
            {{ __('Email') }}
        </label>

        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email', $user->email) }}"
            required
            autocomplete="username"
            class="block w-full rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#2874b9] focus:ring-2 focus:ring-[#2874b9]/10"
        >

        @if ($errors->get('email'))
            <div class="mt-1.5 space-y-1">
                @foreach ($errors->get('email') as $error)
                    <p class="text-xs font-medium text-red-600">
                        {{ $error }}
                    </p>
                @endforeach
            </div>
        @endif


        {{-- Unverified Email --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

            <div class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-3.5 py-3">

                <div class="flex items-start gap-2.5">

                    <i
                        data-lucide="mail-warning"
                        class="mt-0.5 h-4 w-4 shrink-0 text-amber-600"
                    ></i>

                    <div>

                        <p class="text-sm text-amber-800">
                            {{ __('Your email address is unverified.') }}
                        </p>

                        <button
                            form="send-verification"
                            type="submit"
                            class="mt-1 text-sm font-semibold text-[#2874b9] underline decoration-[#2874b9]/40 underline-offset-2 hover:text-[#1f5d94]"
                        >
                            {{ __('Click here to re-send the verification email.') }}
                        </button>

                    </div>

                </div>


                @if (session('status') === 'verification-link-sent')

                    <div class="mt-2 flex items-center gap-2 text-sm font-medium text-green-600">

                        <i
                            data-lucide="circle-check"
                            class="h-4 w-4"
                        ></i>

                        <span>
                            {{ __('A new verification link has been sent to your email address.') }}
                        </span>

                    </div>

                @endif

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


        @if (session('status') === 'profile-updated')

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
