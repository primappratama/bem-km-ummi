<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use Illuminate\Http\Request;

class AspirasiPublikController extends Controller
{
    public function create()
    {
        return view('public.aspirasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'         => 'nullable|string|max:150',
            'fakultas'     => 'nullable|string|max:150',
            'isi_aspirasi' => 'required|string|min:10|max:2000',
        ], [
            'isi_aspirasi.required' => 'Isi aspirasi tidak boleh kosong.',
            'isi_aspirasi.min'      => 'Isi aspirasi minimal 10 karakter.',
        ]);

        Aspirasi::create([
            'nama'                 => $request->nama,
            'fakultas'             => $request->fakultas,
            'isi_aspirasi'         => $request->isi_aspirasi,
            'tanggal'              => now()->toDateString(),
            'status_tindak_lanjut' => 'belum_ditindaklanjuti',
        ]);

        return back()->with('success', 'Aspirasi berhasil terkirim. Terima kasih atas masukan Anda!');
    }
}
