@extends('layouts.admin')
@section('title', $programKerja->nama_kegiatan)
@section('page-title', 'Program Kerja')
@section('page-subtitle', 'Detail')

@section('content')
@php
    $realisasi = (float) ($programKerja->realisasi ?? 0);
    $anggaran  = (float) $programKerja->anggaran;
    $sisa      = $anggaran - $realisasi;
    $pct       = $anggaran > 0 ? min(100, round(($realisasi / $anggaran) * 100)) : 0;
    $overBudget = $realisasi > $anggaran;
@endphp

<div class="max-w-3xl space-y-5">

    <a href="{{ route('admin.program-kerja.index') }}"
       class="inline-flex items-center gap-1.5 text-sm text-slate-400 hover:text-navy transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Daftar
    </a>

    {{-- Header --}}
    <div class="glass-card p-6">
        <div class="flex items-start justify-between gap-4 flex-wrap">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    @if ($programKerja->kementerian)
                    <span class="text-[10px] font-mono-data font-bold uppercase tracking-wider
                                 text-navy bg-navy/8 px-2 py-0.5 rounded-md">
                        {{ $programKerja->kementerian->kode }}
                    </span>
                    @endif
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold
                                 {{ $programKerja->status_color }}">
                        {{ $programKerja->status_label }}
                    </span>
                </div>
                <h2 class="text-xl font-extrabold text-navy">{{ $programKerja->nama_kegiatan }}</h2>
                <p class="text-sm text-slate-400 mt-1">
                    {{ $programKerja->tanggal_pelaksanaan->translatedFormat('d F Y') }}
                </p>
            </div>
            <a href="{{ route('admin.program-kerja.edit', $programKerja) }}"
               class="btn-primary shrink-0">
                Edit
            </a>
        </div>
    </div>

    {{-- Budget Card --}}
    <div class="glass-card p-6">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Anggaran</h3>
        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <p class="text-xs text-slate-400 mb-1">Rencana</p>
                <p class="text-lg font-extrabold text-navy font-mono-data">
                    Rp {{ number_format($anggaran, 0, ',', '.') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Realisasi</p>
                <p class="text-lg font-extrabold font-mono-data {{ $overBudget ? 'text-red' : 'text-orange' }}">
                    Rp {{ number_format($realisasi, 0, ',', '.') }}
                </p>
            </div>
            <div>
                <p class="text-xs text-slate-400 mb-1">Sisa</p>
                <p class="text-lg font-extrabold font-mono-data {{ $sisa < 0 ? 'text-red' : 'text-green-600' }}">
                    Rp {{ number_format(abs($sisa), 0, ',', '.') }}
                    @if ($sisa < 0) <span class="text-xs">(lebih)</span> @endif
                </p>
            </div>
        </div>

        {{-- Progress bar --}}
        <div class="space-y-1.5">
            <div class="flex justify-between text-xs text-slate-400">
                <span>Realisasi anggaran</span>
                <span class="{{ $overBudget ? 'text-red font-semibold' : '' }}">{{ $pct }}%</span>
            </div>
            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full rounded-full transition-all duration-500
                            {{ $overBudget ? 'bg-red' : ($pct > 75 ? 'bg-orange' : 'bg-green-400') }}"
                     style="width: {{ $pct }}%"></div>
            </div>
            @if ($overBudget)
            <p class="text-xs text-red font-medium">⚠ Realisasi melebihi anggaran yang direncanakan.</p>
            @endif
        </div>
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="glass-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Riwayat Transaksi</h3>
            <span class="text-xs text-slate-400">{{ $transaksi->count() }} transaksi</span>
        </div>
        @if ($transaksi->isEmpty())
        <div class="py-8 text-center">
            <p class="text-sm text-slate-300">Belum ada transaksi keuangan untuk program ini.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Keterangan</th>
                        <th class="px-5 py-3 text-right text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($transaksi as $t)
                    <tr>
                        <td class="px-5 py-3 text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($t->tanggal_transaksi)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-5 py-3 text-slate-600">{{ $t->keterangan ?? '—' }}</td>
                        <td class="px-5 py-3 text-right font-mono-data text-xs font-semibold
                                   {{ $t->jenis === 'masuk' ? 'text-green-600' : 'text-red' }}">
                            {{ $t->jenis === 'masuk' ? '+' : '-' }}
                            Rp {{ number_format($t->jumlah, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    {{-- Absensi --}}
    @if ($absensi->count())
    <div class="glass-card overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Absensi Peserta</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Pengurus</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-left text-xs font-bold text-slate-400 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach ($absensi as $a)
                    @php
                        $badgeColor = match($a->status_kehadiran) {
                            'hadir' => 'bg-green-50 text-green-600',
                            'izin'  => 'bg-orange/10 text-orange',
                            'alfa'  => 'bg-red/8 text-red',
                            default => 'bg-slate-100 text-slate-400',
                        };
                    @endphp
                    <tr>
                        <td class="px-5 py-3 font-medium text-navy text-sm">{{ $a->pengurus->nama ?? '—' }}</td>
                        <td class="px-5 py-3 text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($a->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $badgeColor }}">
                                {{ ucfirst($a->status_kehadiran) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
