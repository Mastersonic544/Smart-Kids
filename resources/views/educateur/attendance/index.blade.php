{{-- View: educateur.attendance.index | Role: educateur | Module: EducateurAttendance --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 dark:text-white">Gestion des Présences</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl text-emerald-700 dark:text-emerald-400 font-medium">
                    <svg class="w-5 h-5 inline text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ session('success') }}
                </div>
            @endif

            @if($classroom)
                <div class="card-premium p-6">
                    {{-- Date picker --}}
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="font-bold text-lg text-slate-800 dark:text-white">{{ $classroom->nom }}</h3>
                            <p class="text-sm text-slate-500">{{ $students->count() }} élèves</p>
                        </div>
                        <form method="GET" action="{{ route('educateur.attendance') }}" class="flex items-center gap-2">
                            <input type="date" name="date" value="{{ $date }}"
                                   class="px-4 py-2 bg-slate-100 dark:bg-slate-700 border-0 rounded-xl text-sm focus:ring-2 focus:ring-teal-500"
                                   onchange="this.form.submit()">
                        </form>
                    </div>

                    {{-- Attendance Form --}}
                    <form method="POST" action="{{ route('educateur.attendance.store') }}">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">

                        <div class="space-y-3">
                            @foreach($students as $index => $student)
                                @php
                                    $existing = $existingAttendance[$student->id] ?? null;
                                    $currentStatus = $existing?->statut ?? '';
                                @endphp
                                <div class="flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl">
                                    <input type="hidden" name="attendance[{{ $index }}][child_id]" value="{{ $student->id }}">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center text-white font-bold shadow flex-shrink-0">
                                        {{ substr($student->prenom, 0, 1) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-semibold text-slate-800 dark:text-white">{{ $student->prenom }} {{ $student->nom }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $index }}][statut]" value="present" {{ $currentStatus === 'present' ? 'checked' : '' }} class="hidden peer" required>
                                            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 bg-slate-100 dark:bg-slate-600 text-slate-600 dark:text-slate-300 transition-all flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Présent</span>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $index }}][statut]" value="absent" {{ $currentStatus === 'absent' ? 'checked' : '' }} class="hidden peer">
                                            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-700 bg-slate-100 dark:bg-slate-600 text-slate-600 dark:text-slate-300 transition-all flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg> Absent</span>
                                        </label>
                                        <label class="cursor-pointer">
                                            <input type="radio" name="attendance[{{ $index }}][statut]" value="en_retard" {{ $currentStatus === 'en_retard' ? 'checked' : '' }} class="hidden peer">
                                            <span class="px-3 py-1.5 rounded-lg text-xs font-semibold border-2 border-transparent peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-checked:text-amber-700 bg-slate-100 dark:bg-slate-600 text-slate-600 dark:text-slate-300 transition-all flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Retard</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="btn-primary flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg> Enregistrer les présences
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-premium p-8 text-center">
                    <p class="text-slate-500">Aucune classe assignée. Contactez l'administration.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
