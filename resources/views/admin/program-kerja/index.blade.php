@extends('layouts.admin')
@section('title', 'Program Kerja')
@section('page-title', 'Program Kerja')

@section('content')

@php $user = auth()->user(); @endphp

{{-- Warning: kementerian user belum di-assign --}}
@isset($noKemen)
<div class="mb-6 flex items-start gap-3 p-4 rounded-xl bg-orange/5 border border-orange/15">
    <svg class="w-5 h-5 text-orange shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
    </svg>
    <div>
        <p class="text-sm font-semibold text-orange">Akun belum terhubung ke kementerian</p>
        <p class="text-xs text-slate-500 mt-0.5">Minta admin untuk menambahkan data pengurus dan menghubungkan akun ini ke kementerian yang sesuai.</p>
    </div>
</div>
@endisset

{{-- Summary cards (admin + sekretaris) --}}
@if ($user->isAdmin() || $user->isSekretaris())
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
    @php
        $total    = $programKerja->total();
        $rencana  = \App\Models\ProgramKerja::where('status','rencana')->count();
        $berjalan = \App\Models\ProgramKerja::where('status','berjalan')->count();
        $selesai  = \App\Models\ProgramKerja::where('status','selesai')->count();
    @endphp
    <div class="glass-card px-4 py-3.5 flex items-center gap-3">
        <span class="text-2xl font-extrabold text-navy">{{ $total }}</span>
        <span class="text-xs text-slate-400 font-medium leading-tight">Total<br>Program</span>
    </div>
    <div class="glass-card px-4 py-3.5 flex items-center gap-3">
        <span class="text-2xl font-extrabold text-slate-400">{{ $rencana }}</span>
        <span class="text-xs text-slate-400 font-medium leading-tight">Masih<br>Rencana</span>
    </div>
    <div class="glass-card px-4 py-3.5 flex items-center gap-3">
        <span class="text-2xl font-extrabold text-orange">{{ $berjalan }}</span>
        <span class="text-xs text-slate-400 font-medium leading-tight">Sedang<br>Berjalan</span>
    </div>
    <div class="glass-card px-4 py-3.5 flex items-center gap-3">
        <span class="text-2xl font-extrabold text-green-600">{{ $selesai }}</span>
        <span class="text-xs text-slate-400 font-medium leading-tight">Sudah<br>Selesai</span>
    </div>
