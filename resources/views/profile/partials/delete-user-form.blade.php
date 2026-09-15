<section class="space-y-6">


{{-- Header --}}
<div>

    <div class="flex items-center gap-2">

        <i
            data-lucide="shield-alert"
            class="h-4 w-4 text-red-600"
        ></i>

        <h2 class="text-base font-semibold text-[#1f2937]">
            {{ __('Delete Account') }}
        </h2>

    </div>

    <p class="mt-1 text-sm leading-6 text-[#667085]">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>

</div>


{{-- Delete Button --}}
<button
    type="button"
    x-data
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    class="inline-flex items-center gap-2 rounded-lg border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500/20"
>

    <i
        data-lucide="trash-2"
        class="h-4 w-4"
    ></i>

    {{ __('Delete Account') }}

</button>


{{-- Confirmation Modal --}}
<x-modal
    name="confirm-user-deletion"
    :show="$errors->userDeletion->isNotEmpty()"
    focusable
>

    <form
        method="post"
        action="{{ route('profile.destroy') }}"
        class="p-6"
    >

        @csrf
        @method('delete')


        {{-- Modal Header --}}
        <div class="flex items-start gap-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-100 text-red-600">

                <i
                    data-lucide="trash-2"
                    class="h-5 w-5"
                ></i>

            </div>

            <div>

                <h2 class="text-lg font-semibold text-[#1f2937]">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-1 text-sm leading-6 text-[#667085]">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

            </div>

        </div>


        {{-- Password --}}
        <div class="mt-6">

            <label
                for="password"
                class="mb-1.5 block text-sm font-medium text-[#344054]"
            >
                {{ __('Password') }}
            </label>

            <input
                id="password"
                name="password"
                type="password"
                placeholder="{{ __('Password') }}"
                class="block w-full rounded-lg border border-[#d0d5dd] bg-white px-3.5 py-2.5 text-sm text-[#1f2937] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-red-500 focus:ring-2 focus:ring-red-500/10"
            >

            @if ($errors->userDeletion->get('password'))
                <div class="mt-1.5 space-y-1">

                    @foreach ($errors->userDeletion->get('password') as $error)

                        <p class="text-xs font-medium text-red-600">
                            {{ $error }}
                        </p>

                    @endforeach

                </div>
            @endif

        </div>


        {{-- Actions --}}
        <div class="mt-6 flex flex-wrap justify-end gap-3">

            <button
                type="button"
                x-on:click="$dispatch('close')"
                class="inline-flex items-center gap-2 rounded-lg border border-[#d0d5dd] bg-white px-4 py-2.5 text-sm font-semibold text-[#344054] shadow-sm transition hover:bg-[#f9fafb] focus:outline-none focus:ring-2 focus:ring-[#2874b9]/10"
            >

                <i
                    data-lucide="x"
                    class="h-4 w-4"
                ></i>

                {{ __('Cancel') }}

            </button>


            <button
                type="submit"
                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500/20"
            >

                <i
                    data-lucide="trash-2"
                    class="h-4 w-4"
                ></i>

                {{ __('Delete Account') }}

            </button>

        </div>

    </form>

</x-modal>


</section>
