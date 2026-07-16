<footer class="bg-slate-900 text-slate-400 py-8">
    <div class="container mx-auto px-4 flex flex-wrap justify-between gap-4 text-sm">
        <div>
            <p class="font-bold text-white">{{ $appProfile->app_name ?? config('app.name') }}</p>
            <p class="text-xs mt-1">&copy; {{ date('Y') }} {{ $appProfile->app_name ?? config('app.name') }}. All rights reserved.</p>
        </div>
        <div class="flex gap-4 text-xs">
            <a href="{{ route('catalog.index') }}" class="hover:text-white">Katalog</a>
            <a href="/#spots" class="hover:text-white">Lokasi</a>
            @guest <a href="{{ route('register') }}" class="hover:text-white">Daftar</a> @endguest
        </div>
    </div>
</footer>
