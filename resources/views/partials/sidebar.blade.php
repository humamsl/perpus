<aside
    class="app-sidebar fixed inset-y-0 left-0 z-40 flex flex-col overflow-hidden text-slate-300 bg-ink-950 noise"
    :class="{ 'shadow-2xl shadow-black/40': !$store.sidebar.isDesktop }"
    :style="{
        width: $store.sidebar.isDesktop ? ($store.sidebar.open ? '16.5rem' : '4.5rem') : '16.5rem',
        transform: (!$store.sidebar.isDesktop && !$store.sidebar.mobileOpen) ? 'translateX(-100%)' : 'translateX(0)',
    }">
    {{-- Cahaya dekoratif --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0">
        <div class="absolute -top-24 -left-20 h-72 w-72 rounded-full bg-primary-600/30 blur-3xl animate-blob"></div>
        <div class="absolute bottom-0 -right-24 h-64 w-64 rounded-full bg-accent-500/10 blur-3xl animate-blob [animation-delay:-8s]"></div>
        <div class="absolute inset-0 bg-grid-light opacity-40 mask-fade-b"></div>
    </div>

    {{-- Brand --}}
    <div class="relative flex items-center h-[4.25rem] px-4 border-b border-white/[.06]">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-3 min-w-0">
            @if(!empty($appProfile->logo))
                <img src="{{ asset('storage/'.$appProfile->logo) }}" class="h-10 w-10 rounded-xl object-cover shadow-lg shrink-0 ring-1 ring-white/10 transition duration-500 group-hover:rotate-[-8deg] group-hover:scale-105" alt="Logo">
            @else
                <div class="relative h-10 w-10 rounded-xl flex items-center justify-center text-white text-lg shadow-glow-lg shrink-0 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-110"
                     style="background-image:linear-gradient(135deg,{{ $appProfile->primary_color ?? '#a78bfa' }},{{ $appProfile->secondary_color ?? '#6d28d9' }})">
                    <i class="fas fa-book-open-reader"></i>
                </div>
            @endif
            <div x-show="$store.sidebar.open || !$store.sidebar.isDesktop" x-cloak
                 x-transition:enter="transition ease-out duration-300 delay-100" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0"
                 class="leading-tight min-w-0">
                <p class="font-display font-extrabold text-[15px] text-white tracking-tight truncate">{{ $appProfile->app_name ?? config('app.name') }}</p>
                <p class="text-[10px] uppercase tracking-[0.2em] text-primary-300/70">Library Suite</p>
            </div>
        </a>
        <button type="button" class="md:hidden ml-auto icon-btn !h-8 !w-8 !text-slate-400 hover:!bg-white/10" @click="$store.sidebar.mobileOpen = false" aria-label="Tutup menu">
            <i class="fas fa-xmark"></i>
        </button>
    </div>

    <nav class="relative flex-1 overflow-y-auto overflow-x-hidden py-3 text-sm no-scrollbar">
        @php
            $sections = [
                'Utama' => [
                    ['route' => 'dashboard',           'label' => 'Dashboard',     'icon' => 'fas fa-gauge-high'],
                    ['route' => 'catalog.index',       'label' => 'Katalog Publik','icon' => 'fas fa-compass'],
                ],
                'Koleksi' => [
                    ['route' => 'books.index',         'label' => 'Buku Digital',  'icon' => 'fas fa-tablet-screen-button', 'perm' => 'book.view'],
                    ['route' => 'offline-books.index', 'label' => 'Buku Fisik',    'icon' => 'fas fa-book',                 'perm' => 'book.view'],
                ],
                'Sirkulasi' => [
                    ['route' => 'members.index',       'label' => 'Anggota',         'icon' => 'fas fa-users',          'perm' => 'member.view'],
                    ['route' => 'checkouts.index',     'label' => 'Peminjaman Fisik','icon' => 'fas fa-cart-shopping'],
                    ['route' => 'holds.index',         'label' => 'Hold/Antrean',    'icon' => 'fas fa-hourglass-half'],
                    ['route' => 'holds.scan',          'label' => 'Scan QR Antrean', 'icon' => 'fas fa-qrcode',         'perm' => 'checkout.manage'],
                    ['route' => 'fines.index',         'label' => 'Denda',           'icon' => 'fas fa-money-bill-wave', 'perm' => 'fine.view'],
                ],
                'Personal' => [
                    ['route' => 'wishlist.index',      'label' => 'Wishlist Saya',   'icon' => 'fas fa-heart'],
                    ['route' => 'notifications.index', 'label' => 'Notifikasi',      'icon' => 'fas fa-bell'],
                ],
                'Admin' => [
                    ['route' => 'reports.index',         'label' => 'Laporan',            'icon' => 'fas fa-chart-line', 'perm' => 'report.view'],
                    ['route' => 'visitors.index',        'label' => 'Riwayat Pengunjung', 'icon' => 'fas fa-user-clock', 'perm' => 'report.view'],
                    ['route' => 'users.index',           'label' => 'Manajemen User',     'icon' => 'fas fa-user-shield','perm' => 'user.manage'],
                    ['route' => 'sync-datacenter.index', 'label' => 'Sinkronisasi Data',  'icon' => 'fas fa-rotate',     'perm' => 'member.create'],
                    ['route' => 'settings.index',        'label' => 'Pengaturan',         'icon' => 'fas fa-gear',       'perm' => 'setting.manage'],
                    ['route' => 'backups.index',         'label' => 'Backup Database',    'icon' => 'fas fa-database',   'role' => ['super_admin', 'admin']],
                    ['route' => 'data-reset.index',      'label' => 'Reset Data',         'icon' => 'fas fa-eraser',     'role' => 'super_admin'],
                ],
            ];
            $linkIndex = 0;
            // Halaman turunan (mis. books.create) ikut menyorot menu induknya (books.index),
            // kecuali rute saat ini memang punya menu sendiri (mis. holds.scan).
            $exactHit = collect($sections)->flatten(1)->contains(fn ($l) => request()->routeIs($l['route']));
        @endphp
        @foreach($sections as $section => $links)
            <p class="px-5 pt-5 pb-1.5 text-[10px] font-bold uppercase text-slate-500 tracking-[0.2em] flex items-center gap-2"
               x-show="$store.sidebar.open || !$store.sidebar.isDesktop" x-cloak>
                {{ $section }}
                <span class="h-px flex-1 bg-gradient-to-r from-white/10 to-transparent"></span>
            </p>
            <div x-show="$store.sidebar.isDesktop && !$store.sidebar.open" x-cloak class="border-t border-white/[.06] my-2 mx-4"></div>
            @foreach($links as $l)
                @if((empty($l['perm']) || auth()->user()->can($l['perm'])) && (empty($l['role']) || auth()->user()->hasRole($l['role'])))
                    @php
                        $active = request()->routeIs($l['route'])
                            || (! $exactHit && \Illuminate\Support\Str::endsWith($l['route'], '.index')
                                && request()->routeIs(\Illuminate\Support\Str::beforeLast($l['route'], '.').'.*'));
                        $url = \Illuminate\Support\Facades\Route::has($l['route']) ? route($l['route']) : '#';
                        $linkIndex++;
                    @endphp
                    <a href="{{ $url }}"
                       class="nav-link group animate-fade-up {{ $active ? 'is-active' : '' }}"
                       style="animation-delay: {{ min($linkIndex * 30, 600) }}ms"
                       :class="($store.sidebar.isDesktop && !$store.sidebar.open) && 'justify-center !px-0'"
                       title="{{ $l['label'] }}">
                        @if($active)
                            <span class="absolute -left-2.5 top-1/2 -translate-y-1/2 h-7 w-1 rounded-r-full bg-gradient-to-b from-primary-300 to-accent-400 shadow-[0_0_12px_rgba(167,139,250,.9)]"></span>
                        @endif
                        <i class="{{ $l['icon'] }} w-5 text-center shrink-0 {{ $active ? 'text-white' : 'text-primary-300/70 group-hover:text-primary-200' }}"></i>
                        <span x-show="$store.sidebar.open || !$store.sidebar.isDesktop" x-cloak class="truncate">{{ $l['label'] }}</span>
                        @if($active)
                            <span x-show="$store.sidebar.open || !$store.sidebar.isDesktop" x-cloak class="ml-auto h-1.5 w-1.5 rounded-full bg-white/80 animate-pulse"></span>
                        @endif
                    </a>
                @endif
            @endforeach
        @endforeach
    </nav>

    {{-- Footer mini sidebar --}}
    <div class="relative px-4 py-4 border-t border-white/[.06]" x-show="$store.sidebar.open || !$store.sidebar.isDesktop" x-cloak>
        <div class="rounded-2xl p-3.5 bg-gradient-to-br from-primary-600/30 to-primary-900/10 ring-1 ring-white/10 overflow-hidden relative">
            <div class="absolute -right-6 -top-6 h-20 w-20 rounded-full bg-primary-400/20 blur-xl"></div>
            <p class="relative text-xs font-semibold text-white flex items-center gap-2">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 animate-pulse-ring"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                </span>
                GarageLibrary v1.0
            </p>
            <p class="relative text-[11px] text-slate-400 mt-1">&copy; {{ date('Y') }} — All rights reserved</p>
        </div>
    </div>
</aside>
