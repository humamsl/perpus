<footer class="mt-10 border-t border-slate-200/70 dark:border-white/[.06]">
    <div class="max-w-screen-2xl mx-auto py-5 px-4 md:px-7 text-xs text-slate-500 dark:text-slate-400 flex justify-between items-center flex-wrap gap-3">
        <span class="flex items-center gap-2">
            <i class="fas fa-book-open-reader text-primary-500"></i>
            &copy; {{ date('Y') }} {{ $appProfile->app_name ?? config('app.name') }}. Konsep multi-tenant terinspirasi SpotBaca.
        </span>
        <span class="flex items-center gap-4">
            <a href="{{ route('catalog.index') }}" class="link-anim hover:text-primary-600 dark:hover:text-white">Katalog</a>
            <a href="#" class="link-anim hover:text-primary-600 dark:hover:text-white">Bantuan</a>
            <a href="#" class="link-anim hover:text-primary-600 dark:hover:text-white">Tentang</a>
        </span>
    </div>
</footer>
