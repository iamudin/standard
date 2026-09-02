@php
    $fileDownload = $detail?->field?->file ?? null;
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <a href="{{ url('download') }}" class="hover:text-brand-600">Pusat Unduhan</a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900 line-clamp-1 max-w-[200px] sm:max-w-md">{{ $detail->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Detail Content (8 cols) -->
        <div class="lg:col-span-8">
            <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-soft space-y-6">
                
                <!-- Header Metadata -->
                <div class="space-y-3 pb-6 border-b border-slate-100">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        @if(!empty($detail->category))
                            <a href="{{ url($detail->category->url) }}" class="px-3 py-1 rounded-lg text-xs font-bold bg-purple-50 text-purple-700 hover:bg-purple-100 transition">
                                <i class="fa-solid fa-folder-open mr-1 text-[10px]"></i> {{ $detail->category->name }}
                            </a>
                        @else
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                Dokumen Publik
                            </span>
                        @endif

                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $detail->created ?? date('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye mr-1"></i> {{ $detail->visited ?? 0 }}x diakses</span>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $detail->title }}
                    </h1>
                </div>

                <!-- Prominent Download Box -->
                <div class="p-6 sm:p-8 rounded-2xl bg-purple-50/90 border border-purple-200 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-2xl flex-shrink-0 shadow">
                            <i class="fa-solid fa-file-pdf"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-900">{{ $detail->title }}</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Berkas resmi dapat langsung diunduh dan digunakan.</p>
                        </div>
                    </div>

                    @if($fileDownload)
                        <a href="{{ media_exists($fileDownload) ? media($fileDownload)->download() : 'javascript:void(0);' }}" download target="_blank" class="w-full sm:w-auto px-6 py-3.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2 flex-shrink-0 transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-download text-sm"></i>
                            <span>Unduh Berkas Sekarang</span>
                        </a>
                  
                    @endif
                </div>

                <!-- Document Description Body -->
                @if(!empty($detail->content) || !empty($detail->description))
                    <div class="pt-4 space-y-3 text-slate-700 text-sm sm:text-base leading-relaxed">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900">Deskripsi & Petunjuk Dokumen</h3>
                        <div class="prose prose-slate max-w-none text-sm text-slate-600">
                            {!! $detail->content ?? $detail->description !!}
                        </div>
                    </div>
                @endif

                <!-- Share & Actions -->
                <div class="pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-bold text-slate-500">Bagikan:</span>
                        <a href="https://wa.me/?text={{ urlencode($detail->title . ' - ' . url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center text-xs transition" aria-label="Share Facebook"><i class="fab fa-facebook-f"></i></a>
                        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold flex items-center gap-1 transition">
                            <i class="fa-solid fa-link text-[10px]"></i>
                            <span>Salin Link</span>
                        </button>
                    </div>

                    <a href="{{ url('download') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Pusat Unduhan</span>
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
