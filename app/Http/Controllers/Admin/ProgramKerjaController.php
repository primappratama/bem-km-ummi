<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kementerian;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;

class ProgramKerjaController extends Controller
{
    /**
     * Ambil kementerian_id dari user yang sedang login.
     * Hanya relevan untuk role 'kementerian'.
     */
    private function getUserKementerianId(): ?int
    {
        return auth()->user()->pengurus?->kementerian_id;
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        $query = ProgramKerja::with('kementerian')
            ->withSum(
                ['keuangan as realisasi' => fn ($q) => $q->where('jenis', 'keluar')],
                'jumlah'
            );

        // ── Role-based scope ────────────────────────────────────────────────
        if ($user->isKementerian()) {
            $kemenId = $this->getUserKementerianId();

            // Pengurus belum di-assign ke kementerian
            if (! $kemenId) {
                return view('admin.program-kerja.index', [
                    'programKerja' => ProgramKerja::query()->paginate(0),
                    'kementerian'  => collect(),
                    'noKemen'      => true,
                ]);
            }

            $query->where('kementerian_id', $kemenId);
        }

        // ── Filters ─────────────────────────────────────────────────────────
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter kementerian hanya untuk admin/sekretaris
        if ($request->filled('kementerian_id') && ! $user->isKementerian()) {
            $query->where('kementerian_id', $request->kementerian_id);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where('nama_kegiatan', 'like', "%{$s}%");
        }

        $programKerja = $query->orderBy('tanggal_pelaksanaan', 'desc')
                               ->paginate(15)
                               ->withQueryString();

        $kementerian = Kementerian::orderBy('kode')->get();

        return view('admin.program-kerja.index', compact('programKerja', 'kementerian'));
    }

    public function create()
    {
        $user        = auth()->user();
        $kementerian = Kementerian::orderBy('kode')->get();

        // Untuk role kementerian, pre-select kementerian mereka
        $defaultKemenId = $user->isKementerian()
            ? $this->getUserKementerianId()
            : null;

        return view('admin.program-kerja.create', compact('kementerian', 'defaultKemenId'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'nama_kegiatan'       => 'required|string|max:150',
            'kementerian_id'      => 'required|exists:kementerian,id',
            'tanggal_pelaksanaan' => 'required|date',
            'anggaran'            => 'required|numeric|min:0',
            'status'              => 'required|in:rencana,berjalan,selesai',
        ]);

        // Paksa kementerian_id sesuai role
        if ($user->isKementerian()) {
            $validated['kementerian_id'] = $this->getUserKementerianId();
        }

        $proker = ProgramKerja::create($validated);

        return redirect()->route('admin.program-kerja.index')
            ->with('success', "Program Kerja \"{$proker->nama_kegiatan}\" berhasil ditambahkan.");
    }

    public function show(ProgramKerja $programKerja)
    {
        $this->authorizeKementerian($programKerja);

        $programKerja->load('kementerian');
        $programKerja->loadSum(
            ['keuangan as realisasi' => fn ($q) => $q->where('jenis', 'keluar')],
            'jumlah'
        );

        // Riwayat transaksi terkait
        $transaksi = $programKerja->keuangan()
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        // Absensi peserta
        $absensi = $programKerja->absensi()
            ->with('pengurus')
            ->orderBy('tanggal')
            ->get();

        return view('admin.program-kerja.show',
            compact('programKerja', 'transaksi', 'absensi'));
    }

    public function edit(ProgramKerja $programKerja)
    {
        $this->authorizeKementerian($programKerja);

        $kementerian = Kementerian::orderBy('kode')->get();
        return view('admin.program-kerja.edit', compact('programKerja', 'kementerian'));
    }

    public function update(Request $request, ProgramKerja $programKerja)
    {
        $this->authorizeKementerian($programKerja);

        $user = auth()->user();

        $validated = $request->validate([
            'nama_kegiatan'       => 'required|string|max:150',
            'kementerian_id'      => 'required|exists:kementerian,id',
            'tanggal_pelaksanaan' => 'required|date',
            'anggaran'            => 'required|numeric|min:0',
            'status'              => 'required|in:rencana,berjalan,selesai',
        ]);

        if ($user->isKementerian()) {
            $validated['kementerian_id'] = $this->getUserKementerianId();
        }

        $programKerja->update($validated);

        return redirect()->route('admin.program-kerja.index')
            ->with('success', "Program Kerja \"{$programKerja->nama_kegiatan}\" berhasil diperbarui.");
    }

    public function destroy(ProgramKerja $programKerja)
    {
        $this->authorizeKementerian($programKerja);

        $nama = $programKerja->nama_kegiatan;
        $programKerja->delete();

        return redirect()->route('admin.program-kerja.index')
            ->with('success', "Program Kerja \"{$nama}\" berhasil dihapus.");
    }

    // ─── Guard: kementerian hanya bisa akses milik sendiri ────────────────────
    private function authorizeKementerian(ProgramKerja $proker): void
    {
        $user = auth()->user();
        if ($user->isKementerian()) {
            $kemenId = $this->getUserKementerianId();
            abort_if($proker->kementerian_id !== $kemenId, 403,
                'Anda tidak memiliki akses ke program kerja ini.');
        }
    }
}
