@php
    $fileDownload = $detail?->field?->lampiran ?? null;
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center flex-wrap gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <a href="{{ url('pengumuman') }}" class="hover:text-brand-600">Pengumuman</a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900 line-clamp-1 max-w-[200px] sm:max-w-md">{{ $detail->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10">
        
        <!-- Main Detail Article (8 cols) -->
        <div class="lg:col-span-8 min-w-0">
            <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-soft space-y-6 overflow-hidden">
                
                <!-- Notice Callout / Badge -->
                <div class="space-y-4 pb-6 border-b border-slate-100">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <span class="px-3 py-1 rounded-lg text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                            <i class="fa-solid fa-bullhorn text-[10px]"></i>
                            <span>{{ $detail->category->name ?? 'Pengumuman Resmi' }}</span>
                        </span>

                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $detail->created ?? date('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye mr-1"></i> {{ $detail->visited ?? 0 }}x dibaca</span>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $detail->title }}
                    </h1>
                </div>

                <!-- Featured Image / Flyer if available -->
                @if(!empty($detail->thumbnail))
                    <div class="rounded-2xl overflow-hidden shadow-sm aspect-[16/9] bg-slate-100">
                        <img src="{{ $detail->thumbnail }}" alt="{{ $detail->title }}" class="w-full h-full object-cover">
                    </div>
                @endif

                <!-- Attachment Box if available -->
                @if($fileDownload)
                    <div class="p-6 rounded-2xl bg-amber-50/80 border border-amber-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center text-xl flex-shrink-0 shadow">
                                <i class="fa-solid fa-paperclip"></i>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-slate-900">Lampiran Dokumen Pengumuman</h3>
                                <p class="text-xs text-slate-600">Berkas surat keputusan / lampiran edaran resmi.</p>
                            </div>
                        </div>
                        <a href="{{ media_exists($fileDownload) ? media($fileDownload)->url() : url($fileDownload) }}" download target="_blank" class="w-full sm:w-auto px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs shadow transition flex items-center justify-center gap-2 flex-shrink-0">
                            <i class="fa-solid fa-download"></i>
                            <span>Unduh Lampiran</span>
                        </a>
                    </div>
                @endif

                <!-- Content Body -->
                <div class="article-body prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                    @if(!empty($detail->content))
                        {!! $detail->content !!}
                    @else
                        <p class="text-slate-500 italic">Tidak ada rincian teks tambahan pada pengumuman ini.</p>
                    @endif
                </div>

                <!-- Share & Actions -->
                <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-500">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($detail->title . ' - ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share Facebook"><i class="fab fa-facebook-f"></i></a>
                        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold flex items-center gap-1 transition">
                            <i class="fa-solid fa-link text-[10px]"></i>
                            <span>Salin</span>
                        </button>
                    </div>

                    <a href="{{ url('pengumuman') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Pengumuman</span>
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
    .article-body h2 { font-size: 1.35rem; font-weight: 800; color: #0f172a; margin-top: 1.5rem; margin-bottom: 0.75rem; }
    .article-body h3 { font-size: 1.15rem; font-weight: 700; color: #1e293b; margin-top: 1.25rem; margin-bottom: 0.5rem; }
    .article-body p { margin-bottom: 1rem; line-height: 1.75; }
    .article-body ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
    .article-body ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
    .article-body li { margin-bottom: 0.35rem; }
    .article-body blockquote { border-left: 4px solid #f59e0b; padding-left: 1rem; font-style: italic; color: #475569; margin: 1.25rem 0; background: #fffbeb; padding-top: 0.5rem; padding-bottom: 0.5rem; border-radius: 0 0.5rem 0.5rem 0; }
    .article-body img { border-radius: 0.75rem; margin: 1.25rem 0; max-width: 100%; height: auto; }
    .article-body table { width: 100%; border-collapse: collapse; margin: 1.25rem 0; }
    .article-body th, .article-body td { border: 1px solid #e2e8f0; padding: 0.75rem; text-align: left; }
    .article-body th { background-color: #f1f5f9; font-weight: 700; }
</style>
