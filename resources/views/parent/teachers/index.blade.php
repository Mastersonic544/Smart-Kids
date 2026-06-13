{{-- View: parent.teachers.index | Role: parent | Module: ParentTeachers --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Enseignants de mes enfants</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($teachersByChild as $childId => $data)
                    <div class="card-premium p-6">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100 dark:border-slate-700">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold shadow">
                                {{ substr($data['child']->prenom, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 dark:text-white">{{ $data['child']->prenom }} {{ $data['child']->nom }}</p>
                                <p class="text-xs text-slate-400">{{ $data['child']->classroom?->nom ?? 'Pas de classe' }}</p>
                            </div>
                        </div>

                        @if($data['teacher'])
                            <div class="flex items-center gap-4">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-500 flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                                    {{ substr($data['teacher']->prenom, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-lg text-slate-800 dark:text-white">{{ $data['teacher']->prenom }} {{ $data['teacher']->nom }}</p>
                                    <p class="text-sm text-slate-500">{{ $data['teacher']->email }}</p>
                                    @if($data['teacher']->telephone)
                                        <p class="text-sm text-slate-500 flex items-center gap-1"><svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg> {{ $data['teacher']->telephone }}</p>
                                    @endif
                                </div>
                            </div>

                            @if($data['teacher']->user_id)
                                <div class="mt-4">
                                    <a href="{{ route('messages.conversation', $data['teacher']->user_id) }}" class="btn-primary w-full justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                        Envoyer un message
                                    </a>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <p class="text-slate-400">Aucun enseignant assigné à cette classe.</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="card-premium p-8 text-center col-span-2">
                        <p class="text-slate-500">Aucun enfant lié à votre compte.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
