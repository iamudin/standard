@php
    $categories = function_exists('query') ? query()->index_sort_by_category('berita') : collect();
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900">{{ $module->title ?? 'Berita & Artikel' }}</span>
    </nav>

    <!-- Page Header Banner -->
    <div class="rounded-3xl hero-gradient text-white p-8 sm:p-10 mb-10 shadow-card relative overflow-hidden">
        <div
            class="absolute inset-0 opacity-15 pointer-events-none bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:20px_20px]">
        </div>
        <div class="relative z-10 space-y-2">
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-xs font-bold text-brand-200 backdrop-blur-md">
                <i class="fa-solid fa-newspaper text-[10px]"></i>
                <span>Warta & Informasi</span>
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight">
                {{$title}}
            </h1>

        </div>
    </div>

    <!-- Category Filter Tabs -->
    @if($categories->count() > 0)
        <div class="flex items-center gap-2 overflow-x-auto pb-4 mb-8 no-scrollbar">
            <a href="{{ url('berita') }}"
                class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap bg-brand-600 text-white shadow-sm">
                Semua Kategori
            </a>
            @foreach($categories as $c)
                <a href="{{ url($c->url) }}"
                    class="px-4 py-2 rounded-xl text-xs font-bold whitespace-nowrap bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 transition">
                    {{ $c->name }} ({{ $c->posts_count }})
                </a>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

        <!-- Main Listing Content (8 cols) -->
        <div class="lg:col-span-8 space-y-8">
            @if(isset($index) && count($index) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach($index as $row)
                        <article
                            class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-soft hover:shadow-card-hover transition-all flex flex-col group">
                            @if(!empty($row->thumbnail))
                                <div class="relative overflow-hidden aspect-[16/10] bg-slate-100">
                                    <img src="{{ $row->thumbnail }}" alt="{{ $row->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @if(!empty($row->category))
                                        <span
                                            class="absolute top-3 left-3 px-3 py-1 rounded-lg text-[10px] font-bold bg-white/90 backdrop-blur-md text-slate-800 shadow-sm">
                                            {{ $row->category->name }}
                                        </span>
                                    @endif
                                </div>
                            @endif

                            <div class="p-6 flex flex-col flex-grow justify-between space-y-4">
                                <div>
                                    <div class="flex items-center gap-3 text-[11px] text-slate-400 font-medium mb-2">
                                        <span><i class="fa-regular fa-calendar mr-1"></i> {{ $row->created }}</span>
                                        <span>&bull;</span>
                                        <span><i class="fa-regular fa-eye mr-1"></i> {{ $row->visited ?? 0 }}x</span>
                                    </div>

                                    <h2
                                        class="text-base font-bold text-slate-900 group-hover:text-brand-600 transition-colors line-clamp-2 leading-snug">
                                        <a href="{{ url($row->url) }}">{{ $row->title }}</a>
                                    </h2>

                                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mt-2">
                                        {{ Str::limit(strip_tags($row->short_content ?? $row->content ?? ''), 110) }}
                                    </p>
                                </div>

                                <a href="{{ url($row->url) }}"
                                    class="text-xs font-bold text-brand-600 hover:text-brand-700 inline-flex items-center gap-1.5 pt-3 border-t border-slate-100">
                                    <span>Baca Selengkapnya</span>
                                    <i
                                        class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(method_exists($index, 'links'))
                    <div class="pt-6 flex justify-center">
                        {{ $index->links() }}
                    </div>
                @endif
            @else
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-soft">
                    <div
                        class="w-16 h-16 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-regular fa-newspaper"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Belum Ada Berita</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto mb-6">
                        Saat ini belum ada postingan berita yang dipublikasikan.
                    </p>
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs text-white brand-gradient shadow">
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