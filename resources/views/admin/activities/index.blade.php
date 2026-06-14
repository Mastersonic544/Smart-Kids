{{-- View: admin.activities.index | Role: admin | Module: Activities --}}
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion des Activités') }}
            </h2>
            <a href="{{ route('admin.activities.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter une Activité
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @php($pending = $activities->where('status', \App\Enums\ActivityStatus::PendingApproval))
            @if($pending->isNotEmpty())
                <div class="mb-6 rounded-2xl bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-700">
                    <div class="px-6 py-4 border-b border-amber-200 dark:border-amber-700">
                        <h3 class="font-bold text-amber-900 dark:text-amber-200">{{ $pending->count() }} demande(s) en attente d'approbation</h3>
                    </div>
                    <div class="divide-y divide-amber-100 dark:divide-amber-800">
                        @foreach($pending as $req)
                            <div class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-slate-800 dark:text-white">{{ $req->name }}</p>
                                    <p class="text-sm text-slate-500">
                                        Proposé par {{ $req->requester?->name ?? 'Éducateur' }} •
                                        {{ \Carbon\Carbon::parse($req->scheduled_date)->translatedFormat('d F Y') }} à {{ \Carbon\Carbon::parse($req->scheduled_time)->format('H:i') }}
                                    </p>
                                    @if($req->description)
                                        <p class="text-sm text-slate-400 mt-1">{{ $req->description }}</p>
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('admin.activities.approve', $req->id) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1.5 rounded-lg bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold">Approuver</button>
                                    </form>
                                    <form action="{{ route('admin.activities.reject', $req->id) }}" method="POST" onsubmit="this.querySelector('[name=rejection_reason]').value = prompt('Motif du refus (facultatif) :', '') || ''; return true;">
                                        @csrf
                                        <input type="hidden" name="rejection_reason" value="">
                                        <button class="px-3 py-1.5 rounded-lg bg-rose-600 hover:bg-rose-700 text-white text-sm font-semibold">Refuser</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activité</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Éducateur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($activities as $activity)
                                    @php($status = $activity->status instanceof \App\Enums\ActivityStatus ? $activity->status : null)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($status)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold bg-{{ $status->color() }}-100 text-{{ $status->color() }}-700">
                                                    {{ $status->label() }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->scheduled_date }} à {{ \Carbon\Carbon::parse($activity->scheduled_time)->format('H:i') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $activity->educator->nom ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.activities.show', $activity->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2">Gérer et Présences</a>
                                            <a href="{{ route('admin.activities.edit', $activity->id) }}" class="text-blue-600 hover:text-blue-900 mr-2">Modifier</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucune activité programmée.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
