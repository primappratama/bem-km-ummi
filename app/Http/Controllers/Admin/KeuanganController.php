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

        // Filter jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter program kerja
        if ($request->filled('program_kerja_id')) {
            $query->where('program_kerja_id', $request->program_kerja_id);
        }

        // Filter bulan/tahun
        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_transaksi', $request->bulan);
        }
        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_transaksi', $request->tahun);
        }

        // Search keterangan
        if ($request->filled('search')) {
            $query->where('keterangan', 'like', '%' . $request->search . '%');
        }

        $transaksi   = $query->paginate(20)->withQueryString();
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();

        // ── Summary stats (dari seluruh data, bukan yang difilter) ──────────
        $totalMasuk  = Keuangan::where('jenis', 'masuk')->sum('jumlah');
        $totalKeluar = Keuangan::where('jenis', 'keluar')->sum('jumlah');
        $saldo       = $totalMasuk - $totalKeluar;

        // Summary bulan ini
        $bulanIni        = now()->month;
        $tahunIni        = now()->year;
        $masukBulanIni   = Keuangan::where('jenis', 'masuk')
                               ->whereMonth('tanggal_transaksi', $bulanIni)
                               ->whereYear('tanggal_transaksi', $tahunIni)
                               ->sum('jumlah');
        $keluarBulanIni  = Keuangan::where('jenis', 'keluar')
                               ->whereMonth('tanggal_transaksi', $bulanIni)
                               ->whereYear('tanggal_transaksi', $tahunIni)
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
        $rules = [
            'jenis'              => 'required|in:masuk,keluar',
            'jumlah'             => 'required|numeric|min:1',
            'keterangan'         => 'nullable|string|max:255',
            'tanggal_transaksi'  => 'required|date',
            'program_kerja_id'   => 'nullable|exists:program_kerja,id',
        ];

        // Kalau keluar, program kerja dianjurkan tapi tidak wajib
        $validated = $request->validate($rules);
        $validated['user_id'] = auth()->id();

        Keuangan::create($validated);

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
        $validated = $request->validate([
            'jenis'             => 'required|in:masuk,keluar',
            'jumlah'            => 'required|numeric|min:1',
            'keterangan'        => 'nullable|string|max:255',
            'tanggal_transaksi' => 'required|date',
            'program_kerja_id'  => 'nullable|exists:program_kerja,id',
        ]);

        $keuangan->update($validated);

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
