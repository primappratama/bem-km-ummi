@extends('layouts.admin')
@section('title', 'Edit Kementerian')
@section('page-title', 'Kementerian')
@section('page-subtitle', 'Edit')

@section('content')

<div class="max-w-xl">
    <a href="{{ route('admin.kementerian.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-navy mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>

    <div class="glass-card p-6">
        <div class="mb-5 pb-5 border-b border-slate-100">
            <span class="text-[10px] font-mono-data font-bold uppercase tracking-wider
                         text-navy bg-navy/8 px-2.5 py-1 rounded-lg">
                {{ $kementerian->kode }}
            </span>
            <h2 class="font-extrabold text-navy mt-2">{{ $kementerian->nama_kementerian }}</h2>
            <p class="text-xs text-slate-400 mt-0.5">Kode tidak dapat diubah.</p>
        </div>

        <form method="POST" action="{{ route('admin.kementerian.update', $kementerian) }}"
              class="space-y-4">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Nama Kementerian
                </label>
                <input type="text" name="nama_kementerian"
                       value="{{ old('nama_kementerian', $kementerian->nama_kementerian) }}"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                              transition-all @error('nama_kementerian') border-red @enderror">
                @error('nama_kementerian')
                    <p class="mt-1 text-xs text-red">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Deskripsi
                </label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                                 focus:outline-none focus:ring-2 focus:ring-navy/20 focus:border-navy/30
                                 transition-all resize-none @error('deskripsi') border-red @enderror"
                          placeholder="Deskripsi singkat tugas dan fungsi kementerian...">{{ old('deskripsi', $kementerian->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="mt-1 text-xs text-red">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
                <a href="{{ route('admin.kementerian.index') }}"
                   class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-500
                          border border-slate-200 hover:bg-slate-50 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
