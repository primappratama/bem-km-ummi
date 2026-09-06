@extends('layouts.admin')
@section('title', 'Unggah Dokumen LPJ')
@section('page-title', 'Dokumen LPJ')
@section('page-subtitle', 'Unggah Dokumen')

@section('content')
<div class="max-w-xl">
    <a href="{{ route('admin.dokumen.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-navy mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali
    </a>

    <form method="POST" action="{{ route('admin.dokumen.store') }}"
          enctype="multipart/form-data" class="space-y-5">
        @csrf

        <div class="glass-card p-6 space-y-5">

            {{-- Judul --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Judul Dokumen <span class="text-red">*</span>
                </label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                       placeholder="Contoh: LPJ SEKATIF 2026"
                       class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                              focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all
                              @error('judul') border-red @enderror">
                @error('judul') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>

            {{-- Program Kerja --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Program Kerja <span class="text-slate-300 font-normal">(opsional)</span>
                </label>
                <select name="program_kerja_id"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                               focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                    <option value="">— Dokumen Umum —</option>
                    @foreach ($programKerja as $p)
                    <option value="{{ $p->id }}" {{ old('program_kerja_id') == $p->id ? 'selected' : '' }}>
                        {{ $p->nama_kegiatan }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    Keterangan <span class="text-slate-300 font-normal">(opsional)</span>
                </label>
                <textarea name="keterangan" rows="3"
                          placeholder="Deskripsi singkat isi dokumen..."
                          class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm resize-none
                                 focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">{{ old('keterangan') }}</textarea>
            </div>

            {{-- File upload --}}
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">
                    File Dokumen <span class="text-red">*</span>
                </label>
                <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip"
                       class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4
                              file:rounded-xl file:border-0 file:text-sm file:font-semibold
                              file:bg-navy file:text-white hover:file:bg-navy/90
                              @error('file') border-red @enderror">
                <p class="mt-1.5 text-xs text-slate-400">
                    Format: PDF, Word, Excel, PowerPoint, ZIP. Maksimal 10MB.
                </p>
                @error('file') <p class="mt-1 text-xs text-red">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Unggah Dokumen</button>
            <a href="{{ route('admin.dokumen.index') }}"
               class="px-5 py-2.5 rounded-full text-sm font-semibold text-slate-500
                      border border-slate-200 hover:bg-slate-50 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
