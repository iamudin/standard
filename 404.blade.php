<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <div class="max-w-xl mx-auto bg-white rounded-3xl p-8 sm:p-12 text-center border border-slate-200/80 shadow-soft">
        <div class="w-20 h-20 rounded-3xl bg-brand-50 text-brand-600 flex items-center justify-center text-3xl font-extrabold mx-auto mb-6 shadow-sm">
            404
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mb-3 tracking-tight">Halaman Tidak Ditemukan</h1>
        <p class="text-xs sm:text-sm text-slate-500 mb-8 leading-relaxed">
            Mohon maaf, halaman atau tautan informasi yang Anda tuju tidak tersedia, telah dipindahkan, atau telah dinonaktifkan oleh administrator.
        </p>

        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="{{ url('/') }}" class="px-6 py-3 rounded-xl font-bold text-xs text-white brand-gradient shadow transition flex items-center gap-2">
                <i class="fa-solid fa-house"></i>
                <span>Ke Halaman Utama</span>
            </a>
            <button type="button" onclick="history.back()" class="px-6 py-3 rounded-xl font-bold text-xs text-slate-700 bg-slate-100 hover:bg-slate-200 transition">
                Kembali Sebelumnya
            </button>
        </div>
    </div>
</div>
