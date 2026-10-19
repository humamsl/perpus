{{-- Header publik: transparan di atas hero, menjadi kaca (glass) setelah scroll --}}
<header data-scroll-header
        class="group/h fixed inset-x-0 top-0 z-40 text-white transition-all duration-500 ease-out-expo
               [&.is-scrolled]:py-0 py-2"
        x-data="{ mobileNav: false }">
    <div class="container mx-auto px-4">
        <div class="mt-2 flex items-center justify-between gap-2 rounded-2xl px-3 py-2.5 transition-all duration-500 ease-out-expo
                    group-[.is-scrolled]/h:bg-ink-950/75 group-[.is-scrolled]/h:shadow-2xl group-[.is-scrolled]/h:shadow-black/20 group-[.is-scrolled]/h:ring-1 group-[.is-scrolled]/h:ring-white/10 group-[.is-scrolled]/h:backdrop-blur-2xl">
            <a href="/" class="group flex items-center gap-3 min-w-0">
                @if(!empty($appProfile->logo))
                    <img src="{{ asset('storage/'.$appProfile->logo) }}" class="h-10 w-10 rounded-xl object-cover shadow-lg ring-1 ring-white/20 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-105" alt="Logo">
                @else
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-white to-primary-100 text-primary-700 flex items-center justify-center text-xl shadow-lg transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-105">
                        <i class="fas fa-book-open-reader"></i>
                    </div>
                @endif
                <div class="min-w-0">
                    <p class="font-display font-bold text-base sm:text-lg leading-tight truncate">{{ $appProfile->app_name ?? config('app.name') }}</p>
                    <p class="text-[11px] text-white/70 truncate">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
                </div>
            </a>

            @php
                $navLinks = [
                    ['url' => url('/'),                       'label' => 'Beranda', 'icon' => 'fa-home',             'active' => request()->routeIs('home')],
                    ['url' => route('catalog.index'),         'label' => 'Katalog', 'icon' => 'fa-compass',          'active' => request()->routeIs('catalog.*')],
                    ['url' => url('/#spots'),                 'label' => 'Lokasi',  'icon' => 'fa-location-dot',     'active' => false],
                    ['url' => route('visitors.history'),      'label' => 'Histori', 'icon' => 'fa-clock-rotate-left','active' => request()->routeIs('visitors.history*')],
                ];
            @endphp
            <nav class="hidden md:flex items-center gap-1 rounded-full bg-white/[.07] p-1 ring-1 ring-white/10 backdrop-blur text-sm">
                @foreach($navLinks as $n)
                    <a href="{{ $n['url'] }}"
                       class="flex items-center gap-1.5 rounded-full px-4 py-1.5 transition-all duration-300
                              {{ $n['active'] ? 'bg-white text-primary-800 shadow-lg font-semibold' : 'text-white/80 hover:bg-white/10 hover:text-white' }}">
                        <i class="fas {{ $n['icon'] }} text-xs"></i> {{ $n['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                <div class="hidden xl:flex items-center gap-2 text-xs bg-white/[.07] ring-1 ring-white/10 px-3 py-2 rounded-xl">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full rounded-full bg-emerald-400 animate-pulse-ring"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-400"></span>
                    </span>
                    <span>Pengunjung bulan ini <b>{{ number_format(\App\Models\VisitorLog::monthCount()) }}</b> · hari ini <b>{{ number_format(\App\Models\VisitorLog::todayCount()) }}</b></span>
                </div>

                <button type="button" @click="$store.theme.toggle()" class="hidden sm:grid h-10 w-10 place-items-center rounded-xl bg-white/[.07] ring-1 ring-white/10 hover:bg-white/15 transition overflow-hidden relative" aria-label="Toggle theme">
                    <i class="fas fa-moon absolute transition-all duration-500 ease-spring" :class="$store.theme.dark ? 'translate-y-8 opacity-0' : 'opacity-100'"></i>
                    <i class="fas fa-sun absolute text-amber-300 transition-all duration-500 ease-spring" :class="$store.theme.dark ? 'opacity-100' : '-translate-y-8 opacity-0'"></i>
                </button>

                @auth
                    {{-- Menu profil user login: arahkan ke dashboard sesuai role --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-2 bg-white/[.07] ring-1 ring-white/10 hover:bg-white/15 pl-1.5 pr-3 py-1.5 rounded-xl transition">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="h-7 w-7 rounded-lg object-cover" alt="Avatar">
                            @else
                                <span class="h-7 w-7 rounded-lg bg-white text-primary-700 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            @endif
                            <span class="hidden sm:block text-sm font-semibold max-w-[9rem] truncate">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-[10px] opacity-80 transition-transform duration-300" :class="open && 'rotate-180'"></i>
                        </button>
                        <div x-show="open" @click.outside="open = false" x-cloak
                             x-transition:enter="transition ease-out-expo duration-300"
                             x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="dropdown-panel absolute right-0 mt-2 w-60 text-slate-700 dark:text-slate-200 z-50 origin-top-right">
                            <div class="px-4 py-2 border-b border-slate-100 dark:border-white/[.06] mb-1">
                                <p class="font-semibold text-sm truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 capitalize truncate">
                                    {{ str_replace('_', ' ', auth()->user()->getRoleNames()->first() ?? 'member') }}
                                </p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="dropdown-item"><i class="fas fa-gauge-high w-4 text-primary-500"></i> Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item"><i class="fas fa-user w-4 text-primary-500"></i> Profil Saya</a>
                            <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 dark:border-white/[.06] mt-1 pt-1">
                                @csrf
                                <button class="dropdown-item w-full text-left !text-rose-600 dark:!text-rose-400 hover:!bg-rose-50 dark:hover:!bg-rose-500/10">
                                    <i class="fas fa-right-from-bracket w-4"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" data-magnetic=".2"
                       class="group relative inline-flex items-center gap-2 overflow-hidden bg-white text-primary-700 px-4 py-2 rounded-xl font-semibold text-sm shadow-lg shadow-black/10 transition hover:shadow-glow-lg whitespace-nowrap">
                        <i class="fas fa-right-to-bracket transition-transform duration-300 group-hover:translate-x-0.5"></i> Masuk
                    </a>
                @endauth

                {{-- Tombol menu mobile — nav desktop disembunyikan < md --}}
                {{-- @click.stop: tanpa .stop, klik ini ikut tertangkap @click.outside
                     milik panel di bawah dan menu langsung tertutup lagi --}}
                <button @click.stop="mobileNav = !mobileNav" aria-label="Buka menu navigasi"
                        class="md:hidden grid h-10 w-10 place-items-center rounded-xl bg-white/[.07] ring-1 ring-white/10 hover:bg-white/15 transition">
                    <i class="fas transition-transform duration-300" :class="mobileNav ? 'fa-xmark rotate-90' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        {{-- Panel navigasi mobile --}}
        <nav x-show="mobileNav" x-cloak @click.outside="mobileNav = false"
             x-transition:enter="transition ease-out-expo duration-300" x-transition:enter-start="opacity-0 -translate-y-3" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden mt-2 rounded-2xl bg-ink-950/90 ring-1 ring-white/10 backdrop-blur-2xl shadow-2xl">
            <div class="px-2 py-2 space-y-1 text-sm">
                @foreach($navLinks as $n)
                    <a href="{{ $n['url'] }}" @click="mobileNav = false"
                       class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition {{ $n['active'] ? 'bg-white/15 font-semibold' : 'hover:bg-white/10' }}">
                        <i class="fas {{ $n['icon'] }} w-5 text-center text-primary-300"></i> {{ $n['label'] }}
                    </a>
                @endforeach
                <button type="button" @click="$store.theme.toggle()" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-white/10 transition">
                    <i class="fas w-5 text-center text-primary-300" :class="$store.theme.dark ? 'fa-sun' : 'fa-moon'"></i>
                    <span x-text="$store.theme.dark ? 'Mode Terang' : 'Mode Gelap'"></span>
                </button>
                <div class="flex items-center gap-2 px-3 py-2.5 text-xs border-t border-white/10 mt-1 text-white/80">
                    <i class="fas fa-users w-5 text-center"></i>
                    Pengunjung bulan ini <b>{{ number_format(\App\Models\VisitorLog::monthCount()) }}</b>, hari ini <b>{{ number_format(\App\Models\VisitorLog::todayCount()) }}</b>
                </div>
            </div>
        </nav>
    </div>
</header>
{{-- Halaman selain beranda tidak punya hero gelap di bawah header transparan,
     jadi beri latar & ruang supaya konten tidak tertutup header fixed --}}
@unless(request()->routeIs('home'))
    <div class="relative h-28 -mb-6 overflow-hidden bg-gradient-to-br from-primary-700 via-primary-800 to-ink-950">
        <div class="absolute inset-0 bg-grid-light mask-fade-b"></div>
        <div class="absolute -top-10 right-10 h-48 w-48 rounded-full bg-accent-400/20 blur-3xl animate-blob"></div>
    </div>
@endunless
