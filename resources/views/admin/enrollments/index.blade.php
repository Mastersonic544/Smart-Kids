<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Inscriptions</h2>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            @if(session('success'))
                <div class="rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm">{{ session('success') }}</div>
            @endif

            @if($enrollments->isEmpty())
                <div class="card-premium p-8 sm:p-12 text-center">
                    <p class="text-slate-500">Aucune demande d'inscription en attente.</p>
                </div>
            @else
                <div class="card-premium overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Enfant</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Reçue le</th>
                                    <th class="px-4 py-3 text-left font-semibold text-slate-600 dark:text-slate-300">Statut</th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @foreach($enrollments as $e)
                                    <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40">
                                        <td class="px-4 py-3 font-medium">{{ $e->child?->prenom }} {{ $e->child?->nom }}</td>
                                        <td class="px-4 py-3 text-slate-500">{{ $e->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3">
                                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                                {{ $e->statut === 'approuvé' ? 'bg-teal-100 text-teal-700' : ($e->statut === 'rejeté' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ ucfirst($e->statut) }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-right">
                                            <a href="{{ route('admin.enrollments.edit', $e) }}" class="text-teal-600 hover:text-teal-800 text-sm font-semibold">Traiter</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-4 py-3 border-t border-slate-100 dark:border-slate-700">{{ $enrollments->links() }}</div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
