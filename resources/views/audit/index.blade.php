@extends('layouts.app')
@section('title','Audit Log')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-clipboard-list',
    'title' => 'Audit Log',
    'desc'  => 'Riwayat aktivitas pengguna pada sistem.',
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>User</th>
                <th>Aksi</th>
                <th>IP</th>
            </tr>
        </thead>
        <tbody>
        @forelse($logs as $l)
            <tr>
                <td class="whitespace-nowrap">{{ $l->created_at?->format('d M Y H:i:s') }}</td>
                <td>{{ $l->user?->name ?? '-' }}</td>
                <td class="font-mono text-xs">{{ $l->action }}</td>
                <td class="font-mono text-xs">{{ $l->ip_address }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $logs->links() }}</div>
</div>
@endsection
