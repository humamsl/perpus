@extends('layouts.app')
@section('title','Role & Permission')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-shield-halved',
    'title' => 'Role & Permission',
    'desc'  => 'Kelola role dan hak akses pengguna sistem.',
    'actions' => [
        ['url' => route('roles.create'), 'label' => 'Role Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Role</th>
                <th>Permissions</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($roles as $r)
            <tr>
                <td class="font-semibold">{{ $r->name }}</td>
                <td class="text-xs text-slate-500 dark:text-slate-400">{{ $r->permissions->pluck('name')->join(', ') }}</td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <div class="inline-flex gap-1">
                        <a href="{{ route('roles.edit', $r) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
