@php
    $galleryItems = $detail->data_loop ?? $detail->data ?? [];
    $formattedImages = [];
    foreach($galleryItems as $imgItem) {
        $imgUrl = is_object($imgItem) 
            ? ($imgItem->gambar ?? $imgItem->Gambar ?? $imgItem->file ?? '') 
            : ($imgItem['gambar'] ?? $imgItem['Gambar'] ?? $imgItem['file'] ?? '');
        $caption = is_object($imgItem) 
            ? ($imgItem->caption ?? $imgItem->keterangan ?? '') 
            : ($imgItem['caption'] ?? $imgItem['keterangan'] ?? '');
        if(!empty($imgUrl)) {
            $formattedImages[] = [
                'src' => media_exists($imgUrl) ? media($imgUrl)->url() : url($imgUrl),
                'caption' => $caption ?: ($detail->title ?? 'Dokumentasi'),
            ];
        }
    }
@endphp

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Breadcrumb Navigation -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 mb-6">
        <a href="{{ url('/') }}" class="hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-house text-[10px]"></i>
            <span>Beranda</span>
        </a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <a href="{{ url('galeri') }}" class="hover:text-brand-600">Galeri Foto</a>
        <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
        <span class="text-slate-900 line-clamp-1 max-w-[200px] sm:max-w-md">{{ $detail->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        
        <!-- Main Detail Article (8 cols) -->
        <div class="lg:col-span-8">
            <article class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200/80 shadow-soft space-y-6">
                
                <!-- Article Header & Category -->
                <div class="space-y-4 pb-6 border-b border-slate-100">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        @if(!empty($detail->category))
                            <a href="{{ url($detail->category->url) }}" class="px-3 py-1 rounded-lg text-xs font-bold bg-brand-50 text-brand-700 hover:bg-brand-100 transition">
                                <i class="fa-solid fa-folder-open mr-1 text-[10px]"></i> {{ $detail->category->name }}
                            </a>
                        @else
                            <span class="px-3 py-1 rounded-lg text-xs font-bold bg-slate-100 text-slate-700">
                                Galeri Foto
                            </span>
                        @endif

                        <div class="flex items-center gap-3 text-xs text-slate-400 font-medium">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $detail->created ?? date('d M Y') }}</span>
                            <span>&bull;</span>
                            <span><i class="fa-regular fa-eye mr-1"></i> {{ $detail->visited ?? 0 }}x dilihat</span>
                        </div>
                    </div>

                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
                        {{ $detail->title }}
                    </h1>
                </div>

                <!-- Featured Image Cover if available -->
                @if(!empty($detail->thumbnail))
                    <div class="rounded-2xl overflow-hidden shadow-sm aspect-[16/9] bg-slate-100 relative group cursor-pointer" onclick="openLightbox(0)">
                        <img src="{{ $detail->thumbnail }}" alt="{{ $detail->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="px-4 py-2 rounded-xl bg-white/90 backdrop-blur-md text-slate-900 text-xs font-bold shadow-lg flex items-center gap-2">
                                <i class="fa-solid fa-magnifying-glass-plus"></i>
                                <span>Buka Lightbox Slider</span>
                            </span>
                        </div>
                    </div>
                @endif

                <!-- Article Description -->
                @if(!empty($detail->content))
                    <div class="article-body prose prose-slate max-w-none text-slate-700 text-sm sm:text-base leading-relaxed space-y-4">
                        {!! $detail->content !!}
                    </div>
                @endif

                <!-- Modern Lightbox Gallery Grid -->
                @if(!empty($formattedImages) && count($formattedImages) > 0)
                    <div class="pt-6 border-t border-slate-100 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                                <i class="fa-solid fa-images text-brand-600"></i>
                                <span>Koleksi Foto Dokumentasi ({{ count($formattedImages) }})</span>
                            </h2>
                            <span class="text-xs text-slate-400 font-medium hidden sm:inline">
                                Klik foto untuk membuka slider
                            </span>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4">
                            @foreach($formattedImages as $index => $img)
                                <div onclick="openLightbox({{ $index }})" class="group relative rounded-2xl overflow-hidden bg-slate-900 aspect-[4/3] cursor-pointer shadow-sm hover:shadow-card-hover transition-all transform hover:-translate-y-1">
                                    <img src="{{ $img['src'] }}" alt="{{ $img['caption'] }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    
                                    <!-- Overlay Effect -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-between p-3">
                                        <div class="self-end w-7 h-7 rounded-lg bg-white/30 backdrop-blur-md text-white flex items-center justify-center text-xs shadow">
                                            <i class="fa-solid fa-expand"></i>
                                        </div>
                                        <p class="text-[11px] font-semibold text-white line-clamp-2 leading-tight">
                                            {{ $img['caption'] }}
                                        </p>
                                    </div>
                                </div>
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
                        <button type="button" onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="px-2.5 py-1.5 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 text-xs font-semibold flex items-center gap-1 transition">
                            <i class="fa-solid fa-link text-[10px]"></i>
                            <span>Salin</span>
                        </button>
                    </div>

                    <a href="{{ url('galeri') }}" class="text-xs font-bold text-brand-600 hover:underline flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i>
                        <span>Kembali ke Galeri</span>
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

