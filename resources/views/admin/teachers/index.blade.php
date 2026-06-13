{{-- View: admin.teachers.index | Role: admin | Module: Teachers --}}

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Gestion des Enseignants') }}
            </h2>
            <a href="{{ route('admin.teachers.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Ajouter un Enseignant
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

            @if(session('educator_passcode'))
                @php($pc = session('educator_passcode'))
                <div class="mb-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-700 text-white p-6 shadow-xl shadow-indigo-200">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-indigo-100 text-sm uppercase tracking-wider font-semibold">Nouveau code éducateur</p>
                            <h3 class="text-2xl font-bold mt-1">{{ $pc['name'] }}</h3>
                            <p class="text-indigo-100 text-sm">{{ $pc['email'] }}</p>
                            <p class="text-indigo-50 text-xs mt-3 max-w-md">
                                Communiquez ce code une seule fois. L'éducateur se connecte via
                                <code class="bg-white/20 px-1 rounded">/login/code</code>. Il ne sera plus affiché.
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="font-mono font-bold text-5xl tracking-[0.4em] bg-white/15 rounded-xl px-6 py-4 select-all">
                                {{ $pc['passcode'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Nom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Prénom</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Téléphone</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($teachers as $teacher)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->nom }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->prenom }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{ $teacher->telephone ?: 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-2">Modifier</a>
                                            <form action="{{ route('admin.teachers.regeneratePasscode', $teacher->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Régénérer un nouveau code à 6 chiffres ?');">
                                                @csrf
                                                <button type="submit" class="text-teal-600 hover:text-teal-900 dark:text-teal-400 dark:hover:text-teal-300 mr-2">Nouveau code</button>
                                            </form>
                                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Supprimer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Aucun enseignant trouvé.</td>
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
