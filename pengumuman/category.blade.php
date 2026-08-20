@php
    $siblingCategories = query()->index_category('pengumuman');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <a href="{{ url('pengumuman') }}" class="hover:text-brand-600">Pengumuman</a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900">Kategori: {{ $category->name }}</span>
    </nav>

    <!-- Category Header Banner -->
    <div class="rounded-3xl hero-gradient text-white p-8 sm:p-10 mb-10 shadow-card relative overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:20px_20px]"></div>
        <div class="relative z-10 space-y-2">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-amber-200 backdrop-blur-md">
                <i class="fa-solid fa-bullhorn text-[10px]"></i>
                <span>Kategori Pengumuman</span>
            </div>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                {{ $category->name }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-200 max-w-2xl leading-relaxed">
                {{ $category->description ?? 'Daftar pengumuman dan pemberitahuan resmi pada kategori ' . $category->name . '.' }}
            </p>
        </div>
    </div>

    <!-- Category Filter Tabs -->
    @if($siblingCategories->count() > 0)
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 no-scrollbar">
            <a href="{{ url('pengumuman') }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 transition">
                Semua Kategori
            </a>
            @foreach($siblingCategories as $c)
                <a href="{{ url($c->url) }}" class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap transition-all {{ $c->slug == $category->slug ? 'bg-brand-600 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
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
                    <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-soft hover:shadow-card-hover transition flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-3">
                                <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200/60 flex items-center gap-1">
                                    <i class="fa-solid fa-bullhorn text-[10px]"></i>
                                    <span>{{ $category->name }}</span>
                                </span>
                                <span class="text-xs text-slate-400 font-medium">
                                    <i class="fa-regular fa-calendar mr-1"></i> {{ $row->created }}
                                </span>
                            </div>

                            <h2 class="text-base sm:text-lg font-bold text-slate-900 group-hover:text-brand-600 transition leading-snug">
                                <a href="{{ url($row->url) }}">{{ $row->title }}</a>
                            </h2>

                            <p class="text-xs sm:text-sm text-slate-500 line-clamp-3 leading-relaxed mt-2">
                                {{ Str::limit(strip_tags($row->short_content ?? $row->content ?? ''), 150) }}
                            </p>
                        </div>

                        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="text-[11px] text-slate-400">
                                <i class="fa-regular fa-eye mr-1"></i> {{ $row->visited ?? 0 }}x dibaca
                            </span>
                            <a href="{{ url($row->url) }}" class="text-xs font-bold text-brand-600 hover:text-brand-700 inline-flex items-center gap-1">
                                <span>Lihat Rincian Pengumuman</span>
                                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                            </a>
                        </div>
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
                    <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Belum Ada Pengumuman di Kategori Ini</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                        Belum ada pengumuman resmi yang dipublikasikan pada kategori <strong>{{ $category->name }}</strong>.
                    </p>
                    <a href="{{ url('pengumuman') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white brand-gradient shadow">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Lihat Semua Pengumuman</span>
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
