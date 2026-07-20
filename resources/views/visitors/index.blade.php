@extends('layouts.app')
@section('title','Riwayat Pengunjung')
@section('content')

@include('partials.page-header', [
    'icon'  => 'fa-user-clock',
    'title' => 'Riwayat Pengunjung',
    'desc'  => 'Riwayat kunjungan pada laman perpustakaan.',
    'actions' => [
        ['url' => route('visitors.export'), 'label' => 'Export PDF', 'class' => 'btn-secondary text-sm', 'icon' => 'fa-file-pdf'],
    ],
])

<div class="grid sm:grid-cols-2 gap-4 mb-6">
    <div class="rounded-2xl p-5 text-white shadow-soft bg-gradient-to-br from-primary-500 to-primary-800">
        <i class="fas fa-calendar-day text-xl opacity-90"></i>
        <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Pengunjung Hari Ini</p>
        <p class="text-2xl font-bold mt-1">{{ number_format($todayCount) }}</p>
    </div>
    <div class="rounded-2xl p-5 text-white shadow-soft bg-gradient-to-br from-emerald-400 to-emerald-600">
        <i class="fas fa-calendar-check text-xl opacity-90"></i>
        <p class="text-xs font-semibold uppercase tracking-wide opacity-90 mt-2">Pengunjung Bulan Ini</p>
        <p class="text-2xl font-bold mt-1">{{ number_format($monthCount) }}</p>
    </div>
</div>

<div class="card mb-6">
    <h2 class="font-bold text-lg mb-1">Grafik Pengunjung 12 Bulan Terakhir</h2>
    <p class="text-xs text-slate-500 mb-4">Jumlah kunjungan laman per bulan.</p>
    <canvas id="monthly-chart" height="90"></canvas>
</div>

<div class="card overflow-x-auto">
    <h2 class="font-bold text-lg mb-4">Log Kunjungan</h2>
    <table class="table-pretty">
        <thead>
            <tr>
                <th>Waktu</th>
                <th>Pengunjung</th>
                <th>Halaman</th>
                <th>IP</th>
                <th>Lokasi</th>
                <th>User Agent</th>
            </tr>
        </thead>
        <tbody>
        @forelse($logs as $l)
            <tr>
                <td class="whitespace-nowrap">{{ $l->created_at?->format('d M Y H:i:s') }}</td>
                <td>{{ $l->user?->name ?? 'Tamu' }}</td>
                <td class="font-mono text-xs">{{ $l->path }}</td>
                <td class="font-mono text-xs">{{ $l->ip_address }}</td>
                <td>
                    @if($l->map_url)
                        <a href="{{ $l->map_url }}" target="_blank" rel="noopener" class="text-primary-600 hover:underline text-xs whitespace-nowrap">
                            <i class="fas fa-map-pin"></i> Lihat peta
                        </a>
                    @else
                        <span class="text-xs text-slate-400">-</span>
                    @endif
                </td>
                <td class="text-xs text-slate-500 truncate max-w-xs block" title="{{ $l->user_agent }}">{{ $l->user_agent }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-slate-500 py-10">
                    <i class="fas fa-inbox text-3xl mb-2 block text-slate-300"></i>
                    Belum ada data.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-4 px-2">{{ $logs->links() }}</div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const ctx = document.getElementById('monthly-chart');
        if (!ctx || typeof Chart === 'undefined') return;
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlyChart->pluck('label')),
                datasets: [{
                    label: 'Jumlah Pengunjung',
                    data: @json($monthlyChart->pluck('total')),
                    borderColor: '#7c3aed', backgroundColor: 'rgba(124,58,237,0.12)',
                    tension: 0.35, fill: true, borderWidth: 2, pointRadius: 3,
                }],
            },
            options: {
                responsive: true,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { display: false } },
                },
            },
        });
    });
</script>
@endsection
