@php
    $postType = function_exists('get_post_type') ? get_post_type() : (isset($detail) ? $detail->type : 'berita');
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <a href="{{ url($module->name ?? $detail->type ?? 'berita') }}" class="hover:text-brand-600">
            {{ $module->title ?? ucfirst($detail->type ?? 'Informasi') }}
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900 line-clamp-1 max-w-[200px] sm:max-w-md">{{ $detail->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Detail Article (8 cols) -->
        <div class="lg:col-span-8">
            <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-soft">
                
                <!-- Article Header & Category -->
                <div class="space-y-4 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        @if(!empty($detail->category))
                            <a href="{{ url($detail->category->url) }}" class="px-3 py-1 rounded-lg text-xs font-bold bg-brand-50 text-brand-700 hover:bg-brand-100 transition">
                                <i class="fa-solid fa-folder-open mr-1 text-[10px]"></i> {{ $detail->category->name }}
                            </a>
                        @else
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                {{ $module->title ?? 'Informasi' }}
                            </span>
                        @endif

                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $detail->created ?? date('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye mr-1"></i> {{ $detail->visited ?? 0 }}x dibaca</span>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $detail->title }}
                    </h1>

                    <!-- Author Info Bar -->
                    <div class="flex items-center gap-3 py-3 border-y border-slate-100 text-xs text-slate-600">
                        <div class="w-8 h-8 rounded-full brand-gradient text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                            {{ strtoupper(substr($detail->author ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <span class="font-bold text-slate-900 block">{{ $detail->author ?? 'Admin Publikasi' }}</span>
                            <span class="text-[11px] text-slate-400">Tim Redaksi & Pelayanan Informasi</span>
                        </div>
                    </div>
                </div>

                <!-- Featured Image if available -->
                @if(!empty($detail->thumbnail) && $postType != 'sambutan')
                    <div class="mb-8 rounded-2xl overflow-hidden shadow-sm aspect-[16/9] bg-slate-100">
                        <img src="{{ $detail->thumbnail }}" alt="{{ $detail->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Special Case: Sambutan Pimpinan Presentation -->
                @if($postType == 'sambutan')
                    <div class="mb-8 p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                        @if(!empty($detail->thumbnail))
                            <img src="{{ $detail->thumbnail }}" alt="{{ $detail->field?->nama ?? 'Pimpinan' }}" class="w-32 h-32 sm:w-40 sm:h-40 rounded-2xl object-cover shadow border-4 border-white flex-shrink-0">
                        @endif
                        <div class="text-center sm:text-left space-y-2">
                            <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Pemberi Sambutan</span>
                            <h2 class="text-lg sm:text-xl font-bold text-slate-900">{{ $detail->field?->nama ?? 'Pimpinan Lembaga' }}</h2>
                            <p class="text-xs font-semibold text-slate-500">{{ $detail->field?->jabatan ?? 'Kepala / Pimpinan' }}</p>
                            @if($detail->field?->visi_misi)
                                <div class="p-3 rounded-xl bg-white border border-slate-200 text-xs italic text-slate-600 mt-2">
                                    "{{ $detail->field?->visi_misi ?? '' }}"
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Special Case: Download Dokumen Download Box -->
                @if($postType == 'download' || $detail?->field?->file || $detail?->field?->lampiran)
                    @php
                        $fileDownload = $detail?->field?->lampiran ?? null;
                    @endphp
                    <div class="mb-8 p-6 rounded-2xl bg-purple-50/80 border border-purple-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-purple-600 text-white flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-file-arrow-down"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Berkas Dokumen Resmi</h3>
                                <p class="text-xs text-slate-500">Klik tombol di sebelah kanan untuk mengunduh dokumen langsung.</p>
                            </div>
                        </div>
                        @if($fileDownload)
                            <a href="{{ media($fileDownload)->url() }}" download target="_blank" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow transition flex items-center justify-center gap-2 flex-shrink-0">
                                <i class="fa-solid fa-download"></i>
                                <span>Unduh Berkas</span>
                            </a>
                        @else
                            <button type="button" class="w-full sm:w-auto px-6 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow transition flex items-center justify-center gap-2 flex-shrink-0">
                                <i class="fa-solid fa-download"></i>
                                <span>Unduh Lampiran</span>
                            </button>
                        @endif
                    </div>
                @endif

                <!-- Article Content Body -->
                <div class="article-body prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                    @if(!empty($detail->content))
                        {!! $detail->content !!}
                    @else
                        <p class="text-slate-500 italic">Tidak ada rincian deskripsi tambahan untuk informasi ini.</p>
                    @endif
                </div>

                <!-- Special Case: Galeri Multi-Image Display -->
                @if($postType == 'galeri' && !empty($detail->data) && count($detail->data) > 0)
                    <div class="mt-10 pt-8 border-t border-slate-100">
                        <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-images text-brand-600"></i>
                            <span>Koleksi Foto Kegiatan</span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($detail->data_loop as $imgItem)
                                @php
                                    $imgUrl = ($imgItem->gambar ?? '');
                                    $caption = ($imgItem->caption ??  '');
                                @endphp
                                @if(!empty($imgUrl))
                                    <div class="rounded-2xl overflow-hidden border border-slate-100 bg-slate-50 shadow-sm">
                                        <img src="{{ media_exists($imgUrl) ? media($imgUrl)->url() : $imgUrl }}" alt="{{ $caption }}" class="w-full aspect-[4/3] object-cover hover:scale-105 transition duration-300">
                                        @if(!empty($caption))
                                            <div class="p-3 text-xs text-slate-600 font-medium text-center bg-white border-t border-slate-100">
                                                {{ $caption }}
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Share Buttons & Actions -->
                <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-500">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($detail->title . ' - ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($detail->title) }}&url={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share Twitter"><i class="fab fa-x-twitter"></i></a>
                        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold flex items-center gap-1 transition">
                            <i class="fa-solid fa-link text-[10px]"></i>
                            <span>Salin</span>
                        </button>
                    </div>

                    <a href="{{ url($module->name ?? $detail->type ?? 'berita') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Daftar</span>
                    </a>
                </div>

            </article>
        </div>

        <!-- Sidebar Widget (4 cols) -->
        <div class="lg:col-span-4">
            {{ get_element('sidebar') }}
        </div>

    </div>

</div>

<style>
    /* Styling Typography untuk Content WYSIWYG Editor */
    .article-body h2 {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
    }
    .article-body h3 {
        font-size: 1.15rem;
        font-weight: 700;
        color: #1e293b;
        margin-top: 1.25rem;
        margin-bottom: 0.5rem;
    }
    .article-body p {
        margin-bottom: 1rem;
        line-height: 1.75;
    }
    .article-body ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .article-body ol {
        list-style-type: decimal;
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .article-body li {
        margin-bottom: 0.35rem;
    }
    .article-body blockquote {
        border-left: 4px solid #0284c7;
        padding-left: 1rem;
        font-style: italic;
        color: #475569;
        margin: 1.25rem 0;
        background: #f8fafc;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        border-radius: 0 0.5rem 0.5rem 0;
    }
    .article-body img {
        border-radius: 0.75rem;
        margin: 1.25rem 0;
        max-width: 100%;
        height: auto;
    }
    .article-body table {
        width: 100%;
        border-collapse: collapse;
        margin: 1.25rem 0;
    }
    .article-body th, .article-body td {
        border: 1px solid #e2e8f0;
        padding: 0.75rem;
        text-align: left;
    }
    .article-body th {
        background-color: #f1f5f9;
        font-weight: 700;
    }
</style>
