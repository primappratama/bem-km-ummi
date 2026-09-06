@extends('layouts.admin')
@section('title', 'Dokumen LPJ')
@section('page-title', 'Dokumen LPJ')

@section('content')

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row gap-3 mb-5">
    <form method="GET" action="{{ route('admin.dokumen.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">

        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari judul dokumen..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">

        <select name="program_kerja_id"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Program Kerja</option>
            @foreach ($programKerja as $p)
            <option value="{{ $p->id }}" {{ request('program_kerja_id') == $p->id ? 'selected' : '' }}>
                {{ Str::limit($p->nama_kegiatan, 35) }}
            </option>
            @endforeach
        </select>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
                       hover:bg-navy/90 transition-colors">
            Filter
        </button>

        @if (request()->hasAny(['search','program_kerja_id']))
        <a href="{{ route('admin.dokumen.index') }}"
           class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                  hover:bg-slate-50 transition-colors text-center">
            Reset
        </a>
        @endif
    </form>

    <a href="{{ route('admin.dokumen.create') }}" class="btn-primary shrink-0">
        + Unggah Dokumen
    </a>
</div>

{{-- Grid --}}
@if ($dokumen->isEmpty())
<div class="glass-card py-16 text-center">
    <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
    </svg>
    <p class="text-sm text-slate-400 font-medium">Belum ada dokumen LPJ</p>
    <p class="text-xs text-slate-300 mt-1">Unggah dokumen pertama menggunakan tombol di atas.</p>
</div>
@else
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($dokumen as $d)
    <div class="glass-card p-5 flex flex-col gap-3">
        {{-- File type badge --}}
        <div class="flex items-start justify-between gap-2">
            <div class="w-10 h-10 rounded-xl bg-navy/10 flex items-center justify-center shrink-0">
                <span class="text-[10px] font-black text-navy">{{ $d->file_ext }}</span>
            </div>
            <div class="flex gap-1">
                <a href="{{ route('admin.dokumen.download', $d) }}"
                   class="p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-navy/8 transition-colors"
                   title="Unduh">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
                <form method="POST" action="{{ route('admin.dokumen.destroy', $d) }}"
                      onsubmit="return confirm('Hapus dokumen ini? File akan ikut terhapus.')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-red hover:bg-red/8 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1">
            <p class="font-semibold text-navy text-sm leading-snug">{{ $d->judul }}</p>
            @if ($d->keterangan)
            <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $d->keterangan }}</p>
            @endif
        </div>

        <div class="border-t border-slate-100 pt-3 flex items-center justify-between">
            <div>
                @if ($d->programKerja)
                <p class="text-[10px] font-semibold text-navy bg-navy/8 px-2 py-0.5 rounded-md inline-block">
                    {{ Str::limit($d->programKerja->nama_kegiatan, 25) }}
                </p>
                @else
                <span class="text-xs text-slate-300">Umum</span>
                @endif
            </div>
            <div class="text-right">
                <p class="text-[10px] text-slate-400">{{ $d->created_at->translatedFormat('d M Y') }}</p>
                <p class="text-[10px] text-slate-300">{{ $d->user->name ?? '—' }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if ($dokumen->hasPages())
<div class="mt-4">
    {{ $dokumen->links() }}
</div>
@endif

<p class="text-xs text-slate-400 mt-3">
    Menampilkan {{ $dokumen->count() }} dari {{ $dokumen->total() }} dokumen
</p>
@endif

@endsection
