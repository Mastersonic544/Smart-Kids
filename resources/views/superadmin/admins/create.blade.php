<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Nouveau kindergarten</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="card-premium p-6">
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('superadmin.admins.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-semibold mb-1">Nom de l'établissement *</label>
                        <input id="name" name="name" type="text" value="{{ old('name') }}" required
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold mb-1">Email administrateur *</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-semibold mb-1">Téléphone</label>
                        <input id="phone" name="phone" type="text" value="{{ old('phone') }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label for="monthly_tuition_tnd" class="block text-sm font-semibold mb-1">Tarif mensuel par enfant (TND)</label>
                        <input id="monthly_tuition_tnd" name="monthly_tuition_tnd" type="number" step="0.001" min="0" value="{{ old('monthly_tuition_tnd') }}"
                               class="w-full rounded-lg border-slate-300 dark:border-slate-600 dark:bg-slate-900 focus:ring-teal-500 focus:border-teal-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-1">Cycle de facturation *</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-300 dark:border-slate-600 cursor-pointer has-[input:checked]:border-teal-500 has-[input:checked]:bg-teal-50 dark:has-[input:checked]:bg-teal-900/20">
                                <input type="radio" name="billing_period" value="monthly" {{ old('billing_period', 'monthly') === 'monthly' ? 'checked' : '' }}>
                                <span class="font-semibold">Mensuel</span>
                            </label>
                            <label class="flex items-center gap-2 p-3 rounded-lg border border-slate-300 dark:border-slate-600 cursor-pointer has-[input:checked]:border-teal-500 has-[input:checked]:bg-teal-50 dark:has-[input:checked]:bg-teal-900/20">
                                <input type="radio" name="billing_period" value="annual" {{ old('billing_period') === 'annual' ? 'checked' : '' }}>
                                <span class="font-semibold">Annuel <span class="text-emerald-600 text-xs">(-40%)</span></span>
                            </label>
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-2">
                        <a href="{{ route('superadmin.admins.index') }}" class="px-5 py-2.5 rounded-lg bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-center">Annuler</a>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-bold">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
