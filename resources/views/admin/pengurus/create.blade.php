@extends('layouts.admin')
@section('title', 'Tambah Pengurus')
@section('page-title', 'Data Pengurus')
@section('page-subtitle', 'Tambah')

@section('content')

<div class="max-w-2xl">
    <a href="{{ route('admin.pengurus.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-navy mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar
    </a>

    <form method="POST" action="{{ route('admin.pengurus.store') }}" class="space-y-5">
        @csrf

        {{-- Data Pribadi --}}
        <div class="glass-card p-6 space-y-4">
            <h3 class="font-bold text-navy text-sm border-b border-slate-100 pb-3">Data Pengurus</h3>

            <div class="grid sm:grid-cols-2 gap-4">
                {{-- Nama --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Nama Lengkap <span class="text-red">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all @error('nama') border-red @enderror"
                           placeholder="Nama lengkap pengurus">
                    @error('nama') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
                </div>

                {{-- Jabatan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Jabatan <span class="text-red">*</span>
                    </label>
                    <input type="text" name="jabatan" value="{{ old('jabatan') }}" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all @error('jabatan') border-red @enderror"
                           placeholder="Contoh: Menteri, Staf Ahli">
                    @error('jabatan') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
                </div>

                {{-- Kontak --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Kontak
                    </label>
                    <input type="text" name="kontak" value="{{ old('kontak') }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all"
                           placeholder="Nomor WhatsApp / telepon">
                </div>

                {{-- Kementerian --}}
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Kementerian
                    </label>
                    <select name="kementerian_id"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                   focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                        <option value="">— Pilih Kementerian —</option>
                        @foreach ($kementerian as $k)
                        <option value="{{ $k->id }}" {{ old('kementerian_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->kode }} — {{ $k->nama_kementerian }}
                        </option>
                        @endforeach
                    </select>
                    @error('kementerian_id') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Akun Login --}}
        <div class="glass-card p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-bold text-navy text-sm">Akun Login</h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    Pengurus akan menggunakan email ini untuk masuk ke panel admin.
                </p>
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Email <span class="text-red">*</span>
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                              transition-all @error('email') border-red @enderror"
                       placeholder="email@bemkm.ac.id">
                @error('email') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-4">
                {{-- Password --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Password <span class="text-red">*</span>
                    </label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all @error('password') border-red @enderror"
                           placeholder="Min. 8 karakter">
                    @error('password') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
                </div>

                {{-- Konfirmasi --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                        Konfirmasi Password <span class="text-red">*</span>
                    </label>
                    <input type="password" name="password_confirmation" required
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                  focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                  transition-all"
                           placeholder="Ulangi password">
                </div>
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Hak Akses (Role) <span class="text-red">*</span>
                </label>
                <select name="role" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                               focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                               @error('role') border-red @enderror">
                    <option value="">— Pilih Role —</option>
                    <option value="kementerian" {{ old('role','kementerian') === 'kementerian' ? 'selected' : '' }}>
                        Kementerian — Pengurus biasa
                    </option>
                    <option value="sekretaris" {{ old('role') === 'sekretaris' ? 'selected' : '' }}>
                        Sekretaris — Akses data pengurus & program kerja
                    </option>
                    <option value="bendahara" {{ old('role') === 'bendahara' ? 'selected' : '' }}>
                        Bendahara — Akses keuangan
                    </option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>
                        Admin — Akses penuh (Presiden/Wapres)
                    </option>
                </select>
                @error('role') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Submit --}}
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Simpan Pengurus</button>
            <a href="{{ route('admin.pengurus.index') }}"
               class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-500
                      border border-slate-200 hover:bg-slate-50 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
