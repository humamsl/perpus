@php
    $segments = collect(request()->segments());
    $items = $segments->map(function ($seg, $i) use ($segments) {
        return [
            'label' => ucfirst(str_replace('-', ' ', $seg)),
            'url'   => url(implode('/', $segments->slice(0, $i+1)->all())),
        ];
    });
@endphp
@if($items->isNotEmpty())
<nav class="mb-5 animate-fade-in" aria-label="Breadcrumb">
    <ol class="inline-flex flex-wrap items-center gap-1 rounded-full bg-white/60 px-1.5 py-1 text-xs text-slate-500 ring-1 ring-slate-200/60 backdrop-blur dark:bg-white/[.03] dark:text-slate-400 dark:ring-white/[.06]">
        <li>
            <a href="{{ url('/') }}" class="flex items-center gap-1.5 rounded-full px-2.5 py-1 transition hover:bg-primary-50 hover:text-primary-700 dark:hover:bg-white/5 dark:hover:text-white">
                <i class="fas fa-house text-[10px]"></i> Home
            </a>
        </li>
        @foreach($items as $it)
            <li class="text-slate-300 dark:text-slate-600"><i class="fas fa-chevron-right text-[8px]"></i></li>
            <li>
                @if($loop->last)
                    <span class="rounded-full px-2.5 py-1 font-semibold text-primary-700 bg-primary-50 dark:bg-primary-400/10 dark:text-primary-200">{{ $it['label'] }}</span>
                @else
                    <a href="{{ $it['url'] }}" class="rounded-full px-2.5 py-1 transition hover:bg-primary-50 hover:text-primary-700 dark:hover:bg-white/5 dark:hover:text-white">{{ $it['label'] }}</a>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif
