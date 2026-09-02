@php
    $sambutan = function_exists('query') ? query()->detail('sambutan'): null;
    $pengumuman = query()->index_limit('pengumuman', 3);
    $berita = query()->index_limit('berita', 3);
    $galeri = query()->index_limit('galeri', 4);
    $downloads = query()->index_limit('document', 4);
    
    // Ambil banner slider hero jika tersedia
    $heroSlides = get_banner('home-slider', 5);
@endphp

<!-- CSS Custom Slide Transitions -->
<style>
    .hero-bg-slide {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.8s ease-in-out, visibility 0.8s ease-in-out;
        z-index: 0;
    }
    .hero-bg-slide.active {
        opacity: 1;
        visibility: visible;
        z-index: 1;
    }
    .hero-content-slide {
        transition: opacity 0.5s ease, transform 0.5s ease;
    }
    .hero-content-slide.active {
        opacity: 1;
        transform: translateY(0);
        position: relative;
        pointer-events: auto;
        display: block;
    }
    .hero-content-slide:not(.active) {
        opacity: 0;
        transform: translateY(10px);
        position: absolute;
        pointer-events: none;
        display: none;
    }
</style>

<!-- 1. Hero Banner Full View Height Portal Section with Integrated Cards & Auto-Slider -->
<section class="relative hero-gradient text-white overflow-hidden min-h-[calc(100vh-76px)] flex flex-col justify-between py-10 lg:py-14 w-full" id="heroSliderContainer">
    
    <!-- Background Slides if Banner Available -->
    @if(!empty($heroSlides) && count($heroSlides) > 0)
        <div class="absolute inset-0 z-0 overflow-hidden bg-slate-950">
            @foreach($heroSlides as $hIdx => $hSlide)
                @php
                    $hImg = $hSlide->image ?? $hSlide->thumbnail ?? '';
                    if(!empty($hImg)) {
                        $hImg = Str::startsWith($hImg, ['http://', 'https://', '//']) ? $hImg : (Str::startsWith($hImg, '/') ? $hImg : '/' . $hImg);
                    }
                @endphp
                @if(!empty($hImg))
                    <div class="hero-bg-slide {{ $hIdx === 0 ? 'active' : '' }}" data-index="{{ $hIdx }}">
                        <img src="{{ $hImg }}" alt="{{ $hSlide->name ?? 'Hero Slide' }}" class="w-full h-full object-cover">
                    </div>
                @endif
            @endforeach
        </div>
        <!-- Balanced Clear Overlay Gradient (di atas slide z-10, di bawah konten z-20) -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/95 via-slate-950/60 to-slate-950/35 z-10 pointer-events-none"></div>
    @endif

    <!-- Background subtle texture & radial glow -->
    <div class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:24px_24px] z-10"></div>
    <div class="absolute top-0 right-0 -mt-20 -mr-20 w-96 h-96 bg-brand-400/20 rounded-full blur-3xl pointer-events-none z-10"></div>
    <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl pointer-events-none z-10"></div>

    <!-- Center Hero Content (Dinamis / Slide) -->
    <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 z-20 text-center my-auto pt-4 pb-2 w-full">
        <div class="space-y-6">
            
            @if(!empty($heroSlides) && count($heroSlides) > 0)
                <!-- Dynamic Slide Text -->
                <div class="relative min-h-[220px] flex flex-col justify-center">
                    @foreach($heroSlides as $hIdx => $hSlide)
                        @php
                            $hTitle = $hSlide->name ?? $hSlide->title ?? get_option('site_title') ?? 'Layanan Informasi Resmi';
                            $hDesc = $hSlide->description ?? get_option('hero_deskripsi') ?? 'Memberikan pelayanan prima, transparan, dan terpercaya untuk seluruh masyarakat dengan kemudahan akses informasi publik yang cepat dan akurat.';
                            $hLink = !empty($hSlide->link) ? $hSlide->link : (!empty($hSlide->url) ? url($hSlide->url) : null);
                        @endphp
                        <div class="hero-content-slide {{ $hIdx === 0 ? 'active' : '' }}" data-index="{{ $hIdx }}">
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 border border-white/20 backdrop-blur-md text-xs font-semibold text-brand-200 mb-4 shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>{{ get_option('hero_subtitle_tagline') ?? 'Portal Informasi Publik & Pelayanan Terpadu' }}</span>
                            </div>

                            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight mb-4 max-w-4xl mx-auto drop-shadow-md">
                                {{ $hTitle }}
                            </h1>

                            <p class="text-base sm:text-lg text-slate-200 leading-relaxed max-w-2xl mx-auto mb-6">
                                {{ $hDesc }}
                            </p>

                            <div class="pt-2 flex flex-wrap items-center justify-center gap-3.5">
                                @if($hLink)
                                    <a href="{{ $hLink }}" class="px-7 py-3.5 rounded-xl font-bold text-sm text-slate-900 bg-white hover:bg-slate-100 shadow-xl shadow-black/20 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                        <span>Lihat Informasi Lengkap</span>
                                        <i class="fa-solid fa-arrow-right text-brand-600"></i>
                                    </a>
                                @else
                                    <a href="{{ url('/standar-pelayanan-dan-prosedur') }}" class="px-7 py-3.5 rounded-xl font-bold text-sm text-slate-900 bg-white hover:bg-slate-100 shadow-xl shadow-black/20 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                                        <i class="fa-solid fa-clipboard-check text-brand-600"></i>
                                        <span>Standar Layanan</span>
                                    </a>
                                    <a href="{{ url('/download') }}" class="px-7 py-3.5 rounded-xl font-bold text-sm text-white bg-white/15 hover:bg-white/25 border border-white/30 backdrop-blur-md transition-all flex items-center gap-2">
                                        <i class="fa-solid fa-download text-brand-300"></i>
                                        <span>Pusat Unduhan</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Default Static Hero Text -->
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 border border-white/20 backdrop-blur-md text-xs font-semibold text-brand-200 mb-4 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ get_option('hero_subtitle_tagline') ?? 'Portal Informasi Publik & Pelayanan Terpadu' }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight mb-4 max-w-4xl mx-auto drop-shadow-md">
                    {{ get_option('site_title') ?? 'Layanan Informasi Resmi' }}
                </h1>

                <p class="text-base sm:text-lg text-slate-200 leading-relaxed max-w-2xl mx-auto mb-6">
                    {{ get_option('hero_deskripsi') ?? 'Memberikan pelayanan prima, transparan, dan terpercaya untuk seluruh masyarakat dengan kemudahan akses informasi publik yang cepat, akurat, dan terintegrasi.' }}
                </p>

                <div class="pt-2 flex flex-wrap items-center justify-center gap-3.5">
                    <a href="{{ url('/standar-pelayanan-dan-prosedur') }}" class="px-7 py-3.5 rounded-xl font-bold text-sm text-slate-900 bg-white hover:bg-slate-100 shadow-xl shadow-black/20 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fa-solid fa-clipboard-check text-brand-600"></i>
                        <span>Standar Layanan</span>
                    </a>
                    <a href="{{ url('/download') }}" class="px-7 py-3.5 rounded-xl font-bold text-sm text-white bg-white/15 hover:bg-white/25 border border-white/30 backdrop-blur-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-download text-brand-300"></i>
                        <span>Pusat Unduhan</span>
                    </a>
                </div>
            @endif

        </div>
    </div>

    <!-- Hero Slider Dots Navigation if multiple slides -->
    @if(!empty($heroSlides) && count($heroSlides) > 1)
        <div class="relative z-30 flex items-center justify-center gap-2 my-4" id="heroSliderDots">
            @foreach($heroSlides as $hIdx => $hSlide)
                <button type="button" onclick="goToHeroSlide({{ $hIdx }})" class="hero-dot h-2 rounded-full transition-all duration-300 {{ $hIdx === 0 ? 'w-8 bg-brand-400' : 'w-2 bg-white/40 hover:bg-white/70' }}" aria-label="Slide {{ $hIdx + 1 }}"></button>
            @endforeach
        </div>
    @endif

    <!-- Inside Hero Bottom Quick Portal Action Cards (Glassmorphism Modern) -->
    <div class="relative z-20 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-2">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            
            <!-- Card 1 -->
            <a href="{{ url('/visi-dan-misi') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 backdrop-blur-xl rounded-2xl p-4 sm:p-5 text-white transition-all transform hover:-translate-y-1 shadow-2xl flex items-center justify-between group">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-brand-500/25 border border-brand-300/30 text-brand-300 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white group-hover:text-brand-200 transition">Profil & Visi Misi</h3>
                        <span class="text-xs text-slate-300">Profil Lembaga</span>
                    </div>
                </div>
                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-xs text-white/70 group-hover:text-white group-hover:bg-white/20 transition">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </div>
            </a>

            <!-- Card 2 -->
            <a href="{{ url('/standar-pelayanan-dan-prosedur') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 backdrop-blur-xl rounded-2xl p-4 sm:p-5 text-white transition-all transform hover:-translate-y-1 shadow-2xl flex items-center justify-between group">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/25 border border-emerald-300/30 text-emerald-300 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-clipboard-check"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white group-hover:text-emerald-200 transition">Standar Pelayanan</h3>
                        <span class="text-xs text-slate-300">Prosedur & Syarat</span>
                    </div>
                </div>
                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-xs text-white/70 group-hover:text-white group-hover:bg-white/20 transition">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </div>
            </a>

            <!-- Card 3 -->
            <a href="{{ url('/pengumuman') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 backdrop-blur-xl rounded-2xl p-4 sm:p-5 text-white transition-all transform hover:-translate-y-1 shadow-2xl flex items-center justify-between group">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/25 border border-amber-300/30 text-amber-300 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white group-hover:text-amber-200 transition">Pengumuman Resmi</h3>
                        <span class="text-xs text-slate-300">Informasi Terbaru</span>
                    </div>
                </div>
                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-xs text-white/70 group-hover:text-white group-hover:bg-white/20 transition">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </div>
            </a>

            <!-- Card 4 -->
            <a href="{{ url('/download') }}" class="bg-white/10 hover:bg-white/20 border border-white/20 hover:border-white/40 backdrop-blur-xl rounded-2xl p-4 sm:p-5 text-white transition-all transform hover:-translate-y-1 shadow-2xl flex items-center justify-between group">
                <div class="flex items-center gap-3.5">
                    <div class="w-12 h-12 rounded-xl bg-purple-500/25 border border-purple-300/30 text-purple-300 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-download"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-white group-hover:text-purple-200 transition">Pusat Unduhan</h3>
                        <span class="text-xs text-slate-300">Formulir & SOP</span>
                    </div>
                </div>
                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center text-xs text-white/70 group-hover:text-white group-hover:bg-white/20 transition">
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </div>
            </a>

        </div>
    </div>

