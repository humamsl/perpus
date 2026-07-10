<aside
    class="app-sidebar fixed inset-y-0 left-0 z-40 flex flex-col text-slate-300 transition-transform duration-200 shadow-2xl md:shadow-none
           bg-gradient-to-b from-[#15122b] via-[#13112a] to-[#0d0b1d]"
    :class="{
        'is-sidebar-open': $store.sidebar.open,
        '-translate-x-full md:translate-x-0': !$store.sidebar.mobileOpen,
        'translate-x-0': $store.sidebar.mobileOpen,
    }">
    {{-- Brand --}}
    <div class="flex items-center h-16 px-4 border-b border-white/5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            @if(!empty($appProfile->logo))
                <img src="{{ asset('storage/'.$appProfile->logo) }}" class="h-10 w-10 rounded-xl object-cover shadow-lg shrink-0" alt="Logo">
            @else
                <div class="h-10 w-10 rounded-xl flex items-center justify-center text-white text-lg shadow-lg shrink-0"
                     style="background-image:linear-gradient(135deg,{{ $appProfile->primary_color ?? '#8b5cf6' }},{{ $appProfile->secondary_color ?? '#6d28d9' }})">
                    <i class="fas fa-book-open-reader"></i>
                </div>
            @endif
            <div x-show="$store.sidebar.open" x-cloak class="leading-tight">
                <p class="font-display font-extrabold text-base text-white tracking-tight">{{ $appProfile->app_name ?? config('app.name') }}</p>
                <p class="text-[10px] text-slate-400">Library Management</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-3 text-sm">
        @php
            $sections = [
                'Utama' => [
                    ['route' => 'dashboard',           'label' => 'Dashboard',     'icon' => 'fas fa-gauge-high'],
                    ['route' => 'catalog.index',       'label' => 'Katalog Publik','icon' => 'fas fa-compass'],
                ],
                'Koleksi' => [
                    ['route' => 'books.index',         'label' => 'Buku Digital',  'icon' => 'fas fa-tablet-screen-button', 'perm' => 'book.view'],
                    ['route' => 'offline-books.index', 'label' => 'Buku Fisik',    'icon' => 'fas fa-book',                 'perm' => 'book.view'],
                    ['route' => 'ebooks.index',        'label' => 'E-Book Reader', 'icon' => 'fas fa-book-bookmark',        'perm' => 'ebook.view'],
                ],
                'Sirkulasi' => [
                    ['route' => 'members.index',       'label' => 'Anggota',         'icon' => 'fas fa-users',          'perm' => 'member.view'],
                    ['route' => 'borrows.index',       'label' => 'Peminjaman',      'icon' => 'fas fa-handshake',      'perm' => 'borrow.view'],
                    ['route' => 'returns.create',      'label' => 'Pengembalian',    'icon' => 'fas fa-rotate-left',    'perm' => 'borrow.return'],
                    ['route' => 'checkouts.index',     'label' => 'Checkout Fisik',  'icon' => 'fas fa-cart-shopping'],
                    ['route' => 'holds.index',         'label' => 'Hold/Antrean',    'icon' => 'fas fa-hourglass-half'],
                    ['route' => 'reservations.index',  'label' => 'Reservasi',       'icon' => 'fas fa-bookmark'],
                    ['route' => 'holds.scan',           'label' => 'Scan QR Peminjaman', 'icon' => 'fas fa-qrcode', 'perm' => 'borrow.return'],
                    ['route' => 'fines.index',         'label' => 'Denda',           'icon' => 'fas fa-money-bill-wave', 'perm' => 'fine.view'],
                ],
                'Personal' => [
                    ['route' => 'wishlist.index',      'label' => 'Wishlist Saya',   'icon' => 'fas fa-heart'],
                    ['route' => 'notifications.index', 'label' => 'Notifikasi',      'icon' => 'fas fa-bell'],
                ],
                'Admin' => [
                    ['route' => 'reports.index',         'label' => 'Laporan',            'icon' => 'fas fa-chart-line', 'perm' => 'report.view'],
                    ['route' => 'users.index',           'label' => 'Manajemen User',     'icon' => 'fas fa-user-shield','perm' => 'user.manage'],
                    ['route' => 'sync-datacenter.index', 'label' => 'Sinkronisasi Data',  'icon' => 'fas fa-rotate',     'perm' => 'member.create'],
                    ['route' => 'settings.index',        'label' => 'Pengaturan',         'icon' => 'fas fa-gear',       'perm' => 'setting.manage'],
                ],
            ];
        @endphp
        @foreach($sections as $section => $links)
            <p class="px-5 pt-4 pb-1 text-[10px] font-bold uppercase text-slate-500 tracking-[0.15em]" x-show="$store.sidebar.open" x-cloak>
                {{ $section }}
            </p>
            <div x-show="!$store.sidebar.open" x-cloak class="border-t border-white/5 my-2 mx-3"></div>
            @foreach($links as $l)
                @if(empty($l['perm']) || auth()->user()->can($l['perm']))
                    @php
                        $active = request()->routeIs($l['route']);
                        $url = \Illuminate\Support\Facades\Route::has($l['route']) ? route($l['route']) : '#';
                    @endphp
                    <a href="{{ $url }}"
                       class="group relative flex items-center gap-3 px-3 py-2.5 mx-2.5 my-0.5 rounded-xl transition-all
                              {{ $active
                                 ? 'text-white shadow-lg'
                                 : 'text-slate-300 hover:bg-white/5 hover:text-white' }}"
                       @if($active) style="background-image:linear-gradient(135deg,rgba(139,92,246,.95),rgba(109,40,217,.95))" @endif
                       :class="!$store.sidebar.open && 'justify-center'"
                       title="{{ $l['label'] }}">
                        @if($active)<span class="absolute -left-2.5 top-1/2 -translate-y-1/2 h-6 w-1 rounded-full bg-primary-400"></span>@endif
                        <i class="{{ $l['icon'] }} w-5 text-center shrink-0 {{ $active ? 'text-white' : 'text-primary-300/80 group-hover:text-primary-300' }}"></i>
                        <span x-show="$store.sidebar.open" x-cloak class="truncate font-medium">{{ $l['label'] }}</span>
                    </a>
                @endif
            @endforeach
        @endforeach
    </nav>

    {{-- Footer mini sidebar --}}
    <div class="px-5 py-3 border-t border-white/5 text-xs text-slate-500" x-show="$store.sidebar.open" x-cloak>
        <p class="font-semibold text-slate-400">GarageLibrary v1.0</p>
        <p>&copy; {{ date('Y') }} — All rights reserved</p>
    </div>
</aside>
