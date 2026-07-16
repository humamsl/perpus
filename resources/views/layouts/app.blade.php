<!doctype html>
<html lang="{{ app()->getLocale() }}" x-data x-init="$store.theme.init()" :class="{ 'dark': $store.theme.dark }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $appProfile->app_name ?? config('app.name'))</title>
    <link rel="icon" href="{{ !empty($appProfile->favicon) ? asset('storage/'.$appProfile->favicon) : "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E%F0%9F%93%9A%3C/text%3E%3C/svg%3E" }}">

    {{-- Font Awesome — self-hosted (public/vendor), tidak butuh koneksi internet --}}
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free-6.4.2-web/css/all.min.css') }}">

    {{-- Tailwind, tipografi, Alpine.js & Chart.js — dibangun lokal lewat Vite (lihat
         resources/css/app.css & resources/js/app.js), tidak lagi lewat CDN --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen antialiased" x-data="{ ...toast() }">

@auth
<div class="flex">
    @include('partials.sidebar')
    {{-- Mobile sidebar overlay --}}
    <div x-show="$store.sidebar.mobileOpen" x-cloak
         @click="$store.sidebar.mobileOpen = false"
         x-transition.opacity
         class="md:hidden fixed inset-0 bg-black/50 z-30"></div>

    <div class="app-shell flex-1 min-h-screen min-w-0"
         :style="{ marginLeft: $store.sidebar.isDesktop ? ($store.sidebar.open ? '16rem' : '4rem') : '0' }">
        @include('partials.topbar')
        <main class="p-4 md:p-6 max-w-screen-2xl mx-auto min-w-0">
            @include('partials.breadcrumb')
            @if (session('toast'))
                <div x-init="push(@js(session('toast')), 'success')"></div>
            @endif
            @if ($errors->any())
                <div class="card mb-4 border-l-4 border-red-500">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-500 mt-0.5"></i>
                        <div>
                            <p class="font-semibold text-red-700 dark:text-red-300">Terjadi kesalahan:</p>
                            <ul class="mt-1 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            @yield('content')
        </main>
        @include('partials.footer')
    </div>
</div>
@else
    @hasSection('fullscreen')
        @yield('content')
    @else
        @include('partials.guest-header')
        @yield('content')
        @include('partials.guest-footer')
    @endif
@endauth

@include('partials.toast')
</body>
</html>
