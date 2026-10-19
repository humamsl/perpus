{{--
    Komponen header halaman dengan judul, deskripsi, dan tombol aksi.
    Pakai:
    @include('partials.page-header', [
        'icon' => 'fa-book',
        'title' => 'Manajemen Buku',
        'desc' => 'Kelola koleksi buku digital perpustakaan.',
        'actions' => [
            ['url' => route('books.create'), 'label' => '+ Buku Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus', 'can' => 'book.create'],
        ],
    ])
--}}
<div class="flex flex-wrap justify-between items-center gap-4 mb-6">
    <div class="flex items-center gap-4 min-w-0">
        @if(!empty($icon))
        <div class="group relative h-14 w-14 shrink-0 animate-scale-in">
            <div class="absolute inset-0 rounded-2xl bg-gradient-to-br from-primary-400 to-primary-700 blur-lg opacity-50 transition duration-500 group-hover:opacity-80"></div>
            <div class="relative h-14 w-14 rounded-2xl bg-gradient-to-br from-primary-400 via-primary-600 to-primary-800 text-white flex items-center justify-center shadow-hover ring-1 ring-white/20 transition duration-500 ease-spring group-hover:rotate-[-8deg] group-hover:scale-105">
                <i class="fas {{ $icon }} text-xl"></i>
            </div>
        </div>
        @endif
        <div class="min-w-0 animate-fade-up delay-1">
            <h1 class="text-2xl md:text-[1.7rem] font-bold text-slate-900 dark:text-white leading-tight">{{ $title }}</h1>
            @if(!empty($desc))<p class="text-sm text-slate-500 dark:text-slate-400 mt-1">{{ $desc }}</p>@endif
        </div>
    </div>
    @if(!empty($actions))
    <div class="flex gap-2 flex-wrap animate-fade-up delay-2">
        @foreach($actions as $a)
            @if(empty($a['can']) || auth()->user()->can($a['can']))
                <a href="{{ $a['url'] }}" class="{{ $a['class'] ?? 'btn-secondary' }}">
                    @if(!empty($a['icon']))<i class="fas {{ $a['icon'] }}"></i>@endif
                    {{ $a['label'] }}
                </a>
            @endif
        @endforeach
    </div>
    @endif
</div>
