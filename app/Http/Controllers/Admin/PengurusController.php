<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kementerian;
use App\Models\Pengurus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengurus::with(['kementerian', 'user']);

        // Filter by kementerian
        if ($request->filled('kementerian_id')) {
            $query->where('kementerian_id', $request->kementerian_id);
        }

        // Search by nama / jabatan
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($query) use ($q) {
                $query->where('nama', 'like', "%{$q}%")
                      ->orWhere('jabatan', 'like', "%{$q}%");
            });
        }

        $pengurus    = $query->orderBy('nama')->paginate(15)->withQueryString();
        $kementerian = Kementerian::orderBy('kode')->get();

        return view('admin.pengurus.index', compact('pengurus', 'kementerian'));
    }

    public function create()
    {
        $kementerian = Kementerian::orderBy('kode')->get();
        return view('admin.pengurus.create', compact('kementerian'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required|string|max:150',
            'jabatan'        => 'required|string|max:100',
            'kontak'         => 'nullable|string|max:50',
            'kementerian_id' => 'nullable|exists:kementerian,id',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8|confirmed',
            'role'           => 'required|in:super_admin,sekretaris,bendahara,kementerian',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat user login
            $user = User::create([
                'name'     => $request->nama,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
            ]);

            // 2. Buat data pengurus
            Pengurus::create([
                'user_id'        => $user->id,
                'kementerian_id' => $request->kementerian_id ?: null,
                'nama'           => $request->nama,
                'jabatan'        => $request->jabatan,
                'kontak'         => $request->kontak,
            ]);
        });

        return redirect()->route('admin.pengurus.index')
            ->with('success', "Pengurus {$request->nama} berhasil ditambahkan.");
    }

    public function edit(Pengurus $pengurus)
    {
        $kementerian = Kementerian::orderBy('kode')->get();
        return view('admin.pengurus.edit', compact('pengurus', 'kementerian'));
    }

    public function update(Request $request, Pengurus $pengurus)
    {
        $request->validate([
            'nama'           => 'required|string|max:150',
            'jabatan'        => 'required|string|max:100',
            'kontak'         => 'nullable|string|max:50',
            'kementerian_id' => 'nullable|exists:kementerian,id',
            'role'           => 'required|in:super_admin,sekretaris,bendahara,kementerian',
        ]);

        DB::transaction(function () use ($request, $pengurus) {
            // Update user role + name
            $pengurus->user->update([
                'name' => $request->nama,
                'role' => $request->role,
            ]);

            // Update pengurus
            $pengurus->update([
                'kementerian_id' => $request->kementerian_id ?: null,
                'nama'           => $request->nama,
                'jabatan'        => $request->jabatan,
                'kontak'         => $request->kontak,
            ]);
        });

        return redirect()->route('admin.pengurus.index')
            ->with('success', "Data {$pengurus->nama} berhasil diperbarui.");
    }

    public function destroy(Pengurus $pengurus)
    {
        $nama = $pengurus->nama;
        DB::transaction(function () use ($pengurus) {
            $user = $pengurus->user;
            $pengurus->delete();      // hapus pengurus dulu (FK constraint)
            $user?->delete();         // hapus user login-nya juga
        });

        return redirect()->route('admin.pengurus.index')
            ->with('success', "Pengurus {$nama} berhasil dihapus.");
    }
}
