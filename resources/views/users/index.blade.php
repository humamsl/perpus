@extends('layouts.app')
@section('title','Manajemen User')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-users-gear',
    'title' => 'Manajemen User',
    'desc'  => 'Kelola akun pengguna sistem.',
    'actions' => [
        ['url' => route('users.create'), 'label' => 'User Baru', 'class' => 'btn-primary', 'icon' => 'fa-plus'],
    ],
])

<div class="card overflow-x-auto">
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aktif</th>
                <th class="text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse($users as $u)
            <tr>
                <td class="font-medium">{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td>{{ $u->getRoleNames()->join(', ') }}</td>
                <td>
                    @if($u->is_active)<span class="badge-green"><i class="fas fa-check"></i> aktif</span>
                    @else<span class="badge-red"><i class="fas fa-xmark"></i> nonaktif</span>@endif
                </td>
                <td class="px-4 py-3 text-right whitespace-nowrap">
                    <div class="inline-flex gap-1 items-center">
                        <a href="{{ route('users.show', $u) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Detail"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('users.edit', $u) }}" class="p-2 rounded-lg hover:bg-primary-50 dark:hover:bg-slate-700 text-primary-600" title="Edit"><i class="fas fa-pen"></i></a>
                        <form method="POST" action="{{ route('users.toggleActive', $u) }}" class="inline-flex">
                            @csrf
                            <button class="p-2 rounded-lg hover:bg-amber-50 dark:hover:bg-slate-700 text-amber-600" title="{{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                <i class="fas {{ $u->is_active ? 'fa-toggle-off' : 'fa-toggle-on' }}"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $users->links() }}</div>
</div>
@endsection