</div>
@endif

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-5">
    <form method="GET" action="{{ route('admin.program-kerja.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">

        {{-- Search --}}
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama kegiatan..."
               class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                      focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">

        {{-- Filter kementerian (admin/sekretaris only) --}}
        @if (! $user->isKementerian())
        <select name="kementerian_id"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Kementerian</option>
            @foreach ($kementerian as $k)
            <option value="{{ $k->id }}" {{ request('kementerian_id') == $k->id ? 'selected' : '' }}>
                {{ $k->kode }}
            </option>
            @endforeach
        </select>
        @endif

        {{-- Filter status --}}
        <select name="status"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Status</option>
            <option value="rencana"  {{ request('status') === 'rencana'  ? 'selected' : '' }}>Rencana</option>
            <option value="berjalan" {{ request('status') === 'berjalan' ? 'selected' : '' }}>Berjalan</option>
            <option value="selesai"  {{ request('status') === 'selesai'  ? 'selected' : '' }}>Selesai</option>
        </select>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
                       hover:bg-navy/90 transition-colors">
            Filter
        </button>
        @if (request()->hasAny(['search','kementerian_id','status']))
        <a href="{{ route('admin.program-kerja.index') }}"
           class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                  hover:bg-slate-50 transition-colors text-center">
            Reset
        </a>
        @endif
    </form>

    <a href="{{ route('admin.program-kerja.create') }}" class="btn-primary shrink-0">
        + Tambah Program
    </a>
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
    @if ($programKerja->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-sm text-slate-400 font-medium">Belum ada program kerja</p>
        <p class="text-xs text-slate-300 mt-1">Tambahkan program kerja pertama menggunakan tombol di atas.</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Kegiatan</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">Kementerian</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden sm:table-cell">Tanggal</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider hidden lg:table-cell">Anggaran</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider hidden lg:table-cell">Realisasi</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($programKerja as $p)
                @php
                    $realisasi = (float) ($p->realisasi ?? 0);
                    $anggaran  = (float) $p->anggaran;
                    $sisa      = $anggaran - $realisasi;
                    $pct       = $anggaran > 0 ? min(100, round(($realisasi / $anggaran) * 100)) : 0;
                @endphp
                <tr class="hover:bg-slate-50/60 transition-colors">
                    {{-- Nama kegiatan --}}
                    <td class="px-5 py-4">
                        <p class="font-semibold text-navy text-sm">{{ $p->nama_kegiatan }}</p>
                        {{-- Progress bar realisasi (mobile info) --}}
                        <div class="flex items-center gap-2 mt-1.5 lg:hidden">
                            <div class="flex-1 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $pct >= 100 ? 'bg-red' : 'bg-orange' }}"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $pct }}%</span>
                        </div>
                    </td>

                    {{-- Kementerian --}}
                    <td class="px-5 py-4 hidden md:table-cell">
                        @if ($p->kementerian)
                        <span class="inline-flex text-[10px] font-mono-data font-bold uppercase tracking-wider
                                     text-navy bg-navy/8 px-2 py-0.5 rounded-md">
                            {{ $p->kementerian->kode }}
                        </span>
                        @else
                        <span class="text-slate-300">—</span>
                        @endif
                    </td>

                    {{-- Tanggal --}}
                    <td class="px-5 py-4 text-slate-500 text-xs hidden sm:table-cell">
                        {{ $p->tanggal_pelaksanaan->translatedFormat('d M Y') }}
                    </td>

                    {{-- Anggaran --}}
                    <td class="px-5 py-4 text-right text-slate-600 text-xs font-mono-data hidden lg:table-cell">
                        Rp {{ number_format($anggaran, 0, ',', '.') }}
                    </td>

                    {{-- Realisasi + sisa --}}
                    <td class="px-5 py-4 text-right hidden lg:table-cell">
                        <p class="text-xs font-mono-data {{ $realisasi > $anggaran ? 'text-red' : 'text-slate-600' }}">
                            Rp {{ number_format($realisasi, 0, ',', '.') }}
                        </p>
                        <div class="flex items-center justify-end gap-1.5 mt-1">
                            <div class="w-16 h-1 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full rounded-full {{ $pct >= 100 ? 'bg-red' : 'bg-orange' }}"
                                     style="width: {{ $pct }}%"></div>
                            </div>
                            <span class="text-[10px] text-slate-400">{{ $pct }}%</span>
                        </div>
                    </td>

                    {{-- Status --}}
                    <td class="px-5 py-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold {{ $p->status_color }}">
                            {{ $p->status_label }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td class="px-5 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.program-kerja.show', $p) }}"
                               class="p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-navy/8 transition-colors"
                               title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.program-kerja.edit', $p) }}"
                               class="p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-navy/8 transition-colors"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            @if ($user->isAdmin() || $user->isSekretaris())
                            <form method="POST" action="{{ route('admin.program-kerja.destroy', $p) }}"
                                  onsubmit="return confirm('Hapus program kerja ini? Data absensi dan keuangan yang terkait mungkin terpengaruh.')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg text-slate-400 hover:text-red hover:bg-red/8 transition-colors"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($programKerja->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $programKerja->links() }}
    </div>
    @endif
    @endif
</div>

<p class="text-xs text-slate-400 mt-3">
    Menampilkan {{ $programKerja->count() }} dari {{ $programKerja->total() }} program kerja
</p>

@endsection