</section>

<!-- 3. Sambutan Pimpinan Section -->
@if($sambutan)
<section class="w-full py-16 bg-white border-y border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-slate-50 rounded-3xl p-8 lg:p-12 border border-slate-200/80 shadow-soft">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Foto Pimpinan -->
                <div class="lg:col-span-4 flex flex-col items-center text-center">
                    <div class="relative mb-4 inline-block">
                        @if(!empty($sambutan->thumbnail))
                            <img src="{{ $sambutan->thumbnail }}" alt="{{ $sambutan->field?->name ?? $sambutan->field?->nama ?? 'Pimpinan' }}" class="w-auto max-w-[240px] sm:max-w-[280px] max-h-[380px] sm:max-h-[440px] h-auto rounded-3xl object-contain shadow-card border-4 border-white block mx-auto">
                        @else
                            <div class="w-44 h-44 sm:w-52 sm:h-52 rounded-3xl brand-gradient flex items-center justify-center text-white text-5xl shadow-card border-4 border-white">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        @endif
                        <div class="absolute -bottom-2 -right-2 bg-brand-600 text-white w-9 h-9 rounded-2xl flex items-center justify-center text-sm shadow">
                            <i class="fa-solid fa-quote-right"></i>
                        </div>
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">{{ $sambutan->field?->name ?? $sambutan->field?->nama ?? $sambutan->title ?? 'Pimpinan Lembaga' }}</h3>
                    <span class="text-xs font-semibold text-brand-600 mt-0.5">{{ $sambutan->field?->jabatan ?? 'Kepala / Pimpinan' }}</span>
                </div>

                <!-- Isi Sambutan -->
                <div class="lg:col-span-8 space-y-4 text-slate-700">
                    <div class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 uppercase tracking-wider">
                        <i class="fa-solid fa-quote-left"></i>
                        <span>Kata Sambutan</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $sambutan->title ?? 'Mewujudkan Pelayanan Terbaik Bagi Masyarakat' }}
                    </h2>
                    <div class="text-sm text-slate-600 leading-relaxed line-clamp-4">
                        {!! $sambutan->content !!}
                    </div>
                    
                    @if(isset($sambutan->field?->visi_misi))
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 text-xs text-slate-700 font-medium italic border-l-4 border-l-brand-600">
                            "{{ $sambutan->field?->visi_misi ?? '' }}"
                        </div>
                    @endif

                    <div class="pt-2">
                        <a href="{{ url($sambutan->url) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white brand-gradient hover:opacity-95 shadow transition">
                            <span>Baca Sambutan Lengkap</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endif