<!-- ================= MODERN LIGHTBOX MODAL ================= -->
<div id="galleryLightbox" class="fixed inset-0 z-50 hidden bg-slate-950/95 backdrop-blur-xl flex flex-col justify-between transition-all duration-300 select-none">
    
    <!-- Lightbox Top Navigation Bar -->
    <div class="w-full px-4 sm:px-8 py-4 flex items-center justify-between text-white border-b border-white/10">
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full bg-white/10 text-xs font-bold tracking-wider uppercase text-brand-300" id="lightboxCounter">
                1 / 1
            </span>
            <span class="text-xs font-medium text-slate-300 line-clamp-1 max-w-[200px] sm:max-w-md" id="lightboxTitle">
                {{ $detail->title }}
            </span>
        </div>

        <div class="flex items-center gap-2">
            <a id="lightboxDownloadBtn" href="#" download target="_blank" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-sm transition" title="Unduh Foto">
                <i class="fa-solid fa-download"></i>
            </a>
            <button type="button" onclick="closeLightbox()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-red-600 text-white flex items-center justify-center text-base transition" title="Tutup (ESC)">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

    <!-- Lightbox Main Stage (Viewer) -->
    <div class="relative flex-grow flex items-center justify-center px-4 sm:px-16 py-4 overflow-hidden">
        
        <!-- Previous Arrow -->
        <button type="button" onclick="prevLightboxSlide()" class="absolute left-2 sm:left-6 z-10 w-11 h-11 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-lg backdrop-blur-md transition-all shadow-lg transform active:scale-95" aria-label="Foto Sebelumnya">
            <i class="fa-solid fa-chevron-left"></i>
        </button>

        <!-- Image Display Area -->
        <div class="max-w-5xl max-h-[70vh] flex flex-col items-center justify-center">
            <img id="lightboxMainImage" src="" alt="" class="max-w-full max-h-[62vh] object-contain rounded-2xl shadow-2xl transition-all duration-300 transform scale-100">
            <p id="lightboxCaption" class="text-xs sm:text-sm font-medium text-slate-200 text-center mt-3 max-w-2xl px-4 py-1.5 rounded-full bg-black/40 backdrop-blur-md"></p>
        </div>

        <!-- Next Arrow -->
        <button type="button" onclick="nextLightboxSlide()" class="absolute right-2 sm:right-6 z-10 w-11 h-11 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center text-lg backdrop-blur-md transition-all shadow-lg transform active:scale-95" aria-label="Foto Berikutnya">
            <i class="fa-solid fa-chevron-right"></i>
        </button>

    </div>

    <!-- Lightbox Bottom Thumbnail Strip -->
    <div class="w-full px-4 sm:px-8 py-3 bg-black/40 border-t border-white/10 overflow-x-auto no-scrollbar">
        <div class="flex items-center justify-center gap-2 max-w-5xl mx-auto" id="lightboxThumbStrip">
            <!-- Thumbnails injected via JS -->
        </div>
    </div>

