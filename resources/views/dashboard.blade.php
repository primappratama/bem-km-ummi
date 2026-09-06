@extends('layouts.app')

@section('title', 'Dashboard Monitoring')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl p-5 border border-slate-200">
        <p class="text-xs text-slate-400 font-mono-data">PROGRAM KERJA</p>
        <p class="text-2xl font-extrabold mt-1">{{ $totalProker ?? 0 }}</p>
        <p class="text-xs text-emerald-600 mt-1">{{ $prokerSelesai ?? 0 }} selesai</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200">
        <p class="text-xs text-slate-400 font-mono-data">SALDO KAS</p>
        <p class="text-2xl font-extrabold mt-1">Rp {{ number_format($saldoKas ?? 0, 0, ',', '.') }}</p>
        <p class="text-xs text-slate-400 mt-1">update real-time</p>
    </div>
    <div class="bg-white rounded-xl p-5 border border-slate-200">
        <p class="text-xs text-slate-400 font-mono-data">PENGURUS AKTIF</p>
        <p class="text-2xl font-extrabold mt-1">{{ $totalPengurus ?? 0 }}</p>
    </div>
    <div class="bg-navy rounded-xl p-5 border border-navy">
        <p class="text-xs text-orange font-mono-data">ASPIRASI BARU</p>
        <p class="text-2xl font-extrabold mt-1 text-white">{{ $aspirasiBaru ?? 0 }}</p>
        <p class="text-xs text-white/50 mt-1">belum ditindaklanjuti</p>
    </div>
</div>

<div class="bg-white rounded-xl p-5 border border-slate-200">
    <p class="text-sm font-semibold mb-3">Progres Program Kerja per Kementerian</p>
    <div class="space-y-3">
        @forelse(($progresKementerian ?? []) as $k)
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span>{{ $k['nama'] }}</span>
                    <span class="font-mono-data">{{ $k['persen'] }}%</span>
                </div>
                <div class="h-2 bg-slate-100 rounded-full">
                    <div class="h-2 bg-orange rounded-full" style="width: {{ $k['persen'] }}%"></div>
                </div>
            </div>
        @empty
            <p class="text-sm text-slate-400">Belum ada data program kerja.</p>
        @endforelse
    </div>
</div>
@endsection
