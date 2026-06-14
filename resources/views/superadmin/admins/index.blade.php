<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="font-bold text-xl text-slate-800 dark:text-white">Kindergartens</h2>
            <a href="{{ route('superadmin.admins.create') }}" class="px-4 py-2 rounded-lg bg-teal-600 hover:bg-teal-700 text-white font-semibold shadow-md text-sm">+ Nouveau kindergarten</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded-lg bg-green-100 border border-green-400 text-green-700 px-4 py-3">{{ session('success') }}</div>
            @endif

            @if(session('temp_password'))
                @php($tp = session('temp_password'))
                <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-indigo-900 text-white p-6 shadow-xl">
                    <p class="text-indigo-200 text-sm uppercase tracking-wider font-semibold">Mot de passe temporaire</p>
                    <h3 class="text-2xl font-bold mt-1">{{ $tp['name'] }}</h3>
                    <p class="text-indigo-200 text-sm">{{ $tp['email'] }}</p>
                    <div class="mt-3 font-mono font-bold text-2xl tracking-widest bg-white/15 rounded-lg px-4 py-2 inline-block select-all">{{ $tp['password'] }}</div>
                    <p class="text-indigo-100 text-xs mt-3 max-w-md">À changer dès la première connexion via Supabase Auth.</p>
                </div>
            @endif

            <div class="card-premium p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800">
                            <tr>
                                <th class="px-4 py-2 text-left font-semibold">Établissement</th>
                                <th class="px-4 py-2 text-left font-semibold">Email</th>
                                <th class="px-4 py-2 text-right font-semibold">Tarif TND</th>
                                <th class="px-4 py-2 text-right font-semibold">Parents</th>
                                <th class="px-4 py-2 text-right font-semibold">Éducateurs</th>
                                <th class="px-4 py-2 text-left font-semibold">Statut</th>
                                <th class="px-4 py-2 text-left font-semibold">Échéance</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse($admins as $admin)
                                <tr>
                                    <td class="px-4 py-2 font-medium">{{ $admin->name }}</td>
                                    <td class="px-4 py-2 text-slate-500">{{ $admin->email }}</td>
                                    <td class="px-4 py-2 text-right">{{ $admin->monthly_tuition_tnd ? number_format($admin->monthly_tuition_tnd, 0, ',', ' ') : '—' }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">{{ $admin->parents_count }}</td>
                                    <td class="px-4 py-2 text-right font-semibold">{{ $admin->educators_count }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                            {{ $admin->subscription_status === 'frozen' ? 'bg-rose-100 text-rose-700' : ($admin->subscription_status === 'grace' ? 'bg-amber-100 text-amber-700' : 'bg-teal-100 text-teal-700') }}">
                                            {{ $admin->subscription_status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-slate-500">{{ $admin->subscription_due_at?->format('d M Y') ?? '—' }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <div class="inline-flex items-center gap-2">
                                            <a href="{{ route('superadmin.admins.codes', $admin->id) }}"
                                               title="Voir les codes parents et éducateurs"
                                               class="inline-flex items-center justify-center p-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-300 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </a>
                                            <form action="{{ route('superadmin.admins.destroy', $admin->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer {{ $admin->name }} ?');">
                                                @csrf @method('DELETE')
                                                <button class="text-rose-600 hover:text-rose-800 font-semibold text-xs">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="8" class="px-4 py-6 text-center text-slate-400">Aucun kindergarten.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
