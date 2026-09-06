<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kementerian;
use Illuminate\Http\Request;

class KementerianController extends Controller
{
    public function index()
    {
        $kementerian = Kementerian::withCount('pengurus')->orderBy('kode')->get();
        return view('admin.kementerian.index', compact('kementerian'));
    }

    public function edit(Kementerian $kementerian)
    {
        return view('admin.kementerian.edit', compact('kementerian'));
    }

    public function update(Request $request, Kementerian $kementerian)
    {
        $validated = $request->validate([
            'nama_kementerian' => 'required|string|max:150',
            'deskripsi'        => 'nullable|string',
        ]);

        $kementerian->update($validated);

        return redirect()->route('admin.kementerian.index')
            ->with('success', 'Kementerian berhasil diperbarui.');
    }
}
