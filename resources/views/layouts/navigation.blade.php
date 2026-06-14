{{-- View: layouts.navigation | Role: authenticated | Module: Core Layout --}}
<nav x-data="{ open: false }" class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-b border-slate-200/50 dark:border-slate-700/50 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left: Logo + Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center mr-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
                        <div class="w-9 h-9 bg-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-200 dark:shadow-teal-900">
                            <span class="text-white font-bold text-lg">S</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-slate-800 dark:text-white hidden sm:block">Smart<span class="text-teal-600">Kids</span></span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:flex sm:items-center sm:space-x-1">
                    {{-- Role: SuperAdmin --}}
                    @role('superadmin')
                        <x-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">Dashboard SaaS</x-nav-link>
                        <x-nav-link :href="route('superadmin.admins.index')" :active="request()->routeIs('superadmin.admins.*')">Kindergartens</x-nav-link>
                    @endrole

                    {{-- Role: Admin --}}
                    @role('admin')
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Tableau de bord
                        </x-nav-link>
                        <x-nav-link :href="route('admin.children.index')" :active="request()->routeIs('admin.children.*')">
                            Enfants
                        </x-nav-link>
                        <x-nav-link :href="route('admin.parents.index')" :active="request()->routeIs('admin.parents.*')">
                            Parents
                        </x-nav-link>
                        <x-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers.*')">
                            Enseignants
                        </x-nav-link>
                        <x-nav-link :href="route('admin.activities.index')" :active="request()->routeIs('admin.activities.*')">
                            Activités
                        </x-nav-link>
                        <x-nav-link :href="route('admin.classrooms.index')" :active="request()->routeIs('admin.classrooms.*')">
                            Classes
                        </x-nav-link>
                        <x-nav-link :href="route('admin.meals.index')" :active="request()->routeIs('admin.meals.*')">
                            Repas
                        </x-nav-link>
                        <x-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">
                            Paiements
                        </x-nav-link>
                        <x-nav-link :href="route('admin.erp.index')" :active="request()->routeIs('admin.erp.*')">
                            ERP
                        </x-nav-link>
                        <x-nav-link :href="route('admin.subscription.show')" :active="request()->routeIs('admin.subscription.*')">
                            Abonnement
                        </x-nav-link>
                    @endrole

                    {{-- Role: Educator --}}
                    @role('educateur')
                        <x-nav-link :href="route('educateur.dashboard')" :active="request()->routeIs('educateur.dashboard')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Tableau de bord
                        </x-nav-link>
                        <x-nav-link :href="route('educateur.students')" :active="request()->routeIs('educateur.students')">
                            Mes Élèves
                        </x-nav-link>
                        <x-nav-link :href="route('educateur.attendance')" :active="request()->routeIs('educateur.attendance*')">
                            Présences
                        </x-nav-link>
                        <x-nav-link :href="route('educateur.activities')" :active="request()->routeIs('educateur.activities*')">
                            Activités
                        </x-nav-link>
                    @endrole

                    {{-- Role: Parent --}}
                    @role('parent')
                        <x-nav-link :href="route('parent.dashboard')" :active="request()->routeIs('parent.dashboard')">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Tableau de bord
                        </x-nav-link>
                        <x-nav-link :href="route('parent.activities')" :active="request()->routeIs('parent.activities')">
                            Activités
                        </x-nav-link>
                        <x-nav-link :href="route('parent.teachers')" :active="request()->routeIs('parent.teachers')">
                            Enseignants
                        </x-nav-link>
                        <x-nav-link :href="route('parent.meals')" :active="request()->routeIs('parent.meals')">
                            Repas
                        </x-nav-link>
                        <x-nav-link :href="route('parent.payments')" :active="request()->routeIs('parent.payments')">
                            Paiements
                        </x-nav-link>
                    @endrole

                    {{-- Shared: Messages --}}
                    <x-nav-link :href="route('messages.inbox')" :active="request()->routeIs('messages.*')">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Messages
                    </x-nav-link>
                </div>
            </div>

            <!-- Right: Notifications & User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:space-x-3">
                <x-notification-bell :notifications="Auth::user()->unreadNotifications" />

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition-all duration-200">
                            <div class="w-8 h-8 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold text-sm shadow">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="hidden lg:inline">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-700">
                            <p class="text-xs text-slate-500 dark:text-slate-400">Connecté en tant que</p>
                            <p class="text-sm font-semibold text-slate-800 dark:text-slate-200">{{ Auth::user()->getRoleNames()->first() }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Déconnexion') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu (Mobile) -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden border-t border-slate-200 dark:border-slate-700">
        <div class="pt-2 pb-3 space-y-1 px-4">
            @role('superadmin')
                <x-responsive-nav-link :href="route('superadmin.dashboard')" :active="request()->routeIs('superadmin.dashboard')">Dashboard SaaS</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('superadmin.admins.index')" :active="request()->routeIs('superadmin.admins.*')">Kindergartens</x-responsive-nav-link>
            @endrole
            @role('admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">Tableau de bord</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.children.index')" :active="request()->routeIs('admin.children.*')">Enfants</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.parents.index')" :active="request()->routeIs('admin.parents.*')">Parents</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.teachers.index')" :active="request()->routeIs('admin.teachers.*')">Enseignants</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.activities.index')" :active="request()->routeIs('admin.activities.*')">Activités</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.classrooms.index')" :active="request()->routeIs('admin.classrooms.*')">Classes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.meals.index')" :active="request()->routeIs('admin.meals.*')">Repas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.payments.index')" :active="request()->routeIs('admin.payments.*')">Paiements</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.erp.index')" :active="request()->routeIs('admin.erp.*')">ERP</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.subscription.show')" :active="request()->routeIs('admin.subscription.*')">Abonnement</x-responsive-nav-link>
            @endrole
            @role('educateur')
                <x-responsive-nav-link :href="route('educateur.dashboard')" :active="request()->routeIs('educateur.dashboard')">Tableau de bord</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('educateur.students')" :active="request()->routeIs('educateur.students')">Mes Élèves</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('educateur.attendance')" :active="request()->routeIs('educateur.attendance*')">Présences</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('educateur.activities')" :active="request()->routeIs('educateur.activities*')">Activités</x-responsive-nav-link>
            @endrole
            @role('parent')
                <x-responsive-nav-link :href="route('parent.dashboard')" :active="request()->routeIs('parent.dashboard')">Tableau de bord</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('parent.activities')" :active="request()->routeIs('parent.activities')">Activités</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('parent.teachers')" :active="request()->routeIs('parent.teachers')">Enseignants</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('parent.meals')" :active="request()->routeIs('parent.meals')">Repas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('parent.payments')" :active="request()->routeIs('parent.payments')">Paiements</x-responsive-nav-link>
            @endrole
            <x-responsive-nav-link :href="route('messages.inbox')" :active="request()->routeIs('messages.*')">Messages</x-responsive-nav-link>
        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-1 border-t border-slate-200 dark:border-slate-600">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-teal-600 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div>
                    <div class="font-semibold text-base text-slate-800 dark:text-slate-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1 px-4">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Profile') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Déconnexion') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
