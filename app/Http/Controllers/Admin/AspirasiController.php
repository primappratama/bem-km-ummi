<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Aspirasi::orderBy('tanggal', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('status_tindak_lanjut', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('fakultas', 'like', '%' . $request->search . '%')
                ->orWhere('isi_aspirasi', 'like', '%' . $request->search . '%');
            });
        }

        $aspirasi = $query->paginate(15)->withQueryString();

        $stats = [
            'belum' => Aspirasi::where('status_tindak_lanjut', 'belum_ditindaklanjuti')->count(),
            'proses' => Aspirasi::where('status_tindak_lanjut', 'diproses')->count(),
            'selesai' => Aspirasi::where('status_tindak_lanjut', 'selesai')->count(),
            'total'  => Aspirasi::count(),
        ];

        return view('admin.aspirasi.index', compact('aspirasi', 'stats'));
    }

    public function updateStatus(Request $request, Aspirasi $aspirasi)
    {
        $request->validate([
            'status_tindak_lanjut' => 'required|in:belum_ditindaklanjuti,diproses,selesai',
        ]);

        $aspirasi->update([
            'status_tindak_lanjut' => $request->status_tindak_lanjut,
        ]);

        return back()->with('success', 'Status aspirasi berhasil diperbarui.');
    }

    public function destroy(Aspirasi $aspirasi)
    {
        $aspirasi->delete();
        return back()->with('success', 'Aspirasi berhasil dihapus.');
    }
}
