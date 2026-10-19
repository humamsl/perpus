<footer class="relative isolate overflow-hidden bg-ink-950 text-slate-400 noise">
    <div aria-hidden="true" class="absolute inset-0 -z-10">
        <div class="absolute -top-32 left-1/4 h-64 w-64 rounded-full bg-primary-600/20 blur-3xl"></div>
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-primary-400/50 to-transparent"></div>
    </div>
    <div class="container mx-auto px-4 py-12">
        <div class="flex flex-wrap justify-between items-start gap-8">
            <div class="max-w-sm">
                <div class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-primary-400 to-primary-700 text-white shadow-glow-lg">
                        <i class="fas fa-book-open-reader"></i>
                    </span>
                    <p class="font-display font-bold text-lg text-white">{{ $appProfile->app_name ?? config('app.name') }}</p>
                </div>
                <p class="text-sm mt-4 leading-relaxed">Perpustakaan digital &amp; fisik terintegrasi — membaca jadi lebih mudah, di mana pun Anda berada.</p>
            </div>
            <div class="flex gap-12 text-sm">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-white/90 mb-3">Jelajahi</p>
                    <ul class="space-y-2">
                        <li><a href="{{ route('catalog.index') }}" class="link-anim hover:text-white transition">Katalog</a></li>
                        <li><a href="/#spots" class="link-anim hover:text-white transition">Lokasi</a></li>
                        <li><a href="{{ route('visitors.history') }}" class="link-anim hover:text-white transition">Histori</a></li>
                    </ul>
                </div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-white/90 mb-3">Akun</p>
                    <ul class="space-y-2">
                        @guest
                            <li><a href="{{ route('login') }}" class="link-anim hover:text-white transition">Masuk</a></li>
                            <li><a href="{{ route('register') }}" class="link-anim hover:text-white transition">Daftar</a></li>
                        @else
                            <li><a href="{{ route('dashboard') }}" class="link-anim hover:text-white transition">Dashboard</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="link-anim hover:text-white transition">Profil</a></li>
                        @endguest
                    </ul>
                </div>
            </div>
        </div>
        <div class="mt-10 pt-6 border-t border-white/[.06] flex flex-wrap justify-between gap-2 text-xs">
            <p>&copy; {{ date('Y') }} {{ $appProfile->app_name ?? config('app.name') }}. All rights reserved.</p>
            <p class="flex items-center gap-1.5">Dibuat dengan <i class="fas fa-heart text-rose-500 animate-pulse"></i> untuk literasi Indonesia</p>
        </div>
    </div>
</footer>

@if(session('visitor_log_id'))
<script>
    (function () {
        if (!navigator.geolocation) return;
        navigator.geolocation.getCurrentPosition(function (pos) {
            fetch("{{ route('visitors.location') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    latitude: pos.coords.latitude,
                    longitude: pos.coords.longitude,
                }),
                keepalive: true,
            }).catch(() => {});
        }, function () { /* izin ditolak atau gagal — abaikan, tidak perlu diulang */ }, { timeout: 8000, maximumAge: 300000 });
    })();
</script>
@endif
