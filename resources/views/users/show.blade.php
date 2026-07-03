@extends('layouts.app')
@section('title', $user->name)
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user',
    'title' => $user->name,
    'desc'  => $user->email,
    'actions' => [
        ['url' => route('users.edit', $user), 'label' => 'Edit', 'class' => 'btn-primary', 'icon' => 'fa-pen'],
        ['url' => route('users.index'), 'label' => 'Kembali', 'class' => 'btn-secondary', 'icon' => 'fa-arrow-left'],
    ],
])

<div class="card max-w-2xl">
    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Role</dt>
            <dd class="font-medium mt-0.5">{{ $user->getRoleNames()->join(', ') }}</dd>
        </div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Aktif</dt>
            <dd class="mt-0.5">
                @if($user->is_active)<span class="badge-green"><i class="fas fa-check"></i> Ya</span>
                @else<span class="badge-red"><i class="fas fa-xmark"></i> Tidak</span>@endif
            </dd>
        </div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">Login Terakhir</dt>
            <dd class="font-medium mt-0.5">{{ $user->last_login_at?->format('d M Y H:i') ?? '-' }}</dd>
        </div>
        <div>
            <dt class="text-slate-500 dark:text-slate-400">IP Terakhir</dt>
            <dd class="font-medium mt-0.5 font-mono text-xs">{{ $user->last_login_ip ?? '-' }}</dd>
        </div>
    </dl>
</div>
@endsection
