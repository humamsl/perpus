<?php

namespace App\Http\Controllers;

use App\Models\AppProfile;
use App\Models\VisitorLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class VisitorLogController extends Controller
{
    public function index()
    {
        $logs = VisitorLog::with('user')->latest()->paginate(50);

        return view('visitors.index', [
            'logs'         => $logs,
            'todayCount'   => VisitorLog::todayCount(),
            'monthCount'   => VisitorLog::monthCount(),
            'monthlyChart' => VisitorLog::monthlyCounts(12),
        ]);
    }

    public function history()
    {
        return view('visitors.history', [
            'todayCount'  => VisitorLog::todayCount(),
            'monthCount'  => VisitorLog::monthCount(),
            'dailyCounts' => VisitorLog::dailyCounts(30),
            'monthlyChart'=> VisitorLog::monthlyCounts(12),
        ]);
    }

    public function historyDay(string $date)
    {
        $date = Carbon::parse($date)->toDateString();

        return view('visitors.history-show', [
            'date'         => $date,
            'total'        => VisitorLog::whereDate('created_at', $date)->count(),
            'hourlyCounts' => VisitorLog::hourlyCounts($date),
        ]);
    }

    public function export()
    {
        $data = [
            'title'        => 'Laporan Riwayat Pengunjung',
            'appProfile'   => AppProfile::current(),
            'todayCount'   => VisitorLog::todayCount(),
            'monthCount'   => VisitorLog::monthCount(),
            'dailyCounts'  => VisitorLog::dailyCounts(30),
            'monthlyChart' => VisitorLog::monthlyCounts(12),
        ];

        return Pdf::loadView('visitors.pdf', $data)->download('riwayat-pengunjung-' . now()->format('Y-m-d') . '.pdf');
    }

    /** Dipanggil dari browser pengunjung jika izin lokasi diberikan; hanya boleh mengisi log kunjungannya sendiri (via session). */
    public function updateLocation(Request $request)
    {
        $data = $request->validate([
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ]);

        $logId = $request->session()->get('visitor_log_id');
        if ($logId) {
            VisitorLog::whereKey($logId)->whereNull('latitude')->update($data);
        }

        return response()->noContent();
    }
}