<!-- 4. Pengumuman Terkini Section -->
@if($pengumuman->count() > 0)
<section class="w-full py-16 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-amber-600 flex items-center gap-1.5 mb-1">
                    <i class="fa-solid fa-bullhorn text-[11px]"></i>
                    <span>Informasi & Agenda</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Pengumuman Resmi</h2>
            </div>
            <a href="{{ url('/pengumuman') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700">
                <span>Lihat Semua Pengumuman</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($pengumuman as $peng)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-soft hover:shadow-card-hover transition-all flex flex-col justify-between group">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60 uppercase">
                                {{ $peng->category->name ?? 'Pengumuman' }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">
                                <i class="fa-regular fa-calendar mr-1"></i> {{ $peng->created }}
                            </span>
                        </div>

                        <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition-colors line-clamp-2 leading-snug">
                            <a href="{{ url($peng->url) }}">{{ $peng->title }}</a>
                        </h3>

                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mt-2.5">
                            {{ Str::limit(strip_tags($peng->short_content ?? $peng->content ?? ''), 120) }}
                        </p>
                    </div>

                    <a href="{{ url($peng->url) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-600 hover:underline pt-4 mt-4 border-t border-slate-100">
                        <span>Selengkapnya</span>
                        <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- 5. Berita & Artikel Terkini Section -->
@if($berita->count() > 0)
<section class="w-full py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600 flex items-center gap-1.5 mb-1">
                    <i class="fa-solid fa-newspaper text-[11px]"></i>
                    <span>Publikasi Terkini</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Berita & Informasi Terbaru</h2>
            </div>
            <a href="{{ url('/berita') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700">
                <span>Lihat Semua Berita</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $b)
                <article class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-soft hover:shadow-card-hover transition-all flex flex-col group">
                    <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                        @if(!empty($b->thumbnail))
                            <img src="{{ $b->thumbnail }}" alt="{{ $b->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                <i class="fa-regular fa-image text-3xl"></i>
                            </div>
                        @endif

                        @if(!empty($b->category))
                            <span class="absolute top-3 left-3 px-3 py-1 rounded-lg text-[10px] font-bold bg-white/90 backdrop-blur-md text-slate-800 shadow-sm">
                                {{ $b->category->name }}
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col flex-grow justify-between space-y-4">
                        <div>
                            <div class="flex items-center gap-3 text-[11px] text-slate-400 font-medium mb-2">
                                <span><i class="fa-regular fa-calendar mr-1"></i> {{ $b->created }}</span>
                                <span>&bull;</span>
                                <span><i class="fa-regular fa-eye mr-1"></i> {{ $b->visited ?? 0 }}x dibaca</span>
                            </div>

                            <h3 class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition-colors line-clamp-2 leading-snug">
                                <a href="{{ url($b->url) }}">{{ $b->title }}</a>
                            </h3>

                            <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mt-2">
                                {{ Str::limit(strip_tags($b->short_content ?? $b->content ?? ''), 110) }}
                            </p>
                        </div>

                        <a href="{{ url($b->url) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 inline-flex items-center gap-1.5 pt-3 border-t border-slate-100">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- 6. Pusat Unduhan & Dokumen Section -->
