{{-- View: educateur.students.index | Role: educateur | Module: EducateurStudents --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Mes Élèves</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($classroom)
                <div class="mb-6">
                    <p class="text-slate-500">Classe: <strong class="text-slate-800 dark:text-white">{{ $classroom->nom }}</strong> — {{ $students->count() }} élèves</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($students as $student)
                        <div class="card-premium p-5">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold text-lg shadow">
                                    {{ substr($student->prenom, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 dark:text-white">{{ $student->prenom }} {{ $student->nom }}</p>
                                    <p class="text-xs text-slate-400">Né(e) le {{ $student->date_naissance?->format('d/m/Y') ?? 'N/A' }}</p>
                                </div>
                            </div>
                            @if($student->allergies)
                                <div class="mb-3">
                                    <span class="badge badge-danger flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg> {{ $student->allergies }}</span>
                                </div>
                            @endif
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-slate-500">Parent: {{ $student->parent?->name ?? 'N/A' }}</span>
                                @if($student->parent)
                                    <a href="{{ route('messages.conversation', $student->parent->id) }}" class="text-teal-600 hover:text-teal-700 font-medium text-xs flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg> Contacter
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="card-premium p-8 text-center">
                    <p class="text-slate-500">Aucune classe ne vous est actuellement assignée.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
