<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profil;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function index()
    {
        $visi      = Profil::get('visi');
        $deskripsi = Profil::get('deskripsi');
        $misi      = Profil::getMisi();

        return view('admin.profil.index', compact('visi', 'deskripsi', 'misi'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'visi'      => 'required|string|max:500',
            'deskripsi' => 'nullable|string|max:500',
            'misi'      => 'nullable|array',
            'misi.*'    => 'nullable|string|max:300',
        ]);

        Profil::set('visi', $request->visi);
        Profil::set('deskripsi', $request->deskripsi ?? '');

        // Filter misi — buang yang kosong
        $misiList = collect($request->misi ?? [])
            ->filter(fn($m) => trim($m) !== '')
            ->values()
            ->all();

        Profil::set('misi', json_encode($misiList));

        return back()->with('success', 'Profil publik berhasil diperbarui.');
    }
}
