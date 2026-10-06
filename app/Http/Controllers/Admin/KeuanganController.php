<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Keuangan::with(['user', 'programKerja'])
            ->orderBy('tanggal_transaksi', 'desc');

        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }
        if ($request->filled('program_kerja_id')) {
            $query->where('program_kerja_id', $request->program_kerja_id);
        }

        $transaksi = $query->paginate(20)->withQueryString();
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();

        $totalMasuk  = Keuangan::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = Keuangan::where('jenis', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        $masukBulanIni  = Keuangan::where('jenis', 'masuk')
            ->whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->sum('jumlah');
        $keluarBulanIni = Keuangan::where('jenis', 'keluar')
            ->whereMonth('tanggal_transaksi', now()->month)
            ->whereYear('tanggal_transaksi', now()->year)
            ->sum('jumlah');

        return view('admin.keuangan.index', compact(
            'transaksi', 'programKerja',
            'totalMasuk', 'totalKeluar', 'saldo',
            'masukBulanIni', 'keluarBulanIni'
        ));
    }

    public function create()
    {
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();
        return view('admin.keuangan.create', compact('programKerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis'             => 'required|in:masuk,keluar',
            'jumlah'            => 'required|numeric|min:1',
            'keterangan'        => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',
            'program_kerja_id'  => 'nullable|exists:program_kerja,id',
        ]);

        Keuangan::create([
            'user_id'           => auth()->id(),
            'jenis'             => $request->jenis,
            'jumlah'            => $request->jumlah,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'program_kerja_id'  => $request->program_kerja_id ?: null,
        ]);

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil dicatat.');
    }

    public function edit(Keuangan $keuangan)
    {
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();
        return view('admin.keuangan.edit', compact('keuangan', 'programKerja'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'jenis'             => 'required|in:masuk,keluar',
            'jumlah'            => 'required|numeric|min:1',
            'keterangan'        => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',
            'program_kerja_id'  => 'nullable|exists:program_kerja,id',
        ]);

        $keuangan->update([
            'jenis'             => $request->jenis,
            'jumlah'            => $request->jumlah,
            'keterangan'        => $request->keterangan,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'program_kerja_id'  => $request->program_kerja_id ?: null,
        ]);

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return back()->with('success', 'Transaksi berhasil dihapus.');
    }

    // ─── Export laporan ──────────────────────────────────────────────────────
    public function export(Request $request)
    {
        $query = Keuangan::with(['user', 'programKerja'])
            ->orderBy('tanggal_transaksi', 'asc');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $transaksi   = $query->get();
        $totalMasuk  = $transaksi->where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = $transaksi->where('jenis', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        $periode = '';
        if ($request->filled('bulan') && $request->filled('tahun')) {
            $periode = \Carbon\Carbon::createFromDate($request->tahun, $request->bulan, 1)
                ->translatedFormat('F Y');
        } elseif ($request->filled('tahun')) {
            $periode = 'Tahun ' . $request->tahun;
        } else {
            $periode = 'Semua Periode';
        }

        return view('admin.keuangan.export', compact(
            'transaksi', 'totalMasuk', 'totalKeluar', 'saldo', 'periode'
        ));
    }
}
