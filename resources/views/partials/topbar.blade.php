<header class="sticky top-0 z-20 bg-white/80 dark:bg-slate-900/70 backdrop-blur-xl border-b border-slate-200/70 dark:border-slate-700/60">
    <div class="flex items-center justify-between gap-3 h-16 px-4 md:px-6">
        {{-- Toggle sidebar --}}
        <button @click="window.innerWidth < 768 ? $store.sidebar.toggleMobile() : $store.sidebar.toggle()"
                class="p-2.5 rounded-xl hover:bg-primary-50 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-300 transition"
                aria-label="Toggle sidebar">
            <i class="fas fa-bars-staggered"></i>
        </button>

        {{-- Search bar global --}}
        <form action="{{ route('catalog.index') }}" method="get" class="flex-1 max-w-xl">
            <div class="relative group">
                <i class="fas fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm group-focus-within:text-primary-500"></i>
                <input type="text" name="q" value="{{ request('q') }}"
                       placeholder="Cari judul buku, ISBN, atau penulis..."
                       class="w-full pl-11 pr-4 py-2.5 text-sm rounded-2xl border-0 ring-1 ring-slate-200 bg-slate-100/70 focus:bg-white focus:ring-2 focus:ring-primary-400 dark:bg-slate-800 dark:ring-slate-700 dark:text-slate-100 transition">
            </div>
        </form>

        {{-- Date (desktop only) --}}
        <div class="hidden lg:flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 px-3 py-1.5 rounded-xl bg-slate-100/60 dark:bg-slate-800/60">
            <i class="fas fa-calendar-day text-primary-500"></i>
            <span>{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d M Y') }}</span>
        </div>

        {{-- Theme toggle --}}
        <button @click="$store.theme.toggle()"
                class="p-2.5 rounded-xl hover:bg-primary-50 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-300 transition"
                aria-label="Toggle theme">
            <i x-show="!$store.theme.dark" class="fas fa-moon"></i>
            <i x-show="$store.theme.dark" x-cloak class="fas fa-sun text-amber-400"></i>
        </button>

        {{-- Notifications --}}
        @php $unreadCount = auth()->user()->unreadNotifications()->count(); @endphp
        <a href="{{ route('notifications.index') }}"
           class="relative p-2.5 rounded-xl hover:bg-primary-50 dark:hover:bg-slate-800 text-slate-500 dark:text-slate-300 transition">
            <i class="fas fa-bell"></i>
            @if($unreadCount > 0)
                <span class="absolute top-1 right-1 h-4 min-w-4 px-1 rounded-full bg-gradient-to-br from-rose-500 to-red-600 text-white text-[10px] flex items-center justify-center font-bold ring-2 ring-white dark:ring-slate-900">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
            @endif
        </a>

        {{-- User menu --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-2 p-1 pr-2 rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <span class="h-9 w-9 rounded-xl text-white flex items-center justify-center text-sm font-bold shadow-soft" style="background-image:linear-gradient(135deg,#8b5cf6,#6d28d9)">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 leading-tight">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-slate-500 capitalize">{{ str_replace('_',' ', auth()->user()->getRoleNames()->first() ?? 'user') }}</p>
                </div>
                <i class="fas fa-chevron-down text-xs text-slate-400"></i>
            </button>
            <div x-show="open" x-cloak @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                 class="absolute right-0 mt-2 w-60 rounded-2xl bg-white dark:bg-slate-800 ring-1 ring-slate-200 dark:ring-slate-700 shadow-hover py-2 z-50">
                <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700">
                    <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-primary-50 dark:hover:bg-slate-700 transition">
                    <i class="fas fa-user-gear w-4 text-primary-600"></i> Profil Saya
                </a>
                @if(auth()->user()->member)
                    <a href="{{ route('members.card', auth()->user()->member) }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-primary-50 dark:hover:bg-slate-700 transition">
                        <i class="fas fa-id-card w-4 text-primary-600"></i> Kartu Anggota
                    </a>
                @endif
                <a href="{{ route('wishlist.index') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-sm hover:bg-primary-50 dark:hover:bg-slate-700 transition">
                    <i class="fas fa-heart w-4 text-primary-600"></i> Wishlist
                </a>
                <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button class="w-full text-left flex items-center gap-2.5 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-slate-700 transition">
                        <i class="fas fa-right-from-bracket w-4"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
