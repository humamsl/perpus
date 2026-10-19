<header class="sticky top-0 z-20 border-b border-slate-200/60 bg-white/70 backdrop-blur-2xl backdrop-saturate-150 dark:border-white/[.06] dark:bg-ink-950/60">
    <div class="flex items-center justify-between gap-1.5 md:gap-3 h-[4.25rem] px-3 md:px-6">
        {{-- Toggle sidebar --}}
        <button @click="window.innerWidth < 768 ? $store.sidebar.toggleMobile() : $store.sidebar.toggle()"
                class="icon-btn" aria-label="Toggle sidebar">
            <i class="fas fa-bars-staggered transition-transform duration-500 ease-spring"
               :class="($store.sidebar.isDesktop && !$store.sidebar.open) && 'rotate-180'"></i>
        </button>

        {{-- Search bar global — "/" atau Ctrl+K untuk fokus --}}
        <form action="{{ route('catalog.index') }}" method="get" class="flex-1 max-w-xl min-w-0"
              x-data @keydown.window.slash="if (!['INPUT','TEXTAREA','SELECT'].includes(document.activeElement.tagName) && !document.activeElement.isContentEditable) { $event.preventDefault(); $refs.q.focus() }"
              @keydown.window.ctrl.k.prevent="$refs.q.focus()">
            <div class="relative group">
                <i class="fas fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm transition-all duration-300 group-focus-within:text-primary-500 group-focus-within:scale-110"></i>
                <input type="text" name="q" value="{{ request('q') }}" x-ref="q"
                       placeholder="Cari judul buku, ISBN, atau penulis..."
                       class="w-full pl-11 pr-16 py-2.5 text-sm rounded-2xl border-0 ring-1 ring-slate-200/80 bg-slate-100/60 transition-all duration-300
                              placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-primary-400 focus:shadow-glow
                              dark:bg-white/[.04] dark:ring-white/10 dark:text-slate-100 dark:focus:bg-white/[.07]">
                <kbd class="hidden sm:flex absolute right-3 top-1/2 -translate-y-1/2 items-center gap-0.5 rounded-lg bg-white px-2 py-0.5 text-[10px] font-semibold text-slate-400 ring-1 ring-slate-200 transition group-focus-within:opacity-0 dark:bg-white/5 dark:ring-white/10">
                    Ctrl K
                </kbd>
            </div>
        </form>

        {{-- Date (desktop only) --}}
        <div class="hidden xl:flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 px-3.5 py-2 rounded-xl bg-slate-100/60 ring-1 ring-slate-200/60 dark:bg-white/[.04] dark:ring-white/[.06]">
            <i class="fas fa-calendar-day text-primary-500"></i>
            <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d M Y') }}</span>
        </div>

        {{-- Theme toggle --}}
        <button @click="$store.theme.toggle()" class="icon-btn overflow-hidden" aria-label="Toggle theme">
            <i class="fas fa-moon absolute transition-all duration-500 ease-spring"
               :class="$store.theme.dark ? 'translate-y-8 rotate-90 opacity-0' : 'translate-y-0 rotate-0 opacity-100'"></i>
            <i class="fas fa-sun absolute text-amber-400 transition-all duration-500 ease-spring"
               :class="$store.theme.dark ? 'translate-y-0 rotate-0 opacity-100' : '-translate-y-8 -rotate-90 opacity-0'"></i>
        </button>

        {{-- Notifications --}}
        @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
        <a href="{{ route('notifications.index') }}" class="icon-btn group" aria-label="Notifikasi">
            <i class="fas fa-bell group-hover:animate-wiggle"></i>
            @if($unreadCount > 0)
                <span class="absolute top-1.5 right-1.5 flex h-4 min-w-4">
                    <span class="absolute inset-0 rounded-full bg-rose-500 animate-pulse-ring"></span>
                    <span class="relative h-4 min-w-4 px-1 rounded-full bg-gradient-to-br from-rose-500 to-red-600 text-white text-[10px] flex items-center justify-center font-bold ring-2 ring-white dark:ring-ink-950">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                </span>
            @endif
        </a>

        {{-- Setting menu --}}
        @can('setting.manage')
        @php $primarySpot = \App\Models\ReadingSpot::orderBy('id')->first(); @endphp
        {{-- Tampil juga di mobile (icon-only) supaya fitur setting tidak hilang di HP --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 px-2.5 md:px-3 h-10 rounded-xl hover:bg-primary-50 dark:hover:bg-white/5 text-slate-500 dark:text-slate-300 transition text-sm font-medium"
                    :class="open && 'bg-primary-50 text-primary-700 dark:bg-white/5 dark:text-white'">
                <i class="fas fa-gear transition-transform duration-700" :class="open && 'rotate-180'"></i>
                <span class="hidden lg:inline">Setting</span>
                <i class="fas fa-chevron-down text-[10px] text-slate-400 hidden sm:inline transition-transform duration-300" :class="open && 'rotate-180'"></i>
            </button>
            <div x-show="open" x-cloak @click.outside="open = false"
                 x-transition:enter="transition ease-out-expo duration-300" x-transition:enter-start="opacity-0 -translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="dropdown-panel absolute right-0 mt-2 w-64 z-50 origin-top-right">
                <p class="px-4 pt-1 pb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Master Data</p>
                <a href="{{ route('categories.index') }}" class="dropdown-item"><i class="fas fa-tags w-4 text-primary-500"></i> Kategori</a>
                <a href="{{ route('ddc-categories.index') }}" class="dropdown-item"><i class="fas fa-sitemap w-4 text-primary-500"></i> Kategori DDC</a>
                <a href="{{ route('publishers.index') }}" class="dropdown-item"><i class="fas fa-building w-4 text-primary-500"></i> Penerbit</a>
                <a href="{{ route('authors.index') }}" class="dropdown-item"><i class="fas fa-user-pen w-4 text-primary-500"></i> Pengarang</a>
                <div class="border-t border-slate-100 dark:border-white/[.06] my-1.5"></div>
                <p class="px-4 pt-1 pb-2 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Konfigurasi</p>
                <a href="{{ $primarySpot ? route('app-profiles.edit', $primarySpot) : route('reading-spots.index') }}" class="dropdown-item"><i class="fas fa-building-columns w-4 text-primary-500"></i> Profil Instansi</a>
                <a href="{{ route('reading-spots.index') }}" class="dropdown-item"><i class="fas fa-map-location-dot w-4 text-primary-500"></i> Setting Lokasi Baca</a>
                <a href="{{ route('settings.index') }}#banner" class="dropdown-item"><i class="fas fa-images w-4 text-primary-500"></i> Setting Jumlah Banner</a>
                <a href="{{ $primarySpot ? route('checkout-settings.edit', $primarySpot) : route('reading-spots.index') }}" class="dropdown-item"><i class="fas fa-clock w-4 text-primary-500"></i> Setting Durasi Peminjaman</a>
            </div>
        </div>
        @endcan

        {{-- User menu --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2.5 p-1 pr-2 rounded-2xl hover:bg-slate-100 dark:hover:bg-white/5 transition"
                    :class="open && 'bg-slate-100 dark:bg-white/5'">
                <span class="relative">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="h-9 w-9 rounded-xl object-cover ring-2 ring-white dark:ring-ink-900 shadow-soft" alt="Avatar">
                    @else
                        <span class="h-9 w-9 rounded-xl text-white flex items-center justify-center text-sm font-bold shadow-soft ring-2 ring-white dark:ring-ink-900" style="background-image:linear-gradient(135deg,#a78bfa,#6d28d9)">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                    @endif
                    <span class="absolute -bottom-0.5 -right-0.5 h-3 w-3 rounded-full bg-emerald-400 ring-2 ring-white dark:ring-ink-950"></span>
                </span>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 leading-tight max-w-[10rem] truncate">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-500 capitalize">{{ str_replace('_',' ', auth()->user()->getRoleNames()->first() ?? 'user') }}</p>
                </div>
                <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform duration-300" :class="open && 'rotate-180'"></i>
            </button>
            <div x-show="open" x-cloak @click.outside="open = false"
                 x-transition:enter="transition ease-out-expo duration-300" x-transition:enter-start="opacity-0 -translate-y-2 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                 class="dropdown-panel absolute right-0 mt-2 w-64 z-50 origin-top-right overflow-hidden !pt-0">
                <div class="relative px-4 py-4 mb-1.5 overflow-hidden bg-gradient-to-br from-primary-600 to-primary-900 text-white">
                    <div class="absolute -right-8 -top-8 h-24 w-24 rounded-full bg-white/10 blur-xl"></div>
                    <p class="relative text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="relative text-xs text-white/70 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="fas fa-user-gear w-4 text-primary-500"></i> Profil Saya</a>
                @if(auth()->user()->member)
                    <a href="{{ route('members.card', auth()->user()->member) }}" class="dropdown-item"><i class="fas fa-id-card w-4 text-primary-500"></i> Kartu Anggota</a>
                @endif
                <a href="{{ route('wishlist.index') }}" class="dropdown-item"><i class="fas fa-heart w-4 text-primary-500"></i> Wishlist</a>
                <a href="{{ route('home') }}" class="dropdown-item"><i class="fas fa-globe w-4 text-primary-500"></i> Halaman Publik</a>
                <div class="border-t border-slate-100 dark:border-white/[.06] my-1.5"></div>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="dropdown-item w-full text-left !text-rose-600 hover:!bg-rose-50 dark:!text-rose-400 dark:hover:!bg-rose-500/10">
                        <i class="fas fa-right-from-bracket w-4"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