@if($downloads->count() > 0)
<section class="w-full py-16 bg-slate-50 border-t border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-600 flex items-center gap-1.5 mb-1">
                    <i class="fa-solid fa-file-arrow-down text-[11px]"></i>
                    <span>Pelayanan Berkas</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Dokumen & Pusat Unduhan</h2>
            </div>
            <a href="{{ url('/download') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700">
                <span>Lihat Semua Berkas</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($downloads as $doc)
                <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-soft hover:shadow-card-hover transition-all flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl flex-shrink-0">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-purple-600 uppercase tracking-wider block">
                                {{ $doc->category->name ?? 'Dokumen Publik' }}
                            </span>
                            <h4 class="text-sm font-bold text-slate-900 hover:text-brand-600 transition line-clamp-1">
                                <a href="{{ url($doc->url) }}">{{ $doc->title }}</a>
                            </h4>
                            <span class="text-[11px] text-slate-400 mt-0.5 block">
                                <i class="fa-regular fa-calendar mr-1"></i> {{ $doc->created }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ url($doc->url) }}" class="px-4 py-2 rounded-xl bg-purple-50 hover:bg-purple-600 text-purple-600 hover:text-white font-bold text-xs transition flex items-center gap-1.5 flex-shrink-0">
                        <i class="fa-solid fa-download text-[11px]"></i>
                        <span>Unduh</span>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- 7. Galeri Foto Kegiatan Section -->
