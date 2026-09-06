<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenLpj;
use App\Models\ProgramKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenLpjController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenLpj::with(['user', 'programKerja'])
            ->orderBy('created_at', 'desc');

        if ($request->filled('program_kerja_id')) {
            $query->where('program_kerja_id', $request->program_kerja_id);
        }

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%');
        }

        $dokumen      = $query->paginate(15)->withQueryString();
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();

        return view('admin.dokumen.index', compact('dokumen', 'programKerja'));
    }

    public function create()
    {
        $programKerja = ProgramKerja::orderBy('nama_kegiatan')->get();
        return view('admin.dokumen.create', compact('programKerja'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'            => 'required|string|max:255',
            'program_kerja_id' => 'nullable|exists:program_kerja,id',
            'keterangan'       => 'nullable|string|max:500',
            'file'             => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip|max:10240',
        ], [
            'file.mimes' => 'Format file tidak didukung. Gunakan PDF, Word, Excel, PowerPoint, atau ZIP.',
            'file.max'   => 'Ukuran file maksimal 10MB.',
        ]);

        $path = $request->file('file')->store('dokumen-lpj', 'public');

        DokumenLpj::create([
            'user_id'          => auth()->id(),
            'program_kerja_id' => $request->program_kerja_id ?: null,
            'judul'            => $request->judul,
            'file_path'        => $path,
            'keterangan'       => $request->keterangan,
        ]);

        return redirect()->route('admin.dokumen.index')
            ->with('success', 'Dokumen berhasil diunggah.');
    }

    public function destroy(DokumenLpj $dokumen)
    {
        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(DokumenLpj $dokumen)
    {
        return Storage::disk('public')->download($dokumen->file_path, $dokumen->judul);
    }
}
