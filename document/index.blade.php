@php
    $categories = query()->index_category($module->name);
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900">{{ $module->title ?? 'Pusat Unduhan' }}</span>
    </nav>

    <!-- Page Header Banner -->
    <div class="rounded-3xl hero-gradient text-white p-8 sm:p-10 mb-10 shadow-card relative overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="relative z-10 space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-brand-200 backdrop-blur-md">
                <i class="fa-solid fa-file-arrow-down text-[10px]"></i>
                <span>Layanan Dokumen & Berkas</span>
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                {{ $module->title ?? 'Pusat Unduhan Dokumen' }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-200 max-w-2xl leading-relaxed">
                {{ $module->description ?? 'Daftar formulir resmi, buku panduan, regulasi, dan standar operasional prosedur yang dapat diunduh secara bebas.' }}
            </p>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    @if($categories->count() > 0)
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 no-scrollbar">
            <a href="{{ url($module->name) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap bg-brand-600 text-white shadow-sm">
                Semua Kategori
            </a>
            @foreach($categories as $c)
                <a href="{{ url($c->url) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 transition">
                    {{ $c->name }} ({{ $c->posts_count }})
                </a>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Listing Content (8 cols) -->
        <div class="lg:col-span-8 space-y-4">
            @if(isset($index) && count($index) > 0)
                @foreach($index as $row)
                    <div class="bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-soft hover:shadow-card-hover transition flex flex-col sm:flex-row sm:items-center justify-between gap-4 group">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl flex-shrink-0 group-hover:scale-105 transition-transform">
                                <i class="fa-solid fa-file-pdf"></i>
                            </div>
                            <div class="space-y-1">
                                @if(!empty($row->category))
                                    <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                        {{ $row->category->name }}
                                    </span>
                                @endif
                                <h2 class="text-sm sm:text-base font-bold text-slate-900 group-hover:text-brand-600 transition leading-snug">
                                    <a href="{{ url($row->url) }}">{{ $row->title }}</a>
                                </h2>
                                <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ Str::limit(strip_tags($row->description ?? $row->short_content ?? $row->content ?? ''), 110) }}
                                </p>
                                <div class="flex items-center gap-3 text-xs text-slate-400 pt-1">
                                    <span><i class="fa-regular fa-calendar mr-1"></i> {{ $row->created }}</span>
                                    <span>&bull;</span>
                                    <span><i class="fa-regular fa-eye mr-1"></i> {{ $row->visited ?? 0 }}x diakses</span>
                                </div>
                            </div>
                        </div>

                        <a href="{{ url($row->url) }}" class="px-5 py-2.5 rounded-xl bg-brand-50 hover:bg-brand-600 text-brand-600 hover:text-white font-bold text-xs transition flex items-center justify-center gap-2 flex-shrink-0 shadow-sm">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh Berkas</span>
                        </a>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if(method_exists($index, 'links'))
                    <div class="pt-6 flex justify-center">
                        {{ $index->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-soft">
                    <div class="w-16 h-16 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-file-arrow-down"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Belum Ada Dokumen</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                        Saat ini belum ada berkas dokumen unduhan yang dipublikasikan.
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
