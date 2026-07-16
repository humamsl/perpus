<header class="bg-gradient-to-r from-primary-600 to-primary-800 text-white sticky top-0 z-30 shadow-lg">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="/" class="flex items-center gap-3">
            @if(!empty($appProfile->logo))
                <img src="{{ asset('storage/'.$appProfile->logo) }}" class="h-10 w-10 rounded-lg object-cover shadow" alt="Logo">
            @else
                <div class="h-10 w-10 rounded-lg bg-white text-primary-600 flex items-center justify-center text-xl shadow">
                    <i class="fas fa-book-open-reader"></i>
                </div>
            @endif
            <div>
                <p class="font-bold text-lg leading-tight">{{ $appProfile->app_name ?? config('app.name') }}</p>
                <p class="text-xs opacity-90">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</p>
            </div>
        </a>
        <nav class="hidden md:flex items-center gap-6 text-sm">
            <a href="/" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-home"></i> Beranda</a>
            <a href="{{ route('catalog.index') }}" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-compass"></i> Katalog</a>
            <a href="/#spots" class="hover:opacity-80 flex items-center gap-1"><i class="fas fa-location-dot"></i> Lokasi</a>
        </nav>
        <div class="flex items-center gap-2">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-accent">
                    <i class="fas fa-gauge-high"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="bg-white text-primary-700 px-4 py-2 rounded-lg font-semibold text-sm hover:bg-slate-100">
                    <i class="fas fa-right-to-bracket"></i> Masuk
                </a>
            @endauth
        </div>
    </div>
</header>
