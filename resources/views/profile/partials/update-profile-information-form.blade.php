<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6"
          x-data="{
            originalTuition: '{{ $user->monthly_tuition_tnd }}',
            confirmIfTuitionChanged(event) {
                if (!{{ $user->hasRole('admin') ? 'true' : 'false' }}) return;
                const field = this.$el.querySelector('input[name=monthly_tuition_tnd]');
                if (!field) return;
                const newVal = field.value.trim();
                if (newVal === this.originalTuition) return;
                const proceed = confirm(
                    'Changer le tarif mensuel à ' + newVal + ' TND ? '
                    + 'Tous les parents de votre établissement recevront une notification.'
                );
                if (!proceed) event.preventDefault();
            }
          }"
          @submit="confirmIfTuitionChanged($event)">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        @role('admin')
            <div class="border-t border-slate-200 dark:border-slate-700 pt-4">
                <x-input-label for="monthly_tuition_tnd" value="Frais de scolarité mensuels (TND)" />
                <x-text-input
                    id="monthly_tuition_tnd"
                    name="monthly_tuition_tnd"
                    type="number"
                    step="0.001"
                    min="0"
                    class="mt-1 block w-full"
                    :value="old('monthly_tuition_tnd', $user->monthly_tuition_tnd)"
                    placeholder="Ex: 450.000"
                />
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                    Modifier ce montant déclenchera une notification automatique à tous les parents inscrits.
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('monthly_tuition_tnd')" />
            </div>
        @endrole

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
