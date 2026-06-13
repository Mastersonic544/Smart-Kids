@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 rounded-lg bg-teal-50 dark:bg-teal-900/30 text-sm font-semibold text-teal-700 dark:text-teal-400 transition-all duration-200'
            : 'inline-flex items-center px-3 py-2 rounded-lg text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-teal-700 dark:hover:text-teal-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-all duration-200';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