@if($galeri->count() > 0)
<section class="w-full py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600 flex items-center gap-1.5 mb-1">
                    <i class="fa-solid fa-camera text-[11px]"></i>
                    <span>Dokumentasi Visual</span>
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Galeri Foto & Aktivitas</h2>
            </div>
            <a href="{{ url('/galeri') }}" class="inline-flex items-center gap-2 text-xs font-bold text-brand-600 hover:text-brand-700">
                <span>Lihat Semua Galeri</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($galeri as $g)
                <a href="{{ url($g->url) }}" class="group relative rounded-3xl overflow-hidden bg-slate-900 aspect-[4/3] shadow-soft hover:shadow-card-hover transition-all">
                    @if(!empty($g->thumbnail))
                        <img src="{{ $g->thumbnail }}" alt="{{ $g->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-500 bg-slate-800">
                            <i class="fa-regular fa-image text-3xl"></i>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent p-5 flex flex-col justify-end">
                        <span class="text-[10px] font-bold text-brand-300 uppercase tracking-wider mb-1">
                            {{ $g->category->name ?? 'Dokumentasi' }}
                        </span>
                        <h4 class="text-xs sm:text-sm font-bold text-white line-clamp-2 leading-snug group-hover:text-brand-200 transition">
                            {{ $g->title }}
                        </h4>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- 8. Lokasi & Kontak Terpadu Section -->
