<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900">{{ $detail->title ?? 'Sambutan Pimpinan' }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Detail Article (8 cols) -->
        <div class="lg:col-span-8">
            <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-soft space-y-6">
                
                <!-- Title & Section Badge -->
                <div class="space-y-3 pb-6 border-b border-slate-100">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-50 text-xs font-bold text-brand-700">
                        <i class="fa-solid fa-quote-left text-[10px]"></i>
                        <span>Pesan & Arahan Pimpinan</span>
                    </span>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $detail->title }}
                    </h1>
                </div>

                <!-- Leader Profile Card Presentation -->
                <div class="p-6 sm:p-8 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row items-center sm:items-start gap-6">
                    <div class="relative flex-shrink-0">
                        @if(!empty($detail->media))
                            <img src="{{ $detail->thumbnail }}" alt="{{ $detail->field?->name ?? $detail->field?->nama ?? 'Pimpinan' }}" class="w-auto max-w-[200px] sm:max-w-[240px] max-h-[360px] h-auto rounded-2xl object-contain shadow border-4 border-white block">
                        @else
                            <div class="w-36 h-36 sm:w-44 sm:h-44 rounded-2xl brand-gradient text-white flex items-center justify-center text-5xl shadow border-4 border-white">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                        @endif
                        <div class="absolute -bottom-2 -right-2 bg-brand-600 text-white w-8 h-8 rounded-xl flex items-center justify-center text-xs shadow">
                            <i class="fa-solid fa-quote-right"></i>
                        </div>
                    </div>

                    <div class="text-center sm:text-left space-y-2 flex-grow">
                        <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Pemberi Sambutan</span>
                        <h2 class="text-lg sm:text-xl font-bold text-slate-900">
                            {{ $detail->field?->nama?? $detail->title ?? 'Pimpinan Lembaga' }}
                        </h2>
                        <p class="text-xs font-semibold text-slate-500">
                            {{ $detail->field?->jabatan ?? 'Kepala / Pimpinan Lembaga' }}
                        </p>

                        @if(!empty($detail->field?->visi_misi))
                            <div class="p-3.5 rounded-xl bg-white border border-slate-200 text-xs italic text-slate-700 mt-2 border-l-4 border-l-brand-600 leading-relaxed">
                                "{{ $detail->field->visi_misi }}"
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Content Body -->
                <div class="article-body prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4 pt-2">
                    @if(!empty($detail->content))
                        {!! $detail->content !!}
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
                            <span>Salin Link</span>
                        </button>
                    </div>

                    <a href="{{ url('/') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-house text-[10px]"></i>
                        <span>Kembali ke Beranda</span>
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
    .article-body blockquote { border-left: 4px solid #0284c7; padding-left: 1rem; font-style: italic; color: #475569; margin: 1.25rem 0; background: #f8fafc; padding-top: 0.5rem; padding-bottom: 0.5rem; border-radius: 0 0.5rem 0.5rem 0; }
    .article-body img { border-radius: 0.75rem; margin: 1.25rem 0; max-width: 100%; height: auto; }
    .article-body table { width: 100%; border-collapse: collapse; margin: 1.25rem 0; }
    .article-body th, .article-body td { border: 1px solid #e2e8f0; padding: 0.75rem; text-align: left; }
    .article-body th { background-color: #f1f5f9; font-weight: 700; }
</style>