</div>

<script>
    const galleryData = @json($formattedImages);
    let currentLightboxIndex = 0;

    function openLightbox(index) {
        if (!galleryData || galleryData.length === 0) return;
        currentLightboxIndex = index;
        const lightbox = document.getElementById('galleryLightbox');
        lightbox.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        renderLightboxThumbs();
        updateLightboxView();
    }

    function closeLightbox() {
        const lightbox = document.getElementById('galleryLightbox');
        lightbox.classList.add('hidden');
        document.body.style.overflow = '';
    }

    function updateLightboxView() {
        if (!galleryData[currentLightboxIndex]) return;
        
        const item = galleryData[currentLightboxIndex];
        const mainImg = document.getElementById('lightboxMainImage');
        const caption = document.getElementById('lightboxCaption');
        const counter = document.getElementById('lightboxCounter');
        const downloadBtn = document.getElementById('lightboxDownloadBtn');
        
        // Smooth image transition
        mainImg.style.opacity = '0.4';
        mainImg.style.transform = 'scale(0.97)';
        
        setTimeout(() => {
            mainImg.src = item.src;
            mainImg.alt = item.caption || '';
            caption.textContent = item.caption || '';
            counter.textContent = `${currentLightboxIndex + 1} / ${galleryData.length}`;
            downloadBtn.href = item.src;
            
            mainImg.style.opacity = '1';
            mainImg.style.transform = 'scale(1)';
        }, 150);

        // Highlight active thumbnail
        document.querySelectorAll('.lb-thumb').forEach((thumb, idx) => {
            if (idx === currentLightboxIndex) {
                thumb.classList.add('ring-2', 'ring-brand-400', 'opacity-100', 'scale-105');
                thumb.classList.remove('opacity-50');
                thumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            } else {
                thumb.classList.remove('ring-2', 'ring-brand-400', 'opacity-100', 'scale-105');
                thumb.classList.add('opacity-50');
            }
        });
    }

    function nextLightboxSlide() {
        currentLightboxIndex = (currentLightboxIndex + 1) % galleryData.length;
        updateLightboxView();
    }

    function prevLightboxSlide() {
        currentLightboxIndex = (currentLightboxIndex - 1 + galleryData.length) % galleryData.length;
        updateLightboxView();
    }

    function renderLightboxThumbs() {
        const container = document.getElementById('lightboxThumbStrip');
        container.innerHTML = '';
        
        galleryData.forEach((item, idx) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = `lb-thumb w-12 h-12 rounded-xl overflow-hidden transition-all flex-shrink-0 cursor-pointer ${idx === currentLightboxIndex ? 'ring-2 ring-brand-400 opacity-100 scale-105' : 'opacity-50 hover:opacity-80'}`;
            btn.onclick = () => {
                currentLightboxIndex = idx;
                updateLightboxView();
            };
            btn.innerHTML = `<img src="${item.src}" alt="${item.caption || ''}" class="w-full h-full object-cover">`;
            container.appendChild(btn);
        });
    }

    // Keyboard Shortcuts
    document.addEventListener('keydown', function (e) {
        const lightbox = document.getElementById('galleryLightbox');
        if (lightbox && !lightbox.classList.contains('hidden')) {
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextLightboxSlide();
            if (e.key === 'ArrowLeft') prevLightboxSlide();
        }
    });

    // Mobile Swipe Support
    let touchStartX = 0;
    let touchEndX = 0;
    const lightboxEl = document.getElementById('galleryLightbox');
    if (lightboxEl) {
        lightboxEl.addEventListener('touchstart', function (e) {
            touchStartX = e.changedTouches[0].screenX;
        }, false);
        lightboxEl.addEventListener('touchend', function (e) {
            touchEndX = e.changedTouches[0].screenX;
            if (touchEndX < touchStartX - 50) nextLightboxSlide();
            if (touchEndX > touchStartX + 50) prevLightboxSlide();
        }, false);
    }
</script>