<section class="w-full py-16 bg-slate-50 border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/80 shadow-soft">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Info Kontak -->
                <div class="lg:col-span-5 space-y-5">
                    <span class="text-xs font-bold uppercase tracking-wider text-brand-600 flex items-center gap-1.5">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Pusat Informasi & Pelayanan</span>
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Kunjungi Kantor Kami</h2>
                    <p class="text-xs sm:text-sm text-slate-500 leading-relaxed">
                        Kami siap melayani kebutuhan informasi dan administrasi Anda dengan sepenuh hati. Silakan hubungi kami atau kunjungi kantor pelayanan pada jam kerja.
                    </p>

                    <div class="space-y-3 pt-2">
                        <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-map-pin"></i>
                            </div>
                            <div>
                                <span class="block font-bold text-slate-900 text-xs">Alamat Kantor</span>
                                <span class="text-slate-500 text-xs">{{ get_option('alamat_kantor_instansi') ?? 'Jl. Merdeka No. 45, Kompleks Perkantoran Terpadu, Indonesia' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-amber-600 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div>
                                <span class="block font-bold text-slate-900 text-xs">Jam Layanan</span>
                                <span class="text-slate-500 text-xs">{{ get_option('jam_pelayanan') ?? 'Senin - Jumat: 08.00 - 16.00 WIB' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div>
                                <span class="block font-bold text-slate-900 text-xs">WhatsApp Layanan</span>
                                <span class="text-slate-500 text-xs">{{ get_option('nomor_whatsapp') ?? '0812-3456-7890' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-3 p-3 rounded-2xl bg-slate-50 border border-slate-100">
                            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <span class="block font-bold text-slate-900 text-xs">Email Resmi</span>
                                <span class="text-slate-500 text-xs">{{ get_option('email_resmi') ?? 'kontak@instansi.id' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Google Maps / Lokasi -->
                <div class="lg:col-span-7 rounded-2xl overflow-hidden border border-slate-200 min-h-[300px] relative bg-slate-100">
                    @if(get_option('google_maps_embed_url'))
                        <iframe src="{{ get_option('google_maps_embed_url') }}" width="100%" height="100%" style="border:0; min-height: 320px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div class="w-full h-full min-h-[320px] flex flex-col items-center justify-center text-slate-400 p-6 text-center">
                            <i class="fa-solid fa-map-location-dot text-4xl text-brand-500 mb-3"></i>
                            <span class="font-bold text-slate-700 text-sm">Peta Lokasi Kantor / Instansi</span>
                            <span class="text-xs text-slate-400 mt-1 max-w-sm">{{ get_option('alamat_kantor_instansi') ?? 'Kompleks Pelayanan Publik Terpadu' }}</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>

    </div>
</section>

<!-- Hero Slider JavaScript Controller -->
<script>
    let currentHeroSlideIndex = 0;
    const heroBgSlides = document.querySelectorAll('.hero-bg-slide');
    const heroContentSlides = document.querySelectorAll('.hero-content-slide');
    const heroDots = document.querySelectorAll('.hero-dot');
    let heroSliderInterval = null;

    function showHeroSlide(index) {
        const total = heroBgSlides.length;
        if (total === 0) return;

        currentHeroSlideIndex = (index + total) % total;

        // Transition Background Images (Active Class Toggle)
        heroBgSlides.forEach((slide, idx) => {
            if (idx === currentHeroSlideIndex) {
                slide.classList.add('active');
            } else {
                slide.classList.remove('active');
            }
        });

        // Transition Content Texts (Active Class Toggle)
        heroContentSlides.forEach((content, idx) => {
            if (idx === currentHeroSlideIndex) {
                content.classList.add('active');
            } else {
                content.classList.remove('active');
            }
        });

        // Transition Dots
        heroDots.forEach((dot, idx) => {
            if (idx === currentHeroSlideIndex) {
                dot.classList.add('w-8', 'bg-brand-400');
                dot.classList.remove('w-2', 'bg-white/40');
            } else {
                dot.classList.remove('w-8', 'bg-brand-400');
                dot.classList.add('w-2', 'bg-white/40');
            }
        });
    }

    function nextHeroSlide() {
        showHeroSlide(currentHeroSlideIndex + 1);
    }

    function prevHeroSlide() {
        showHeroSlide(currentHeroSlideIndex - 1);
    }

    function goToHeroSlide(idx) {
        showHeroSlide(idx);
        resetHeroInterval();
    }

    function startHeroSlider() {
        const total = heroBgSlides.length;
        if (total > 1) {
            heroSliderInterval = setInterval(nextHeroSlide, 5000);
        }
    }

    function resetHeroInterval() {
        clearInterval(heroSliderInterval);
        startHeroSlider();
    }

    // Initialize Hero Slider & Hover Pause
    const heroContainer = document.getElementById('heroSliderContainer');
    if (heroContainer) {
        heroContainer.addEventListener('mouseenter', () => clearInterval(heroSliderInterval));
        heroContainer.addEventListener('mouseleave', startHeroSlider);
        startHeroSlider();
    }
</script>
