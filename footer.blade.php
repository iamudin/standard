    <!-- Footer Section -->
    <footer class="bg-slate-900 text-slate-300 mt-auto border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 lg:gap-8">
                
                <!-- Col 1: Brand & Profile Summary -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        @if(get_option('site_logo'))
                            <img src="{{ get_option('site_logo') }}" alt="{{ get_option('site_title') ?? 'Logo' }}" class="h-10 w-auto max-w-[180px] object-contain brightness-0 invert">
                        @else
                            <div class="w-10 h-10 rounded-xl brand-gradient flex items-center justify-center text-white text-lg font-bold">
                                <i class="fa-solid fa-shapes"></i>
                            </div>
                        @endif
                        <span class="font-extrabold text-lg text-white tracking-tight">
                            {{ get_option('site_title') ?? 'Standard Universal' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        {{ get_option('site_description') ?? 'Portal resmi informasi publik dan pelayanan terpadu yang berkomitmen menghadirkan keterbukaan informasi, efisiensi birokrasi, dan kemudahan akses bagi seluruh masyarakat.' }}
                    </p>

                    <div class="pt-2 flex items-center gap-3">
                        @if(get_option('link_facebook'))
                            <a href="{{ get_option('link_facebook') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center text-xs transition" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(get_option('link_instagram'))
                            <a href="{{ get_option('link_instagram') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center text-xs transition" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(get_option('link_youtube'))
                            <a href="{{ get_option('link_youtube') }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center text-xs transition" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Col 2 & 3: Dynamic Footer Menus -->
                @php
                    $footerMenu = function_exists('get_menu') ? get_menu('footer') : collect();
                @endphp

                @if($footerMenu && count($footerMenu) > 0)
                    @foreach($footerMenu->take(2) as $fCol)
                        <div class="space-y-4">
                            <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-brand-400"></span>
                                {{ $fCol->name }}
                            </h4>
                            <ul class="space-y-2.5 text-xs text-slate-400">
                                @if(!empty($fCol->sub) && count($fCol->sub) > 0)
                                    @foreach($fCol->sub as $fSub)
                                        <li>
                                            <a href="{{ $fSub->url }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all">
                                                <i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i>
                                                <span>{{ $fSub->name }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <a href="{{ $fCol->url }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all">
                                            <i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i>
                                            <span>{{ $fCol->name }}</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback Footer Col 2 -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-brand-400"></span>
                            Profil Lembaga
                        </h4>
                        <ul class="space-y-2.5 text-xs text-slate-400">
                            <li><a href="{{ url('/tentang-kami') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Tentang Kami</a></li>
                            <li><a href="{{ url('/visi-dan-misi') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Visi & Misi</a></li>
                            <li><a href="{{ url('/struktur-organisasi') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Struktur Organisasi</a></li>
                            <li><a href="{{ url('/tugas-pokok-dan-fungsi') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Tugas Pokok & Fungsi</a></li>
                        </ul>
                    </div>

                    <!-- Fallback Footer Col 3 -->
                    <div class="space-y-4">
                        <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-brand-400"></span>
                            Layanan & Regulasi
                        </h4>
                        <ul class="space-y-2.5 text-xs text-slate-400">
                            <li><a href="{{ url('/standar-pelayanan-dan-prosedur') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Standar Pelayanan</a></li>
                            <li><a href="{{ url('/pengumuman') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Pengumuman Resmi</a></li>
                            <li><a href="{{ url('/download') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Pusat Unduhan Dokumen</a></li>
                            <li><a href="{{ url('/berita') }}" class="hover:text-brand-400 hover:translate-x-1 inline-flex items-center gap-1.5 transition-all"><i class="fa-solid fa-angle-right text-[10px] text-slate-600"></i> Berita & Kegiatan</a></li>
                        </ul>
                    </div>
                @endif

                <!-- Col 4: Official Contact Details -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-brand-400"></span>
                        Kontak Pelayanan
                    </h4>
                    <div class="space-y-3 text-xs text-slate-400">
                        <div class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot text-brand-400 mt-0.5 w-4 flex-shrink-0"></i>
                            <span>{{ get_option('alamat_kantor_instansi') ?? 'Jl. Merdeka No. 45, Kompleks Perkantoran Terpadu, Indonesia' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-brand-400 w-4 flex-shrink-0"></i>
                            <span>{{ get_option('nomor_whatsapp') ?? '0812-3456-7890' }}</span>
                        </div>
                        @if(get_option('email_resmi'))
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-brand-400 w-4 flex-shrink-0"></i>
                            <a href="mailto:{{ get_option('email_resmi') }}" class="hover:text-white transition">{{ get_option('email_resmi') }}</a>
                        </div>
                        @endif
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-clock text-brand-400 w-4 flex-shrink-0"></i>
                            <span>{{ get_option('jam_pelayanan') ?? 'Senin - Jumat (08.00 - 16.00)' }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Bar Copyright -->
            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <div>
                    &copy; {{ date('Y') }} <span class="text-slate-300 font-semibold">{{ get_option('site_title') ?? 'Standard Universal' }}</span>. Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ url('/tentang-kami') }}" class="hover:text-slate-300 transition">Tentang Kami</a>
                    <span>&bull;</span>
                    <a href="{{ url('/standar-pelayanan-dan-prosedur') }}" class="hover:text-slate-300 transition">Standar Layanan</a>
                    <span>&bull;</span>
                    <button type="button" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="hover:text-brand-400 flex items-center gap-1 transition">
                        <span>Ke Atas</span>
                        <i class="fa-solid fa-arrow-up text-[10px]"></i>
                    </button>
                </div>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        function toggleStandardMobileMenu() {
            const drawer = document.getElementById('std-mobile-drawer');
            const icon = document.getElementById('std-menu-icon');
            if (drawer) {
                const isHidden = drawer.classList.contains('hidden');
                if (isHidden) {
                    drawer.classList.remove('hidden');
                    if (icon) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-xmark');
                    }
                } else {
                    drawer.classList.add('hidden');
                    if (icon) {
                        icon.classList.remove('fa-xmark');
                        icon.classList.add('fa-bars');
                    }
                }
            }
        }

        function toggleMobileSubmenu(id) {
            const sub = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id);
            if (sub) {
                const isHidden = sub.classList.contains('hidden');
                if (isHidden) {
                    sub.classList.remove('hidden');
                    if (arrow) arrow.classList.add('rotate-180');
                } else {
                    sub.classList.add('hidden');
                    if (arrow) arrow.classList.remove('rotate-180');
                }
            }
        }

        function openSearchModal() {
            const modal = document.getElementById('std-search-modal');
            if (modal) {
                modal.classList.remove('hidden');
                const input = modal.querySelector('input[name="keyword"]');
                if (input) setTimeout(() => input.focus(), 100);
            }
        }

        function closeSearchModal() {
            const modal = document.getElementById('std-search-modal');
            if (modal) {
                modal.classList.add('hidden');
            }
        }

        // Close search on ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearchModal();
            }
        });
    </script>
</body>
</html>
