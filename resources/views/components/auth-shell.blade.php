{{--
    Kerangka halaman autentikasi (login, daftar, lupa/reset password).
    Pakai:
    <x-auth-shell title="Masuk" subtitle="Akses akun perpustakaan Anda."
                  heading="Selamat Datang Kembali" lead="Lanjutkan perjalanan literasi Anda." :stats="true">
        ...form...
    </x-auth-shell>
--}}
@props([
    'title',
    'subtitle' => null,
    'heading' => 'Perpustakaan Digital',
    'lead' => null,
    'stats' => false,
    'icon' => 'fa-book-open-reader',
    'wide' => false,
])
@php $appName = $appProfile->app_name ?? config('app.name'); @endphp

<div class="relative min-h-screen flex overflow-hidden">
    {{-- ═════════ Panel brand (desktop) ═════════ --}}
    <div class="relative isolate hidden lg:flex w-[46%] xl:w-1/2 flex-col justify-between overflow-hidden bg-ink-950 p-12 text-white noise">
        <div aria-hidden="true" class="absolute inset-0 -z-10">
            <div class="absolute inset-0 bg-cover bg-center opacity-20" style="background-image:url('{{ asset('img/perpus-bg.png') }}')"></div>
            <div class="absolute inset-0 bg-gradient-to-br from-primary-700/95 via-primary-900/90 to-ink-950"></div>
            <div class="absolute -top-24 -left-24 h-96 w-96 rounded-full bg-fuchsia-500/30 blur-[100px] animate-blob"></div>
            <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-accent-400/20 blur-[100px] animate-blob [animation-delay:-7s]"></div>
            <div class="absolute inset-0 bg-grid-light mask-fade-b"></div>
        </div>

        <a href="/" class="group relative flex items-center gap-3 animate-fade-up">
            @if(!empty($appProfile->logo))
                <img src="{{ asset('storage/'.$appProfile->logo) }}" class="h-12 w-12 rounded-2xl object-cover shadow-lg ring-1 ring-white/20 transition duration-500 ease-spring group-hover:rotate-[-8deg]" alt="Logo">
            @else
                <div class="h-12 w-12 rounded-2xl bg-white text-primary-700 flex items-center justify-center text-2xl shadow-lg transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-105">
                    <i class="fas fa-book-open-reader"></i>
                </div>
            @endif
            <div>
                <p class="font-display font-bold text-xl">{{ $appName }}</p>
                <p class="text-xs text-white/60 tracking-wide">Perpustakaan Digital</p>
            </div>
        </a>

        {{-- Ilustrasi buku melayang --}}
        <div aria-hidden="true" class="pointer-events-none absolute right-10 bottom-12 hidden xl:block scale-75 origin-bottom-right 2xl:scale-90">
            <div class="relative h-72 w-56">
                <div class="absolute right-0 top-0 h-60 w-44 rounded-2xl bg-gradient-to-br from-gold-300 to-orange-500 shadow-2xl shadow-black/40 rotate-[10deg] animate-float-rot" style="--r:10deg"></div>
                <div class="absolute left-0 top-8 h-60 w-44 rounded-2xl bg-gradient-to-br from-white/25 to-white/5 ring-1 ring-white/25 backdrop-blur-xl shadow-2xl animate-float-rot [animation-delay:-2s]" style="--r:-6deg">
                    <div class="p-5 space-y-2.5">
                        <div class="h-2 w-16 rounded-full bg-white/60"></div>
                        <div class="h-2 w-24 rounded-full bg-white/30"></div>
                        <div class="h-2 w-20 rounded-full bg-white/30"></div>
                        <div class="mt-10 grid h-12 w-12 place-items-center rounded-xl bg-white/20"><i class="fas {{ $icon }} text-xl"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="relative max-w-md">
            <h2 class="text-4xl xl:text-5xl font-extrabold leading-tight animate-fade-up delay-1">
                {!! $heading !!}
            </h2>
            @if($lead)
                <p class="mt-5 text-lg text-white/75 leading-relaxed animate-fade-up delay-2">{{ $lead }}</p>
            @endif
            @if($stats)
                @php
                    $authStats = [
                        ['n' => \App\Models\Book::count() + \App\Models\OfflineBook::count(), 'l' => 'Koleksi'],
                        ['n' => \App\Models\ReadingSpot::count(), 'l' => 'Spot Baca'],
                        ['n' => \App\Models\Member::count(), 'l' => 'Anggota'],
                    ];
                @endphp
                <div class="mt-10 flex gap-3">
                    @foreach($authStats as $s)
                        <div class="rounded-2xl bg-white/[.07] px-5 py-4 ring-1 ring-white/10 backdrop-blur animate-fade-up" style="animation-delay: {{ .3 + $loop->index * .1 }}s">
                            <p class="text-3xl font-display font-bold tabular-nums" data-count>{{ number_format($s['n']) }}</p>
                            <p class="text-xs uppercase tracking-wider text-white/60">{{ $s['l'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <p class="relative text-xs text-white/50">&copy; {{ date('Y') }} GarageLibrary · {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
    </div>

    {{-- ═════════ Form ═════════ --}}
    <div class="relative flex-1 flex items-center justify-center p-4 py-10 md:p-10">
        <div aria-hidden="true" class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute -top-20 -right-20 h-80 w-80 rounded-full bg-primary-400/20 blur-[100px] animate-blob"></div>
            <div class="absolute bottom-0 -left-10 h-72 w-72 rounded-full bg-accent-400/15 blur-[100px] animate-blob [animation-delay:-9s]"></div>
            <div class="absolute inset-0 bg-grid mask-fade-b opacity-50"></div>
        </div>

        {{-- tombol tema --}}
        <button type="button" @click="$store.theme.toggle()" class="icon-btn absolute top-5 right-5 overflow-hidden bg-white/70 ring-1 ring-slate-200 backdrop-blur dark:bg-white/5 dark:ring-white/10" aria-label="Toggle theme">
            <i class="fas fa-moon absolute transition-all duration-500 ease-spring" :class="$store.theme.dark ? 'translate-y-8 opacity-0' : 'opacity-100'"></i>
            <i class="fas fa-sun absolute text-amber-400 transition-all duration-500 ease-spring" :class="$store.theme.dark ? 'opacity-100' : '-translate-y-8 opacity-0'"></i>
        </button>

        <div class="w-full {{ $wide ? 'max-w-xl' : 'max-w-md' }}">
            <a href="/" class="flex items-center gap-3 lg:hidden mb-8 animate-fade-up">
                <span class="grid h-11 w-11 place-items-center rounded-xl bg-gradient-to-br from-primary-400 to-primary-700 text-white shadow-hover">
                    <i class="fas fa-book-open-reader text-lg"></i>
                </span>
                <span class="font-display font-bold text-lg text-slate-900 dark:text-white">{{ $appName }}</span>
            </a>

            <div class="rounded-[1.75rem] bg-white/80 p-7 md:p-9 shadow-hover ring-1 ring-slate-900/5 backdrop-blur-xl animate-scale-in dark:bg-white/[.04] dark:ring-white/10 dark:shadow-none">
                <span class="mb-5 inline-grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-primary-400 to-primary-700 text-white shadow-hover animate-float">
                    <i class="fas {{ $icon }} text-lg"></i>
                </span>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $title }}</h1>
                @if($subtitle)<p class="text-slate-500 dark:text-slate-400 mt-1.5 mb-6">{{ $subtitle }}</p>@else<div class="mb-6"></div>@endif

                @if($errors->any())
                    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-rose-50 px-4 py-3 text-sm text-rose-700 ring-1 ring-rose-200 animate-wiggle dark:bg-rose-500/10 dark:text-rose-300 dark:ring-rose-500/20">
                        <i class="fas fa-circle-exclamation mt-0.5"></i> <span>{{ $errors->first() }}</span>
                    </div>
                @endif
                @if(session('status'))
                    <div class="mb-5 flex items-start gap-3 rounded-2xl bg-emerald-50 px-4 py-3 text-sm text-emerald-700 ring-1 ring-emerald-200 animate-fade-up dark:bg-emerald-500/10 dark:text-emerald-300 dark:ring-emerald-500/20">
                        <i class="fas fa-circle-check mt-0.5"></i> <span>{{ session('status') }}</span>
                    </div>
                @endif

                {{ $slot }}
            </div>

            @isset($footer)
                <div class="mt-6 text-center text-sm text-slate-600 dark:text-slate-400 animate-fade-up delay-3">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
