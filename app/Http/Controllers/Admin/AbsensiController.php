<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Pengurus;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absensi::with(['pengurus', 'programKerja'])
            ->orderBy('tanggal', 'desc');

        if ($request->filled('program_kerja_id')) {
            $query->where('program_kerja_id', $request->program_kerja_id);
        }

        if ($request->filled('pengurus_id')) {
            $query->where('pengurus_id', $request->pengurus_id);
        }

        if ($request->filled('status')) {
            $query->where('status_kehadiran', $request->status);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $absensi      = $query->paginate(20)->withQueryString();
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();
        $pengurus     = Pengurus::orderBy('nama')->get();

        // Rekap stats
        $stats = [
            'hadir' => Absensi::where('status_kehadiran', 'hadir')->count(),
            'izin'  => Absensi::where('status_kehadiran', 'izin')->count(),
            'alfa'  => Absensi::where('status_kehadiran', 'alfa')->count(),
            'total' => Absensi::count(),
        ];

        return view('admin.absensi.index', compact(
            'absensi', 'programKerja', 'pengurus', 'stats'
        ));
    }

    public function create()
    {
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();
        $pengurus     = Pengurus::orderBy('nama')->get();
        return view('admin.absensi.create', compact('programKerja', 'pengurus'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengurus_id'      => 'required|exists:pengurus,id',
            'program_kerja_id' => 'required|exists:program_kerja,id',
            'tanggal'          => 'required|date',
            'status_kehadiran' => 'required|in:hadir,izin,alfa',
        ]);

        // Prevent duplicate
        $exists = Absensi::where('pengurus_id', $validated['pengurus_id'])
            ->where('program_kerja_id', $validated['program_kerja_id'])
            ->where('tanggal', $validated['tanggal'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['pengurus_id' => 'Absensi untuk pengurus ini pada kegiatan dan tanggal yang sama sudah tercatat.'])->withInput();
        }

        Absensi::create($validated);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil dicatat.');
    }

    public function edit(Absensi $absensi)
    {
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();
        $pengurus     = Pengurus::orderBy('nama')->get();
        return view('admin.absensi.edit', compact('absensi', 'programKerja', 'pengurus'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $validated = $request->validate([
            'pengurus_id'      => 'required|exists:pengurus,id',
            'program_kerja_id' => 'required|exists:program_kerja,id',
            'tanggal'          => 'required|date',
            'status_kehadiran' => 'required|in:hadir,izin,alfa',
        ]);

        $absensi->update($validated);

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Absensi berhasil diperbarui.');
    }

    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return back()->with('success', 'Absensi berhasil dihapus.');
    }
}
