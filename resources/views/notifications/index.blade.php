@extends('layouts.app')
@section('title','Notifikasi')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-bell',
    'title' => 'Notifikasi',
    'desc'  => 'Pemberitahuan dan pembaruan terbaru untuk Anda.',
    'actions' => [
        ['url' => route('notifications.readAll'), 'label' => 'Tandai Semua Dibaca', 'class' => 'btn-secondary', 'icon' => 'fa-check-double'],
    ],
])

<div class="card divide-y divide-slate-100 dark:divide-slate-700">
    @forelse($items as $n)
        <div class="flex items-start gap-4 py-4 first:pt-0 last:pb-0 {{ $n->read_at ? '' : 'bg-primary-50/50 dark:bg-slate-700/30 -mx-6 px-6' }}">
            <span class="h-10 w-10 rounded-xl bg-primary-100 text-primary-700 dark:bg-primary-900/40 dark:text-primary-300 flex items-center justify-center shrink-0">
                <i class="fas fa-bell"></i>
            </span>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <p class="text-sm text-slate-700 dark:text-slate-200">{{ $n->data['message'] ?? '' }}</p>
                    @if(!$n->read_at)
                        <span class="badge-blue">Baru</span>
                    @else
                        <span class="badge-gray">Dibaca</span>
                    @endif
                </div>
                <p class="text-xs text-slate-500 mt-1">{{ $n->created_at?->diffForHumans() }}</p>
            </div>
            @if(!$n->read_at)
                <form method="POST" action="{{ route('notifications.read', $n->id) }}">@csrf
                    <button class="btn-secondary text-xs py-1.5 px-3"><i class="fas fa-check"></i> Tandai</button>
                </form>
            @endif
        </div>
    @empty
        <div class="text-center py-16">
            <i class="fas fa-bell-slash text-5xl text-slate-300 mb-4 block"></i>
            <p class="font-semibold text-slate-600 dark:text-slate-300">Tidak ada notifikasi</p>
            <p class="text-sm text-slate-500 mt-1">Pemberitahuan baru akan muncul di sini.</p>
        </div>
    @endforelse
</div>
@endsection
