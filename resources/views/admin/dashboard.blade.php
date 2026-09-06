@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ═══ GREETING ═══ --}}
<p class="text-sm text-slate-500 mb-6">
    Selamat datang, <span class="font-semibold text-navy">{{ auth()->user()->name }}</span>.
    Berikut ringkasan data BEM KM UMMI hari ini.
</p>

{{-- ═══ STAT CARDS ═══ --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    {{-- Saldo --}}
    <div class="glass-card p-5 col-span-2 lg:col-span-1">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Saldo Organisasi</p>
        <p class="text-2xl font-extrabold {{ $stats['saldo'] >= 0 ? 'text-navy' : 'text-red' }}">
            Rp {{ number_format(abs($stats['saldo']), 0, ',', '.') }}
        </p>
        <div class="mt-2 flex gap-3 text-xs">
            <span class="text-green-600 font-semibold">
                +Rp {{ number_format($masukBulan, 0, ',', '.') }}
            </span>
            <span class="text-red font-semibold">
                -Rp {{ number_format($keluarBulan, 0, ',', '.') }}
            </span>
        </div>
        <p class="text-[10px] text-slate-400 mt-0.5">bulan {{ now()->translatedFormat('F') }}</p>
    </div>

    {{-- Pengurus --}}
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Pengurus Aktif</p>
        <p class="text-2xl font-extrabold text-navy">{{ $stats['pengurus'] }}</p>
        <p class="text-xs text-slate-400 mt-1">di 7 kementerian</p>
    </div>

    {{-- Program Kerja --}}
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Program Kerja</p>
        <p class="text-2xl font-extrabold text-navy">{{ $stats['program_kerja'] }}</p>
        <div class="flex gap-2 mt-1 text-[10px] font-semibold">
            <span class="text-blue-500">{{ $prokerStatus->get('berjalan', 0) }} berjalan</span>
            <span class="text-green-500">{{ $prokerStatus->get('selesai', 0) }} selesai</span>
        </div>
    </div>

    {{-- Aspirasi --}}
    <div class="glass-card p-5">
        <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Aspirasi Masuk</p>
        <p class="text-2xl font-extrabold {{ $stats['aspirasi'] > 0 ? 'text-amber-600' : 'text-navy' }}">
            {{ $stats['aspirasi'] }}
        </p>
        <p class="text-xs text-slate-400 mt-1">belum ditindaklanjuti</p>
        @if ($stats['aspirasi'] > 0)
        <a href="{{ route('admin.aspirasi.index') }}"
           class="text-[10px] text-amber-600 font-semibold hover:underline">
            Lihat sekarang →
        </a>
        @endif
    </div>
</div>

{{-- ═══ MAIN GRID ═══ --}}
<div class="grid lg:grid-cols-2 gap-6">

    {{-- Program Kerja Berjalan --}}
    <div class="glass-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-navy">Program Kerja Berjalan</h3>
            <a href="{{ route('admin.program-kerja.index') }}"
               class="text-xs text-slate-400 hover:text-navy transition-colors">Lihat semua →</a>
        </div>
        @if ($prokerBerjalan->isEmpty())
        <div class="px-5 py-8 text-center text-sm text-slate-400">
            Tidak ada program kerja yang sedang berjalan.
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach ($prokerBerjalan as $pk)
            <div class="px-5 py-3.5 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm font-medium text-navy truncate">{{ $pk->nama_kegiatan }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ \Carbon\Carbon::parse($pk->tanggal_pelaksanaan)->translatedFormat('d M Y') }}
                    </p>
                </div>
                <span class="text-[10px] font-black text-navy bg-navy/8 px-2 py-0.5 rounded-md shrink-0">
                    {{ $pk->kem_kode }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Aspirasi Terbaru --}}
    <div class="glass-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-navy">Aspirasi Terbaru</h3>
            <a href="{{ route('admin.aspirasi.index') }}"
               class="text-xs text-slate-400 hover:text-navy transition-colors">Lihat semua →</a>
        </div>
        @if ($aspirasiTerbaru->isEmpty())
        <div class="px-5 py-8 text-center text-sm text-slate-400">
            Belum ada aspirasi masuk.
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach ($aspirasiTerbaru as $asp)
            <div class="px-5 py-3.5">
                <div class="flex items-start justify-between gap-2">
                    <p class="text-sm text-slate-700 line-clamp-1 flex-1">{{ $asp->isi_aspirasi }}</p>
                    <span class="inline-flex px-2 py-0.5 rounded-full text-[10px] font-bold shrink-0
                        @if($asp->status_tindak_lanjut === 'belum_ditindaklanjuti') bg-amber-50 text-amber-700 border border-amber-200
                        @elseif($asp->status_tindak_lanjut === 'diproses') bg-blue-50 text-blue-700 border border-blue-200
                        @else bg-green-50 text-green-700 border border-green-200 @endif">
                        {{ $asp->status_tindak_lanjut === 'belum_ditindaklanjuti' ? 'Baru' : ucfirst($asp->status_tindak_lanjut) }}
                    </span>
                </div>
                <p class="text-xs text-slate-400 mt-0.5">
                    {{ $asp->nama ?: 'Anonim' }}
                    · {{ \Carbon\Carbon::parse($asp->created_at)->diffForHumans() }}
                </p>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="glass-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-sm font-bold text-navy">Transaksi Terbaru</h3>
            <a href="{{ route('admin.keuangan.index') }}"
               class="text-xs text-slate-400 hover:text-navy transition-colors">Lihat semua →</a>
        </div>
        @if ($transaksiTerbaru->isEmpty())
        <div class="px-5 py-8 text-center text-sm text-slate-400">
            Belum ada transaksi.
        </div>
        @else
        <div class="divide-y divide-slate-50">
            @foreach ($transaksiTerbaru as $t)
            <div class="px-5 py-3.5 flex items-center justify-between gap-3">
                <div class="min-w-0">
                    <p class="text-sm text-slate-700 truncate">{{ $t->keterangan ?: 'Tanpa keterangan' }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->translatedFormat('d M Y') }}
                        · {{ $t->pencatat }}
                    </p>
                </div>
                <span class="font-mono-data text-sm font-bold shrink-0
                    {{ $t->jenis === 'masuk' ? 'text-green-600' : 'text-red' }}">
                    {{ $t->jenis === 'masuk' ? '+' : '-' }}
                    Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                </span>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Status Program Kerja --}}
    <div class="glass-card p-5">
        <h3 class="text-sm font-bold text-navy mb-4">Status Program Kerja</h3>
        @php
            $total = $stats['program_kerja'] ?: 1;
            $statusData = [
                ['label' => 'Rencana',  'key' => 'rencana',  'color' => 'bg-slate-300',  'text' => 'text-slate-500'],
                ['label' => 'Berjalan', 'key' => 'berjalan', 'color' => 'bg-blue-400',   'text' => 'text-blue-600'],
                ['label' => 'Selesai',  'key' => 'selesai',  'color' => 'bg-green-400',  'text' => 'text-green-600'],
            ];
        @endphp
        <div class="space-y-3">
            @foreach ($statusData as $s)
            @php $count = $prokerStatus->get($s['key'], 0); $pct = round($count / $total * 100); @endphp
            <div>
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-medium text-slate-600">{{ $s['label'] }}</span>
                    <span class="text-xs font-bold {{ $s['text'] }}">{{ $count }} ({{ $pct }}%)</span>
                </div>
                <div class="w-full bg-slate-100 rounded-full h-2">
                    <div class="{{ $s['color'] }} h-2 rounded-full transition-all duration-500"
                         style="width: {{ $pct }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Quick links --}}
        <div class="mt-6 pt-4 border-t border-slate-100">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Akses Cepat</p>
            <div class="grid grid-cols-2 gap-2">
                @php $quickLinks = [
                    ['label' => '+ Pengurus',     'route' => 'admin.pengurus.create'],
                    ['label' => '+ Program Kerja','route' => 'admin.program-kerja.create'],
                    ['label' => '+ Transaksi',    'route' => 'admin.keuangan.create'],
                    ['label' => '+ Absensi',      'route' => 'admin.absensi.create'],
                ]; @endphp
                @foreach ($quickLinks as $ql)
                <a href="{{ route($ql['route']) }}"
                   class="text-center text-xs font-semibold text-navy border border-slate-200
                          rounded-xl py-2 hover:bg-navy hover:text-white hover:border-navy
                          transition-all duration-150">
                    {{ $ql['label'] }}
                </a>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection
