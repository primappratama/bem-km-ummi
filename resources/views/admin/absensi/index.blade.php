@extends('layouts.admin')
@section('title', 'Absensi Pengurus')
@section('page-title', 'Absensi Pengurus')

@section('content')

{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Total Catatan</p>
        <p class="text-2xl font-extrabold text-navy">{{ $stats['total'] }}</p>
    </div>
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Hadir</p>
        <p class="text-2xl font-extrabold text-green-600">{{ $stats['hadir'] }}</p>
    </div>
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Izin</p>
        <p class="text-2xl font-extrabold text-amber-600">{{ $stats['izin'] }}</p>
    </div>
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1.5">Alfa</p>
        <p class="text-2xl font-extrabold text-red">{{ $stats['alfa'] }}</p>
    </div>
</div>

{{-- Toolbar --}}
<div class="flex flex-col sm:flex-row gap-3 mb-5">
    <form method="GET" action="{{ route('admin.absensi.index') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">

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

        <select name="pengurus_id"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Pengurus</option>
            @foreach ($pengurus as $pg)
            <option value="{{ $pg->id }}" {{ request('pengurus_id') == $pg->id ? 'selected' : '' }}>
                {{ $pg->nama }}
            </option>
            @endforeach
        </select>

        <select name="status"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Status</option>
            <option value="hadir" {{ request('status') === 'hadir' ? 'selected' : '' }}>Hadir</option>
            <option value="izin"  {{ request('status') === 'izin'  ? 'selected' : '' }}>Izin</option>
            <option value="alfa"  {{ request('status') === 'alfa'  ? 'selected' : '' }}>Alfa</option>
        </select>

        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
                       hover:bg-navy/90 transition-colors">
            Filter
        </button>

        @if (request()->hasAny(['program_kerja_id','pengurus_id','status','bulan']))
        <a href="{{ route('admin.absensi.index') }}"
           class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                  hover:bg-slate-50 transition-colors text-center">
            Reset
        </a>
        @endif
    </form>

    <a href="{{ route('admin.absensi.rekap') }}"
       class="inline-flex items-center gap-2 px-4 py-2.5 rounded-full text-sm font-semibold
              border border-slate-200 text-slate-600 hover:bg-slate-50 transition-colors shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
        Rekap
    </a>
    <a href="{{ route('admin.absensi.create') }}" class="btn-primary shrink-0">
        + Catat Absensi
    </a>
</div>

{{-- Table --}}
<div class="glass-card overflow-hidden">
    @if ($absensi->isEmpty())
    <div class="py-16 text-center">
        <svg class="w-10 h-10 text-slate-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-sm text-slate-400 font-medium">Belum ada catatan absensi</p>
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Pengurus</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">Program Kerja</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3.5 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach ($absensi as $a)
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4">
                        <p class="font-semibold text-navy text-sm">{{ $a->pengurus->nama ?? '—' }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $a->pengurus->jabatan ?? '' }}</p>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        <p class="text-sm text-slate-600">{{ Str::limit($a->programKerja->nama_kegiatan ?? '—', 40) }}</p>
                    </td>
                    <td class="px-5 py-4 text-xs text-slate-500 whitespace-nowrap">
                        {{ $a->tanggal->translatedFormat('d M Y') }}
                    </td>
                    <td class="px-5 py-4">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $a->status_color }}">
                            {{ \App\Models\Absensi::STATUS[$a->status_kehadiran] ?? $a->status_kehadiran }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.absensi.edit', $a) }}"
                               class="p-1.5 rounded-lg text-slate-400 hover:text-navy hover:bg-navy/8 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    onclick="confirmDelete('{{ route('admin.absensi.destroy', $a) }}', 'Absensi {{ addslashes($a->pengurus->nama ?? '') }}')"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-red hover:bg-red/8 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
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
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if ($absensi->hasPages())
    <div class="px-5 py-4 border-t border-slate-100">
        {{ $absensi->links() }}
    </div>
    @endif
    @endif
</div>

<p class="text-xs text-slate-400 mt-3">
    Menampilkan {{ $absensi->count() }} dari {{ $absensi->total() }} catatan
</p>

@endsection
