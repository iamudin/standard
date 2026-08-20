<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900">Hasil Pencarian</span>
    </nav>

    <!-- Search Header Banner -->
    <div class="rounded-3xl hero-gradient text-white p-8 sm:p-10 mb-10 shadow-card">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-brand-200 backdrop-blur-md mb-2">
            <i class="fa-solid fa-magnifying-glass text-[10px]"></i>
            <span>Pencarian Informasi</span>
        </span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">
            Hasil Pencarian: "{{ $keyword ?? request('keyword') }}"
        </h1>
        <p class="text-xs sm:text-sm text-slate-200 mt-1">
            Menampilkan hasil yang relevan dengan kata kunci pencarian Anda.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Search Results List (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            @if(isset($index) && count($index) > 0)
                <div class="space-y-4">
                    @foreach($index as $item)
                        <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-soft hover:shadow-card-hover transition group">
                            <div class="flex items-center gap-3 text-xs text-slate-400 mb-2">
                                <span class="px-2 py-0.5 rounded-md font-bold uppercase text-[10px] bg-brand-50 text-brand-700">
                                    {{ ucfirst($item->type ?? 'Informasi') }}
                                </span>
                                <span>&bull;</span>
                                <span><i class="fa-regular fa-calendar mr-1"></i> {{ $item->created ?? date('d M Y') }}</span>
                            </div>

                            <h2 class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition-colors leading-snug">
                                <a href="{{ url($item->url) }}">{{ $item->title }}</a>
                            </h2>

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mt-2">
                                {{ Str::limit(strip_tags($item->short_content ?? $item->content ?? ''), 140) }}
                            </p>

                            <a href="{{ url($item->url) }}" class="text-xs font-bold text-brand-600 hover:underline inline-flex items-center gap-1 mt-4">
                                <span>Buka Informasi</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(method_exists($index, 'links'))
                    <div class="pt-6 flex justify-center">
                        {{ $index->links() }}
                    </div>
                @endif

            @else
                <!-- No Results Found -->
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-soft">
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Informasi Tidak Ditemukan</h3>
                    <p class="text-xs text-slate-500 max-w-md mx-auto mb-6 leading-relaxed">
                        Tidak ada konten atau dokumen yang cocok dengan kata kunci <strong>"{{ $keyword ?? request('keyword') }}"</strong>. Silakan coba kata kunci lain.
                    </p>
                    <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white brand-gradient shadow">
                        <i class="fa-solid fa-house"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                </div>
            @endif

        </div>

        <!-- Sidebar Widget (4 cols) -->
        <div class="lg:col-span-4">
            {{ get_element('sidebar') }}
        </div>

    </div>

</div>
