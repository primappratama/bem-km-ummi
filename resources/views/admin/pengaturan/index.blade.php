@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Akun')

@section('content')

<div class="max-w-xl space-y-6">

    {{-- Profil Akun --}}
    <div class="glass-card p-6">
        <h3 class="text-sm font-bold text-navy mb-4">Informasi Akun</h3>

        <form method="POST" action="{{ route('admin.pengaturan.profil') }}" class="space-y-4">
            @csrf @method('PATCH')

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Nama Lengkap
                </label>
                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                              @error('name') border-red @enderror">
                @error('name') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>

            {{-- Username --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Username <span class="text-red">*</span>
                </label>
                <input type="text" name="username" value="{{ old('username', auth()->user()->username) }}" required
                       placeholder="contoh: admin_bem"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              font-mono focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                              @error('username') border-red @enderror">
                <p class="mt-1 text-xs text-slate-400">Digunakan untuk login. Hanya huruf, angka, strip, dan garis bawah.</p>
                @error('username') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>

            {{-- Email (readonly) --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Email
                </label>
                <input type="email" value="{{ auth()->user()->email }}" disabled
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-sm text-slate-400 cursor-not-allowed">
                <p class="mt-1 text-xs text-slate-400">Email tidak dapat diubah.</p>
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Role
                </label>
                <input type="text" value="{{ auth()->user()->role_label }}" disabled
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-100 bg-slate-50 text-sm text-slate-400 cursor-not-allowed">
            </div>

            <button type="submit" class="btn-primary">Simpan Perubahan</button>
        </form>
    </div>

    {{-- Ganti Password --}}
    <div class="glass-card p-6">
        <h3 class="text-sm font-bold text-navy mb-4">Ganti Password</h3>

        @if (session('success_password'))
        <div class="mb-4 flex items-center gap-2.5 px-4 py-3 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success_password') }}
        </div>
        @endif

        <form method="POST" action="{{ route('admin.pengaturan.password') }}" class="space-y-4">
            @csrf @method('PATCH')

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Password Saat Ini <span class="text-red">*</span>
                </label>
                <input type="password" name="current_password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                              @error('current_password') border-red @enderror">
                @error('current_password')
                <p class="mt-1 text-xs text-red">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Password Baru <span class="text-red">*</span>
                </label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                              @error('password') border-red @enderror">
                @error('password')
                <p class="mt-1 text-xs text-red">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-slate-400">Minimal 8 karakter.</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Konfirmasi Password Baru <span class="text-red">*</span>
                </label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            </div>

            <button type="submit" class="btn-primary">Ganti Password</button>
        </form>
    </div>

</div>

@endsection
