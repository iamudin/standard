@php
    $sidePengumuman = query()->index_limit('pengumuman', 4);
    $sidePopular = query()->index_popular('berita', 4);
    $sideCategories = query()->index_category('berita');
    $sideDocs = query()->index_limit('download', 4);
    $sideBanners = function_exists('get_banner') ? (get_banner('sidebar-slider', 5) ?: get_banner('sidebar', 5) ?: get_banner('samping', 5)) : null;

    // Fallback jika banner belum diset di admin: ambil konten berita / pengumuman dengan gambar
    $sliderItems = collect();
    if ($sideBanners && count($sideBanners) > 0) {
        $sliderItems = $sideBanners;
    } else {
        $sliderItems = query()->index_pinned(3);
    }
@endphp

<!-- Sticky Sidebar Container -->
<div class="space-y-6 sticky top-24">
    {{ query()->archive('berita') }}
    <!-- 1. Full-Width Auto-Height Banner Slider Widget (No Card Padding, Smooth Height Animation) -->
    @if(!empty($sliderItems) && count($sliderItems) > 0)
        <div class="relative w-full rounded-2xl overflow-hidden shadow-soft border border-slate-200/80 bg-slate-900 group"
            id="sidebarSliderWidget">

            <!-- Slider Track Container with Smooth Height Transition -->
            <div class="relative w-full overflow-hidden transition-[height] duration-500 ease-in-out min-h-[140px]"
                id="sidebarSliderContainer" style="transition: height 0.45s cubic-bezier(0.4, 0, 0.2, 1);">
                @foreach($sliderItems as $idx => $slide)
                    @php
                        $slideImg = $slide->image ?? $slide->thumbnail ?? '';
                        if (!empty($slideImg)) {
                            $slideImg = Str::startsWith($slideImg, ['http://', 'https://', '//']) ? $slideImg : (Str::startsWith($slideImg, '/') ? $slideImg : '/' . $slideImg);
                        } else {
                            $slideImg = 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=800&auto=format&fit=crop&q=80';
                        }
                        $slideUrl = !empty($slide->link) ? $slide->link : (!empty($slide->url) ? url($slide->url) : '#!');
                        $slideTitle = $slide->name ?? $slide->title ?? '';
                        $slideType = $slide->category?->name ?? (isset($slide->type) ? ucfirst($slide->type) : 'Sorotan');
                    @endphp
                    <div class="sidebar-slide absolute inset-0 w-full transition-opacity duration-500 ease-in-out {{ $idx === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none' }}"
                        data-index="{{ $idx }}">
                        <a href="{{ $slideUrl }}" class="block w-full relative group/img">
                            <!-- Image Element -->
                            <img src="{{ $slideImg }}" alt="{{ $slideTitle }}"
                                class="w-full h-auto object-cover block group-hover/img:scale-105 transition-transform duration-500">

                            <!-- Gradient Overlay with Text if slide title exists -->
                            @if(!empty($slideTitle))
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent flex flex-col justify-end p-4 pointer-events-none">
                                    <span
                                        class="self-start px-2 py-0.5 rounded-md text-[10px] font-bold bg-white/90 backdrop-blur-md text-slate-900 shadow mb-1">
                                        {{ $slideType }}
                                    </span>
                                    <h5 class="text-xs font-bold text-white line-clamp-2 leading-snug">
                                        {{ $slideTitle }}
                                    </h5>
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Navigation Buttons INSIDE Image (Kiri & Kanan) -->
            @if(count($sliderItems) > 1)
                <button type="button" onclick="prevSidebarSlide(event)"
                    class="absolute left-2.5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center text-xs backdrop-blur-md border border-white/20 transition opacity-80 hover:opacity-100 shadow-md transform active:scale-95"
                    aria-label="Slide Sebelumnya">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <button type="button" onclick="nextSidebarSlide(event)"
                    class="absolute right-2.5 top-1/2 -translate-y-1/2 z-20 w-8 h-8 rounded-full bg-slate-900/60 hover:bg-slate-900 text-white flex items-center justify-center text-xs backdrop-blur-md border border-white/20 transition opacity-80 hover:opacity-100 shadow-md transform active:scale-95"
                    aria-label="Slide Berikutnya">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>

                <!-- Indicators / Dots Inside Image (Bottom Center) -->
                <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5" id="sidebarSliderDots">
                    @foreach($sliderItems as $idx => $slide)
                        <button type="button" onclick="goToSidebarSlide({{ $idx }})"
                            class="sidebar-dot h-1.5 rounded-full transition-all duration-300 {{ $idx === 0 ? 'w-5 bg-brand-400' : 'w-1.5 bg-white/60 hover:bg-white' }}"
                            aria-label="Slide {{ $idx + 1 }}"></button>
                    @endforeach
                </div>
            @endif

        </div>
    @endif

    <!-- 2. Pengumuman Terbaru Widget -->
    @if($sidePengumuman->count() > 0)
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-soft">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-bullhorn text-amber-500"></i>
                    <span>Pengumuman</span>
                </h4>
                <a href="{{ url('/pengumuman') }}" class="text-[11px] text-brand-600 hover:underline font-bold">Semua</a>
            </div>
            <div class="space-y-3">
                @foreach($sidePengumuman as $peng)
                    <a href="{{ url($peng->url) }}"
                        class="block p-2.5 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-100 transition group">
                        <span class="text-[10px] font-semibold text-slate-400 block mb-0.5">
                            <i class="fa-regular fa-calendar mr-1"></i> {{ $peng->created ?? date('d M Y') }}
                        </span>
                        <h5
                            class="text-xs font-bold text-slate-800 group-hover:text-brand-600 transition-colors line-clamp-2 leading-snug">
                            {{ $peng->title }}
                        </h5>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 3. Berita Populer Widget -->
    @if($sidePopular->count() > 0)
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-soft">
            <h4
                class="text-xs font-extrabold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-fire text-rose-500"></i>
                <span>Berita Populer</span>
            </h4>
            <div class="space-y-3">
                @foreach($sidePopular as $pop)
                    <a href="{{ url($pop->url) }}" class="flex items-center gap-3 group">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0">
                            @if(!empty($pop->thumbnail))
                                <img src="{{ $pop->thumbnail }}" alt="{{ $pop->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300 text-sm">
                                    <i class="fa-regular fa-image"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <span class="text-[10px] text-slate-400 font-medium block">
                                {{ $pop->created ?? date('d M Y') }}
                            </span>
                            <h5
                                class="text-xs font-bold text-slate-800 group-hover:text-brand-600 transition-colors line-clamp-2 leading-snug">
                                {{ $pop->title }}
                            </h5>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 4. Kategori Berita Widget -->
    @if($sideCategories->count() > 0)
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-soft">
            <h4
                class="text-xs font-extrabold text-slate-900 uppercase tracking-wider pb-3 border-b border-slate-100 mb-3 flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-brand-500"></i>
                <span>Kategori Informasi</span>
            </h4>
            <div class="space-y-1.5">
                @foreach($sideCategories as $cat)
                    <a href="{{ url($cat->url) }}"
                        class="flex items-center justify-between p-2 rounded-xl hover:bg-brand-50 text-xs font-semibold text-slate-700 hover:text-brand-600 transition">
                        <span class="flex items-center gap-2">
                            <i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i>
                            <span>{{ $cat->name }}</span>
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] bg-slate-100 text-slate-500 font-bold">
                            {{ $cat->posts_count }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 5. Dokumen Unduhan Cepat Widget -->
    @if($sideDocs->count() > 0)
        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-soft">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-3">
                <h4 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-file-arrow-down text-purple-500"></i>
                    <span>Unduhan Cepat</span>
                </h4>
                <a href="{{ url('/download') }}" class="text-[11px] text-brand-600 hover:underline font-bold">Semua</a>
            </div>
            <div class="space-y-2.5">
                @foreach($sideDocs as $doc)
                    <a href="{{ url($doc->url) }}"
                        class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 hover:bg-purple-50 hover:text-purple-700 transition group border border-slate-100">
                        <div class="flex items-center gap-2.5 pr-2">
                            <i class="fa-solid fa-file-pdf text-purple-500 text-sm"></i>
                            <span
                                class="text-xs font-bold text-slate-800 group-hover:text-purple-700 line-clamp-1">{{ $doc->title }}</span>
                        </div>
                        <i class="fa-solid fa-arrow-down-to-line text-xs text-slate-400 group-hover:text-purple-600"></i>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- 6. Call Center / WhatsApp Help Card -->
    <div class="rounded-2xl p-5 brand-gradient text-white shadow-card space-y-3">
        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg">
            <i class="fa-solid fa-headset"></i>
        </div>
        <h4 class="text-sm font-extrabold text-white">Butuh Bantuan & Informasi?</h4>
        <p class="text-xs text-brand-100 leading-relaxed">
            Hubungi layanan customer service kami melalui WhatsApp untuk respon cepat dan konsultasi langsung.
        </p>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', get_option('nomor_whatsapp') ?? '628123456789') }}"
            target="_blank"
            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs bg-white text-slate-900 hover:bg-slate-100 shadow transition">
            <i class="fab fa-whatsapp text-emerald-600 text-sm"></i>
            <span>Chat WhatsApp</span>
        </a>
    </div>

</div>

<!-- Sidebar Banner Slider JavaScript Controller with Smooth Height Animation -->
<script>
    let currentSidebarSlide = 0;
    const sidebarSlides = document.querySelectorAll('.sidebar-slide');
    const sidebarDots = document.querySelectorAll('.sidebar-dot');
    const sliderContainer = document.getElementById('sidebarSliderContainer');
    let sidebarSlideInterval = null;

    function getSlideNaturalHeight(slideEl) {
        if (!slideEl) return 0;
        const img = slideEl.querySelector('img');
        if (img) {
            const containerWidth = sliderContainer ? sliderContainer.offsetWidth : 300;
            if (img.naturalHeight && img.naturalWidth && img.naturalWidth > 0) {
                return Math.round((img.naturalHeight / img.naturalWidth) * containerWidth);
            }
            if (img.offsetHeight > 0) {
                return img.offsetHeight;
            }
        }
        return slideEl.offsetHeight || 200;
    }

    function syncSidebarContainerHeight(slideIdx) {
        if (!sliderContainer || !sidebarSlides || sidebarSlides.length === 0) return;
        const targetSlide = sidebarSlides[slideIdx];
        const targetH = getSlideNaturalHeight(targetSlide);
        if (targetH > 50) {
            sliderContainer.style.height = targetH + 'px';
        }
    }

    function showSidebarSlide(index) {
        if (!sidebarSlides || sidebarSlides.length === 0) return;
        currentSidebarSlide = (index + sidebarSlides.length) % sidebarSlides.length;

        // Smooth Height Animation for different image heights
        syncSidebarContainerHeight(currentSidebarSlide);

        // Smooth Fade Transitions
        sidebarSlides.forEach((slide, idx) => {
            if (idx === currentSidebarSlide) {
                slide.classList.remove('opacity-0', 'pointer-events-none', 'z-0');
                slide.classList.add('opacity-100', 'z-10');
            } else {
                slide.classList.remove('opacity-100', 'z-10');
                slide.classList.add('opacity-0', 'pointer-events-none', 'z-0');
            }
        });

        sidebarDots.forEach((dot, idx) => {
            if (idx === currentSidebarSlide) {
                dot.classList.add('w-5', 'bg-brand-400');
                dot.classList.remove('w-1.5', 'bg-white/60');
            } else {
                dot.classList.remove('w-5', 'bg-brand-400');
                dot.classList.add('w-1.5', 'bg-white/60');
            }
        });
    }

    function nextSidebarSlide(e) {
        if (e) e.stopPropagation();
        showSidebarSlide(currentSidebarSlide + 1);
        resetSidebarInterval();
    }

    function prevSidebarSlide(e) {
        if (e) e.stopPropagation();
        showSidebarSlide(currentSidebarSlide - 1);
        resetSidebarInterval();
    }

    function goToSidebarSlide(idx) {
        showSidebarSlide(idx);
        resetSidebarInterval();
    }

    function startSidebarSlider() {
        if (sidebarSlides.length > 1) {
            sidebarSlideInterval = setInterval(() => {
                showSidebarSlide(currentSidebarSlide + 1);
            }, 4500);
        }
    }

    function resetSidebarInterval() {
        clearInterval(sidebarSlideInterval);
        startSidebarSlider();
    }

    // Initialize Auto-play, Hover Pause, Touch Swipe & Height Calculation
    const sliderWidgetEl = document.getElementById('sidebarSliderWidget');
    if (sliderWidgetEl) {
        sliderWidgetEl.addEventListener('mouseenter', () => clearInterval(sidebarSlideInterval));
        sliderWidgetEl.addEventListener('mouseleave', startSidebarSlider);

        let touchStartX = 0;
        let touchEndX = 0;
        sliderWidgetEl.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        }, { passive: true });
        sliderWidgetEl.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            if (touchEndX < touchStartX - 40) showSidebarSlide(currentSidebarSlide + 1);
            if (touchEndX > touchStartX + 40) showSidebarSlide(currentSidebarSlide - 1);
            resetSidebarInterval();
        }, { passive: true });

        // Initial height sync on load and resize
        window.addEventListener('resize', () => syncSidebarContainerHeight(currentSidebarSlide));
        sidebarSlides.forEach(slide => {
            const img = slide.querySelector('img');
            if (img) {
                img.addEventListener('load', () => syncSidebarContainerHeight(currentSidebarSlide));
            }
        });

        // Initialize First Slide Height
        setTimeout(() => syncSidebarContainerHeight(0), 100);

        startSidebarSlider();
    }
</script>