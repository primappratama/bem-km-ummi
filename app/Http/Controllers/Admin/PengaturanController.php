<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('admin.pengaturan.index');
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:150',
            'username' => ['required','string','max:50','alpha_dash',
                           Rule::unique('users', 'username')->ignore(Auth::id())],
        ], [
            'username.alpha_dash' => 'Username hanya boleh huruf, angka, strip (-), dan garis bawah (_).',
            'username.unique'     => 'Username sudah dipakai pengguna lain.',
        ]);

        Auth::user()->update([
            'name'     => $request->name,
            'username' => strtolower($request->username),
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'      => 'required|string',
            'password'              => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string',
        ], [
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min'       => 'Password baru minimal 8 karakter.',
        ]);

        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.'])->withInput();
        }

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success_password', 'Password berhasil diperbarui.');
    }
}
