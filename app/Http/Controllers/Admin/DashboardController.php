<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // ─── Stats utama ──────────────────────────────────────────────────────
        $stats = [
            'pengurus'      => DB::table('pengurus')->count(),
            'program_kerja' => DB::table('program_kerja')->count(),
            'aspirasi'      => DB::table('aspirasi')
                                  ->where('status_tindak_lanjut', 'belum_ditindaklanjuti')
                                  ->count(),
            'saldo'         => DB::table('keuangan')->where('jenis', 'masuk')->sum('jumlah')
                             - DB::table('keuangan')->where('jenis', 'keluar')->sum('jumlah'),
        ];

        // ─── Program kerja breakdown by status ───────────────────────────────
        $prokerStatus = DB::table('program_kerja')
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // ─── Aspirasi terbaru ─────────────────────────────────────────────────
        $aspirasiTerbaru = DB::table('aspirasi')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // ─── Transaksi keuangan terbaru ───────────────────────────────────────
        $transaksiTerbaru = DB::table('keuangan')
            ->join('users', 'keuangan.user_id', '=', 'users.id')
            ->select('keuangan.*', 'users.name as pencatat')
            ->orderBy('keuangan.created_at', 'desc')
            ->limit(5)
            ->get();

        // ─── Program kerja berjalan ───────────────────────────────────────────
        $prokerBerjalan = DB::table('program_kerja')
            ->join('kementerian', 'program_kerja.kementerian_id', '=', 'kementerian.id')
            ->select('program_kerja.*', 'kementerian.kode as kem_kode')
            ->where('program_kerja.status', 'berjalan')
            ->orderBy('program_kerja.tanggal_pelaksanaan')
            ->limit(5)
            ->get();

        // ─── Keuangan bulan ini ───────────────────────────────────────────────
        $masukBulan  = DB::table('keuangan')
            ->where('jenis', 'masuk')
            ->whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->sum('jumlah');

        $keluarBulan = DB::table('keuangan')
            ->where('jenis', 'keluar')
            ->whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->sum('jumlah');

        return view('admin.dashboard', compact(
            'stats', 'prokerStatus', 'aspirasiTerbaru',
            'transaksiTerbaru', 'prokerBerjalan',
            'masukBulan', 'keluarBulan'
        ));
    }
}
