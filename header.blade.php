<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
     <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <link rel="stylesheet" href="{{ template_asset('assets/css/style.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                            950: '#082f49',
                        },
                        accent: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    boxShadow: {
                        'soft': '0 4px 20px -2px rgba(0, 0, 0, 0.05)',
                        'card': '0 10px 30px -5px rgba(0, 0, 0, 0.07)',
                        'card-hover': '0 20px 40px -5px rgba(14, 165, 233, 0.15)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            overflow-x: hidden;
        }

        /* Glassmorphism & Header Styling */
        .glass-header {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Dropdown Animation */
        .nav-dropdown {
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .nav-item-group:hover .nav-dropdown {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        /* Gradient utilities */
        .brand-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 50%, #075985 100%);
        }
        .hero-gradient {
            background: linear-gradient(135deg, #075985 0%, #0c4a6e 60%, #082f49 100%);
        }
        .text-gradient {
            background: linear-gradient(135deg, #0284c7 0%, #2563eb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex flex-col min-h-screen antialiased selection:bg-brand-500 selection:text-white">

    <!-- Topbar Informasi -->
    <div class="bg-slate-900 text-slate-300 text-xs py-2 px-4 border-b border-slate-800 z-50">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2 text-center sm:text-left">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4">
                <div class="flex items-center gap-1.5">
                    <i class="fa-regular fa-clock text-brand-400"></i>
                    <span>{{ get_option('jam_kerja_organisasi') ?? 'Senin - Jumat: 08.00 - 16.00 WIB' }}</span>
                </div>
                @if(get_option('email'))
                <div class="hidden md:flex items-center gap-1.5">
                    <i class="fa-regular fa-envelope text-brand-400"></i>
                    <a href="mailto:{{ get_option('email') }}" class="hover:text-white transition">{{ get_option('email') }}</a>
                </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                @if(get_option('whatsapp'))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', get_option('whatsapp')) }}" target="_blank" class="flex items-center gap-1.5 text-emerald-400 hover:text-emerald-300 font-medium transition">
                    <i class="fab fa-whatsapp"></i>
                    <span>{{ get_option('whatsapp') }}</span>
                </a>
                @endif

                <!-- Social Links -->
                <div class="flex items-center gap-3 border-l border-slate-700 pl-4">
                    @if(get_option('facebook'))
                        <a href="{{ get_option('facebook') }}" target="_blank" class="hover:text-white transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    @endif
                    @if(get_option('instagram'))
                        <a href="{{ get_option('instagram') }}" target="_blank" class="hover:text-white transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    @endif
                    @if(get_option('youtube'))
                        <a href="{{ get_option('youtube') }}" target="_blank" class="hover:text-white transition" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 glass-header border-b border-slate-200/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <!-- Logo & Brand Title -->
                @php
                    $siteLogo = get_option('logo') ?: get_option('site_logo');
                @endphp
                @if($siteLogo)
                    <a href="{{ url('/') }}" class="flex items-center group flex-shrink-0">
                        <img src="{{ url('logo.webp') }}" alt="{{ get_option('site_title') ?? 'Logo' }}" class="h-14 w-auto ">
                    </a>
                @else
                    <a href="{{ url('/') }}" class="flex items-center gap-3.5 group flex-shrink-0">
                        <div class="w-11 h-11 rounded-xl brand-gradient flex items-center justify-center text-white text-lg font-bold shadow-md shadow-brand-500/20 group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-shapes"></i>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-extrabold text-base sm:text-lg text-slate-900 tracking-tight leading-snug group-hover:text-brand-600 transition-colors">
                                {{ get_option('site_title') ?? 'Standard Universal' }}
                            </span>
                            <span class="text-[11px] text-slate-500 font-medium line-clamp-1 max-w-[240px]">
                                {{ get_option('site_tagline') ?? get_option('hero_subtitle_tagline') ?? 'Portal Informasi & Pelayanan Terpadu' }}
                            </span>
                        </div>
                    </a>
                @endif

                <!-- Desktop Navigation Menu -->
                @php
                    $headerMenu = function_exists('get_menu') ? get_menu('header') : collect();
                @endphp

                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 font-semibold text-sm text-slate-700">
                    @if($headerMenu && count($headerMenu) > 0)
                        @foreach($headerMenu as $menu)
                            @php
                                $hasChildren = !empty($menu->sub) && count($menu->sub) > 0;
                            @endphp

                            @if($hasChildren)
                                <div class="relative nav-item-group py-6">
                                    <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg hover:text-brand-600 hover:bg-slate-100/80 transition-colors">
                                        @if(!empty($menu->icon)) <i class="{{ $menu->icon }} text-xs opacity-70"></i> @endif
                                        <span>{{ $menu->name }}</span>
                                        <i class="fa-solid fa-chevron-down text-[10px] opacity-60 transition-transform group-hover:rotate-180"></i>
                                    </button>
                                    
                                    <!-- Dropdown Submenu -->
                                    <div class="nav-dropdown absolute top-full left-0 w-60 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50">
                                        @foreach($menu->sub as $subItem)
                                            <a href="{{ $subItem->url }}" class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50/80 text-xs font-semibold transition-all">
                                                @if(!empty($subItem->icon))
                                                    <i class="{{ $subItem->icon }} text-brand-500 text-xs w-4 text-center"></i>
                                                @else
                                                    <i class="fa-solid fa-circle-dot text-[8px] text-brand-400 w-4 text-center"></i>
                                                @endif
                                                <span>{{ $subItem->name }}</span>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <a href="{{ $menu->url }}" class="px-3 py-2 rounded-lg hover:text-brand-600 hover:bg-slate-100/80 transition-colors {{ request()->url() == $menu->url ? 'text-brand-600 font-bold bg-brand-50/70' : '' }}">
                                    @if(!empty($menu->icon)) <i class="{{ $menu->icon }} text-xs opacity-70 mr-1"></i> @endif
                                    {{ $menu->name }}
                                </a>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback Menu Default -->
                        <a href="{{ url('/') }}" class="px-3 py-2 rounded-lg hover:text-brand-600 {{ request()->is('/') ? 'text-brand-600 font-bold' : '' }}">Beranda</a>
                        
                        <div class="relative nav-item-group py-6">
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg hover:text-brand-600 transition-colors">
                                <span>Profil</span>
                                <i class="fa-solid fa-chevron-down text-[10px] opacity-60"></i>
                            </button>
                            <div class="nav-dropdown absolute top-full left-0 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50">
                                <a href="{{ url('/tentang-kami') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Tentang Kami</a>
                                <a href="{{ url('/visi-dan-misi') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Visi & Misi</a>
                                <a href="{{ url('/struktur-organisasi') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Struktur Organisasi</a>
                                <a href="{{ url('/tugas-pokok-dan-fungsi') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Tugas & Fungsi</a>
                            </div>
                        </div>

                        <div class="relative nav-item-group py-6">
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg hover:text-brand-600 transition-colors">
                                <span>Layanan & Info</span>
                                <i class="fa-solid fa-chevron-down text-[10px] opacity-60"></i>
                            </button>
                            <div class="nav-dropdown absolute top-full left-0 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50">
                                <a href="{{ url('/standar-pelayanan-dan-prosedur') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Standar Pelayanan</a>
                                <a href="{{ url('/pengumuman') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Pengumuman</a>
                                <a href="{{ url('/download') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Pusat Unduhan</a>
                            </div>
                        </div>

                        <div class="relative nav-item-group py-6">
                            <button type="button" class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg hover:text-brand-600 transition-colors">
                                <span>Publikasi</span>
                                <i class="fa-solid fa-chevron-down text-[10px] opacity-60"></i>
                            </button>
                            <div class="nav-dropdown absolute top-full left-0 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 p-2 z-50">
                                <a href="{{ url('/berita') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Berita & Artikel</a>
                                <a href="{{ url('/galeri') }}" class="flex items-center gap-2 px-3.5 py-2.5 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 text-xs font-semibold">Galeri Foto</a>
                            </div>
                        </div>

                        <a href="{{ url('/#kontak') }}" class="px-3 py-2 rounded-lg hover:text-brand-600">Kontak</a>
                    @endif
                </nav>

                <!-- Action Button & Search Trigger -->
                <div class="hidden lg:flex items-center gap-3">
                    <button type="button" onclick="openSearchModal()" class="w-10 h-10 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 hover:text-brand-600 flex items-center justify-center transition" aria-label="Cari Informasi">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>

                    <!-- <a href="{{ url('/#kontak') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-bold text-sm text-white brand-gradient hover:opacity-95 shadow-md shadow-brand-500/20 transition-all transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-paper-plane mr-2 text-xs"></i> Hubungi Kami
                    </a> -->
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="flex lg:hidden items-center gap-2">
                    <button type="button" onclick="openSearchModal()" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center" aria-label="Search">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </button>
                    <button id="std-mobile-btn" type="button" onclick="toggleStandardMobileMenu()" class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center focus:outline-none" aria-label="Toggle Menu">
                        <i id="std-menu-icon" class="fa-solid fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="std-mobile-drawer" class="hidden lg:hidden border-t border-slate-200 bg-white/98 backdrop-blur-xl px-4 pt-4 pb-6 shadow-2xl transition-all max-h-[85vh] overflow-y-auto">
            <div class="flex flex-col space-y-1 text-slate-800 font-semibold text-sm">
                @if($headerMenu && count($headerMenu) > 0)
                    @foreach($headerMenu as $mIndex => $menu)
                        @php
                            $hasChildren = !empty($menu->sub) && count($menu->sub) > 0;
                        @endphp

                        @if($hasChildren)
                            <div class="py-1">
                                <button type="button" onclick="toggleMobileSubmenu('mob-sub-{{ $mIndex }}')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-slate-100 text-left">
                                    <span class="flex items-center gap-2">
                                        @if(!empty($menu->icon)) <i class="{{ $menu->icon }} text-brand-500 text-xs w-4"></i> @endif
                                        <span>{{ $menu->name }}</span>
                                    </span>
                                    <i id="arrow-mob-sub-{{ $mIndex }}" class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform"></i>
                                </button>
                                <div id="mob-sub-{{ $mIndex }}" class="hidden pl-6 pr-2 py-1 space-y-1 bg-slate-50 rounded-xl mt-1">
                                    @foreach($menu->sub as $subItem)
                                        <a href="{{ $subItem->url }}" class="block px-3 py-2 rounded-lg text-xs text-slate-600 hover:text-brand-600 hover:bg-white font-medium">
                                            @if(!empty($subItem->icon)) <i class="{{ $subItem->icon }} mr-1.5 text-brand-400"></i> @endif
                                            {{ $subItem->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <a href="{{ $menu->url }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100 hover:text-brand-600 flex items-center gap-2">
                                @if(!empty($menu->icon)) <i class="{{ $menu->icon }} text-brand-500 text-xs w-4"></i> @endif
                                <span>{{ $menu->name }}</span>
                            </a>
                        @endif
                    @endforeach
                @else
                    <a href="{{ url('/') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Beranda</a>
                    <a href="{{ url('/tentang-kami') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Tentang Kami</a>
                    <a href="{{ url('/visi-dan-misi') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Visi & Misi</a>
                    <a href="{{ url('/pengumuman') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Pengumuman</a>
                    <a href="{{ url('/download') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Pusat Unduhan</a>
                    <a href="{{ url('/berita') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Berita Terkini</a>
                    <a href="{{ url('/galeri') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Galeri Foto</a>
                    <a href="{{ url('/#kontak') }}" class="px-3 py-2.5 rounded-xl hover:bg-slate-100">Kontak</a>
                @endif

                <!-- <div class="pt-4 mt-2 border-t border-slate-100 flex flex-col gap-2">
                    <a href="{{ url('/#kontak') }}" class="w-full text-center px-4 py-3 rounded-xl font-bold text-white brand-gradient shadow-md">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Hubungi Kami
                    </a>
                </div> -->
            </div>
        </div>
    </header>

    <!-- Global Search Modal Popup -->
    <div id="std-search-modal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-start justify-center pt-20 px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-xl p-6 border border-slate-100 animate-in fade-in zoom-in duration-200">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-2 text-slate-800 font-bold text-base">
                    <i class="fa-solid fa-magnifying-glass text-brand-500"></i>
                    <span>Pencarian Informasi</span>
                </div>
                <button type="button" onclick="closeSearchModal()" class="text-slate-400 hover:text-slate-600 text-lg">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <form action="{{ url('/search') }}" method="POST">
                @csrf
                <div class="relative">
                    <input type="text" name="keyword" placeholder="Ketik kata kunci pencarian (berita, dokumen, dll)..." required class="w-full px-4 py-3.5 pl-11 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white text-sm font-medium">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-4 text-slate-400 text-sm"></i>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button type="button" onclick="closeSearchModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 hover:bg-slate-100">Batal</button>
                    <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white brand-gradient hover:opacity-95 shadow">Cari Sekarang</button>
                </div>
            </form>
        </div>
    </div>
