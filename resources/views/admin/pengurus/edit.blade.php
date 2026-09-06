@extends('layouts.admin')
@section('title', 'Edit Pengurus')
@section('page-title', 'Data Pengurus')
@section('page-subtitle', 'Edit')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.pengurus.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-navy mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar
    </a>

    <form method="POST" action="{{ route('admin.pengurus.update', ['pengurus' => $pengurus->id]) }}">
        @csrf
        @method('PUT')

        {{-- Data Pribadi --}}
        <div class="glass-card p-6 space-y-4">
            <h3 class="font-bold text-navy text-sm border-b border-slate-100 pb-3">Data Pengurus</h3>

            <div class="grid sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-red">*</span>
                    </label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $pengurus->nama) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all @error('nama') border-red @enderror">
                    @error('nama') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Jabatan <span class="text-red">*</span>
                    </label>
                    <input type="text" name="jabatan"
                           value="{{ old('jabatan', $pengurus->jabatan) }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all @error('jabatan') border-red @enderror">
                    @error('jabatan') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Kontak</label>
                    <input type="text" name="kontak"
                           value="{{ old('kontak', $pengurus->kontak) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Kementerian
                    </label>
                    <select name="kementerian_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                   focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                        <option value="">— Tanpa Kementerian —</option>
                        @foreach ($kementerian as $k)
                        <option value="{{ $k->id }}"
                            {{ old('kementerian_id', $pengurus->kementerian_id) == $k->id ? 'selected' : '' }}>
                            {{ $k->kode }} — {{ $k->nama_kementerian }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Akun Login --}}
        <div class="glass-card p-6">
            <div class="border-b border-slate-100 pb-3 mb-4">
                <h3 class="font-bold text-navy text-sm">Akun Login</h3>
                <p class="text-xs text-slate-400 mt-0.5">Email tidak dapat diubah di sini.</p>
            </div>
            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl mb-4">
                <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span class="text-sm text-slate-600">{{ $pengurus->user->email }}</span>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Hak Akses (Role) <span class="text-red">*</span>
                </label>
                <select name="role" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                               focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                    <option value="kementerian" {{ old('role', $pengurus->user->role) === 'kementerian' ? 'selected' : '' }}>
                        Kementerian — Pengurus biasa
                    </option>
                    <option value="sekretaris" {{ old('role', $pengurus->user->role) === 'sekretaris' ? 'selected' : '' }}>
                        Sekretaris — Akses data pengurus & program kerja
                    </option>
                    <option value="bendahara" {{ old('role', $pengurus->user->role) === 'bendahara' ? 'selected' : '' }}>
                        Bendahara — Akses keuangan
                    </option>
                    <option value="super_admin" {{ old('role', $pengurus->user->role) === 'super_admin' ? 'selected' : '' }}>
                        Admin — Akses penuh (Presiden/Wapres)
                    </option>
                </select>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Simpan Perubahan</button>
            <a href="{{ route('admin.pengurus.index') }}"
               class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-500
                      border border-slate-200 hover:bg-slate-50 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
