@extends('layouts.admin')
@section('title', 'Rekap Absensi')
@section('page-title', 'Absensi')
@section('page-subtitle', 'Rekap Per Pengurus')

@section('content')

{{-- Filter --}}
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <form method="GET" action="{{ route('admin.absensi.rekap') }}"
          class="flex flex-col sm:flex-row gap-2 flex-1">
        <select name="bulan"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Bulan</option>
            @for($m=1; $m<=12; $m++)
            <option value="{{ $m }}" {{ request('bulan')==$m?'selected':'' }}>
                {{ \Carbon\Carbon::createFromDate(null,$m,1)->translatedFormat('F') }}
            </option>
            @endfor
        </select>
        <select name="kementerian_id"
                class="px-3 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                       focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
            <option value="">Semua Kementerian</option>
            @foreach($kementerianList as $k)
            <option value="{{ $k->id }}" {{ request('kementerian_id')==$k->id?'selected':'' }}>
                {{ $k->kode }}
            </option>
            @endforeach
        </select>
        <button type="submit"
                class="px-5 py-2.5 rounded-xl bg-navy text-white text-sm font-semibold
                       hover:bg-navy/90 transition-colors">
            Filter
        </button>
        @if(request()->hasAny(['bulan','kementerian_id']))
        <a href="{{ route('admin.absensi.rekap') }}"
           class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                  hover:bg-slate-50 transition-colors text-center">
            Reset
        </a>
        @endif
    </form>
    <a href="{{ route('admin.absensi.index') }}"
       class="px-5 py-2.5 rounded-xl border border-slate-200 text-sm font-semibold
              text-slate-500 hover:bg-slate-50 transition-colors text-center shrink-0">
        ← Kembali ke Absensi
    </a>
</div>

{{-- Rekap table --}}
<div class="glass-card overflow-hidden">
    @if($rekap->isEmpty())
    <div class="py-16 text-center text-sm text-slate-400">
        Belum ada data absensi.
    </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-slate-100">
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Pengurus</th>
                    <th class="px-5 py-3.5 text-left text-xs font-bold text-slate-400 uppercase tracking-wider hidden md:table-cell">Kementerian</th>
                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">Total</th>
                    <th class="px-5 py-3.5 text-center text-xs font-bold text-green-500 uppercase tracking-wider">Hadir</th>
                    <th class="px-5 py-3.5 text-center text-xs font-bold text-amber-500 uppercase tracking-wider">Izin</th>
                    <th class="px-5 py-3.5 text-center text-xs font-bold text-red uppercase tracking-wider">Alfa</th>
                    <th class="px-5 py-3.5 text-center text-xs font-bold text-slate-400 uppercase tracking-wider">% Hadir</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @foreach($rekap as $r)
                @php $pct = $r->total > 0 ? round($r->hadir / $r->total * 100) : 0; @endphp
                <tr class="hover:bg-slate-50/60 transition-colors">
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-navy/10 flex items-center justify-center shrink-0">
                                <span class="text-xs font-bold text-navy">
                                    {{ strtoupper(substr($r->nama, 0, 1)) }}
                                </span>
                            </div>
                            <div>
                                <p class="font-semibold text-navy text-sm">{{ $r->nama }}</p>
                                <p class="text-xs text-slate-400">{{ $r->jabatan }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-5 py-4 hidden md:table-cell">
                        @if($r->kode)
                        <span class="text-[10px] font-bold text-navy bg-navy/8 px-2 py-0.5 rounded-md">
                            {{ $r->kode }}
                        </span>
                        @else
                        <span class="text-slate-300 text-xs">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-4 text-center font-bold text-navy">{{ $r->total }}</td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full
                                     bg-green-50 text-green-700 text-xs font-bold">
                            {{ $r->hadir }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full
                                     bg-amber-50 text-amber-700 text-xs font-bold">
                            {{ $r->izin }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full
                                     bg-red/8 text-red text-xs font-bold">
                            {{ $r->alfa }}
                        </span>
                    </td>
                    <td class="px-5 py-4">
                        <div class="flex items-center gap-2">
                            <div class="flex-1 bg-slate-100 rounded-full h-2 max-w-[80px]">
                                <div class="h-2 rounded-full transition-all duration-500
                                            {{ $pct >= 80 ? 'bg-green-400' : ($pct >= 50 ? 'bg-amber-400' : 'bg-red/60') }}"
                                     style="width:{{ $pct }}%"></div>
                            </div>
                            <span class="text-xs font-bold {{ $pct >= 80 ? 'text-green-600' : ($pct >= 50 ? 'text-amber-600' : 'text-red') }}">
                                {{ $pct }}%
                            </span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<p class="text-xs text-slate-400 mt-3">{{ $rekap->count() }} pengurus terdaftar</p>

@endsection
