{{-- View: welcome | Role: guest | Module: Marketing --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SmartKids — Gestion Intelligente de Jardin d'Enfants</title>

        <!-- Fonts: Outfit for a modern, friendly feel -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
            .gradient-text {
                background: linear-gradient(135deg, #0d9488 0%, #0891b2 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            .hero-pattern {
                background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230d9488' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-900 selection:bg-teal-100 selection:text-teal-900">
        
        <!-- Navigation -->
        <nav x-data="{ open: false }" class="fixed top-0 w-full z-50 transition-all duration-300 glass border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center space-x-2">
                        <div class="w-10 h-10 bg-teal-600 rounded-xl flex items-center justify-center shadow-lg shadow-teal-200">
                            <span class="text-white font-bold text-xl">S</span>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-slate-800">Smart<span class="text-teal-600">Kids</span></span>
                    </div>

                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#features" class="text-slate-600 hover:text-teal-600 font-medium transition-colors">Fonctionnalités</a>
                        <a href="#about" class="text-slate-600 hover:text-teal-600 font-medium transition-colors">À Propos</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-teal-600 text-white rounded-full font-semibold shadow-md hover:bg-teal-700 transition-all transform hover:-translate-y-0.5">
                                    Tableau de bord
                                </a>
                            @else
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('login') }}" class="text-slate-700 font-semibold hover:text-teal-600 transition-colors">Connexion</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-6 py-2.5 bg-slate-900 text-white rounded-full font-semibold shadow-xl hover:bg-slate-800 transition-all transform hover:-translate-y-0.5">
                                            Inscription
                                        </a>
                                    @endif
                                </div>
                            @endauth
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="open = ! open" class="p-2 text-slate-600 focus:outline-none transition-colors">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden md:hidden bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-lg absolute w-full">
                <div class="px-4 pt-2 pb-6 space-y-2">
                    <a href="#features" @click="open = false" class="block px-3 py-3 rounded-xl text-base font-semibold text-slate-700 hover:text-teal-600 hover:bg-teal-50 transition-colors">Fonctionnalités</a>
                    <a href="#about" @click="open = false" class="block px-3 py-3 rounded-xl text-base font-semibold text-slate-700 hover:text-teal-600 hover:bg-teal-50 transition-colors">À Propos</a>
                    @if (Route::has('login'))
                        <div class="pt-4 border-t border-slate-100"></div>
                        @auth
                            <a href="{{ url('/dashboard') }}" class="block px-3 py-3 text-center rounded-xl text-base font-bold text-white bg-teal-600 hover:bg-teal-700 transition-colors">Tableau de bord</a>
                        @else
                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('login') }}" class="block px-3 py-3 text-center rounded-xl text-base font-bold text-slate-700 border border-slate-200 hover:bg-slate-50 transition-colors">Connexion</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="block px-3 py-3 text-center rounded-xl text-base font-bold text-white bg-slate-900 hover:bg-slate-800 transition-colors">Inscription</a>
                                @endif
                            </div>
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-pattern">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8 animate-fade-in-up">
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-semibold bg-teal-50 text-teal-700 border border-teal-100">
                            ✨ Plateforme de Gestion Scolaire Nouvelle Génération
                        </span>
                        <h1 class="text-5xl lg:text-7xl font-bold leading-tight text-slate-900">
                            Offrez le meilleur à <span class="gradient-text">vos enfants</span>.
                        </h1>
                        <p class="text-lg lg:text-xl text-slate-600 leading-relaxed max-w-xl">
                            Simplifiez la gestion de votre jardin d'enfants avec notre solution complète : inscriptions, nutrition, activités et communication en temps réel avec les parents.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="{{ route('register') }}" class="px-8 py-4 bg-teal-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-teal-200 hover:bg-teal-700 transition-all transform hover:-translate-y-1 text-center">
                                Commencer Gratuitement
                            </a>
                            <a href="#features" class="px-8 py-4 bg-white text-slate-900 border border-slate-200 rounded-2xl font-bold text-lg shadow-sm hover:bg-slate-50 transition-all text-center">
                                Découvrir les modules
                            </a>
                        </div>
                        
                        <!-- Stats Mini -->
                        <div class="flex items-center space-x-8 pt-8 opacity-75">
                            <div>
                                <p class="text-2xl font-bold text-slate-900">100%</p>
                                <p class="text-sm text-slate-500 font-medium">Sécurisé</p>
                            </div>
                            <div class="w-px h-10 bg-slate-200"></div>
                            <div>
                                <p class="text-2xl font-bold text-slate-900">Tunisie</p>
                                <p class="text-sm text-slate-500 font-medium">Localisé</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative animate-fade-in">
                        <div class="absolute -inset-4 bg-gradient-to-tr from-teal-400 to-cyan-400 rounded-3xl blur-2xl opacity-20 transform -rotate-3"></div>
                        <div class="relative bg-white p-2 rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden transform hover:scale-[1.02] transition-transform duration-500">
                            <img src="{{ asset('images/brand/hero.png') }}" alt="SmartKids Kindergarten" class="rounded-[2rem] w-full object-cover aspect-[4/3] lg:aspect-auto">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Background Decorative Elements -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-teal-100 rounded-full blur-3xl opacity-30"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/2 w-64 h-64 bg-amber-100 rounded-full blur-3xl opacity-30"></div>
        </header>

        <!-- Feature Portals -->
        <section id="features" class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-20 space-y-4">
                    <h2 class="text-4xl font-bold text-slate-900 tracking-tight">Une interface pour chaque profil</h2>
                    <p class="text-lg text-slate-600 font-medium">SmartKids connecte tous les acteurs de la vie scolaire dans un écosystème fluide et intuitif.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Parent Portal -->
                    <div class="group p-8 bg-slate-50 rounded-[2rem] hover:bg-teal-600 transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                        </div>
                        <div class="mb-6 w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-teal-800 transition-all">
                            <svg class="w-7 h-7 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 group-hover:text-white mb-4 transition-colors">Portail Parent</h3>
                        <p class="text-slate-600 group-hover:text-teal-50 mb-8 leading-relaxed transition-colors tracking-tight">
                            Suivez l'activité de vos enfants, consultez les menus de la cantine et gérez vos factures en un clic.
                        </p>
                        <a href="{{ route('login') }}" class="inline-flex items-center font-bold text-teal-600 group-hover:text-white transition-colors">
                            Accéder à mon espace
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>

                    <!-- Educator Portal -->
                    <div class="group p-8 bg-slate-50 rounded-[2rem] hover:bg-amber-500 transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13.18v4L12 21l7-3.82v-4L12 17l-7-3.82zM12 3L1 9l11 6 9-4.91V17h2V9L12 3z"/></svg>
                        </div>
                        <div class="mb-6 w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-amber-800 transition-all">
                            <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 group-hover:text-white mb-4 transition-colors">Portail Éducateur</h3>
                        <p class="text-slate-600 group-hover:text-amber-50 mb-8 leading-relaxed transition-colors tracking-tight">
                            Gérez les absences, planifiez les activités pédagogiques et communiquez instantanément avec la direction.
                        </p>
                        <a href="{{ route('login') }}" class="inline-flex items-center font-bold text-amber-600 group-hover:text-white transition-colors">
                            Espace Enseignement
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>

                    <!-- Admin Portal -->
                    <div class="group p-8 bg-slate-50 rounded-[2rem] hover:bg-slate-900 transition-all duration-500 transform hover:-translate-y-2 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1-11v6h2v-6h-2zm0-4v2h2V7h-2z"/></svg>
                        </div>
                        <div class="mb-6 w-14 h-14 bg-white rounded-2xl flex items-center justify-center shadow-lg group-hover:shadow-slate-800 transition-all">
                            <svg class="w-7 h-7 text-slate-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-900 group-hover:text-white mb-4 transition-colors">Direction</h3>
                        <p class="text-slate-600 group-hover:text-slate-300 mb-8 leading-relaxed transition-colors tracking-tight">
                            Tableau de bord complet, gestion des inscriptions, facturation et pilotage stratégique de l'établissement.
                        </p>
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center font-bold text-slate-800 group-hover:text-white transition-colors">
                            Ouvrir la Console
                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-24 bg-slate-50 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row items-center gap-16">
                    <div class="lg:w-1/2 space-y-6">
                        <h2 class="text-4xl font-bold text-slate-900 tracking-tight">La technologie au service de l'épanouissement</h2>
                        <p class="text-lg text-slate-600 leading-relaxed tracking-tight">
                            Le projet SmartKids est né d'un constat simple : la gestion d'un jardin d'enfants exige une rigueur administrative mais aussi une proximité humaine. Notre plateforme automatise les tâches ingrates pour vous permettre de vous concentrer sur l'essentiel : <strong>l'éveil de vos élèves.</strong>
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-teal-100 rounded-full flex items-center justify-center text-teal-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Sécurité des données garantie</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-teal-100 rounded-full flex items-center justify-center text-teal-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Interface optimisée pour mobile</span>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0 w-6 h-6 bg-teal-100 rounded-full flex items-center justify-center text-teal-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <span class="text-slate-700 font-medium">Support technique local et réactif</span>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2 relative">
                        <div class="absolute -inset-4 bg-teal-200 rounded-full blur-3xl opacity-20"></div>
                        <img src="https://images.unsplash.com/photo-1503454537195-1dcabb73ffb9?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Kid smiling" class="relative rounded-[2.5rem] shadow-2xl rotate-3 transform">
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-900 py-12 text-slate-400 border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-teal-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-sm">S</span>
                        </div>
                        <span class="text-xl font-bold tracking-tight text-white">SmartKids</span>
                    </div>
                    
                    <div class="flex space-x-8 text-sm font-medium">
                        <a href="#" class="hover:text-white transition-colors">Politique de confidentialité</a>
                        <a href="#" class="hover:text-white transition-colors">Mentions légales</a>
                        <a href="#" class="hover:text-white transition-colors">Contact</a>
                    </div>

                    <div class="text-sm">
                        &copy; {{ date('Y') }} SmartKids Tunisia. Tous droits réservés.
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
