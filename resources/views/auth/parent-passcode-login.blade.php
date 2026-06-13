<x-guest-layout>
    <div class="space-y-4">
        <div class="text-center space-y-1">
            <h1 class="text-2xl font-bold text-slate-800 dark:text-white">Espace Parent</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Entrez le code à 6 chiffres remis par l'établissement.
            </p>
        </div>

        @if ($errors->any())
            <div class="rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('parent.passcode.attempt') }}" class="space-y-4">
            @csrf

            <div>
                <label for="passcode" class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">
                    Code d'accès
                </label>
                <input
                    id="passcode"
                    name="passcode"
                    type="text"
                    inputmode="numeric"
                    autocomplete="one-time-code"
                    maxlength="6"
                    pattern="[0-9]{6}"
                    required
                    autofocus
                    class="w-full text-center tracking-[0.6em] text-2xl font-mono font-bold py-3 rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 focus:ring-2 focus:ring-teal-500 focus:border-teal-500"
                    placeholder="• • • • • •"
                />
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-teal-600 hover:bg-teal-700 text-white font-bold shadow-lg shadow-teal-200 dark:shadow-teal-900 transition-colors">
                Se connecter
            </button>
        </form>

        <div class="text-center text-sm text-slate-500 dark:text-slate-400 pt-2 border-t border-slate-100 dark:border-slate-700">
            Personnel administratif ou éducatif ?
            <a href="{{ route('login') }}" class="text-teal-600 font-semibold hover:underline">Connexion avec email</a>
        </div>
    </div>
</x-guest-layout>
