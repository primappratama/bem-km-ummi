@extends('layouts.public')
@section('title', 'Program Kerja')

@section('content')

@php
    $kementerianList = \App\Models\Kementerian::orderBy('kode')->get();
    $selectedKem = request('kementerian');
    $selectedStatus = request('status');

    $query = \App\Models\ProgramKerja::with('kementerian')
        ->orderByRaw("FIELD(status, 'berjalan', 'rencana', 'selesai')")
        ->orderBy('tanggal_pelaksanaan');

    if ($selectedKem) $query->where('kementerian_id', $selectedKem);
    if ($selectedStatus) $query->where('status', $selectedStatus);

    $programKerja = $query->get();
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-navy/5">

    {{-- Hero --}}
    <div class="bg-navy text-white py-14 px-4">
        <div class="max-w-4xl mx-auto">
            <p class="text-blue-300 text-sm font-mono-data uppercase tracking-wider mb-2">Program Kerja</p>
            <h1 class="text-3xl font-bold mb-2">Agenda Kabinet Revolusioner</h1>
            <p class="text-blue-200 text-sm">BEM KM Universitas Muhammadiyah Sukabumi · Periode 2025–2026</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-10">

        {{-- Filter --}}
        <form method="GET" action="{{ url('/program-kerja') }}"
              class="flex flex-wrap gap-3 mb-8">
            <select name="kementerian"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                           focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                <option value="">Semua Kementerian</option>
                @foreach ($kementerianList as $k)
                <option value="{{ $k->id }}" {{ $selectedKem == $k->id ? 'selected' : '' }}>
                    {{ $k->kode }} — {{ $k->nama_kementerian }}
                </option>
                @endforeach
            </select>

            <select name="status"
                    class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-sm
                           focus:outline-none focus:ring-2 focus:ring-navy/20 transition-all">
                <option value="">Semua Status</option>
                <option value="berjalan" {{ $selectedStatus === 'berjalan' ? 'selected' : '' }}>Berjalan</option>
                <option value="rencana"  {{ $selectedStatus === 'rencana'  ? 'selected' : '' }}>Rencana</option>
                <option value="selesai"  {{ $selectedStatus === 'selesai'  ? 'selected' : '' }}>Selesai</option>
            </select>

            <button type="submit"
                    class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors"
                    style="background:#102A52">
                Filter
            </button>

            @if ($selectedKem || $selectedStatus)
            <a href="{{ url('/program-kerja') }}"
               class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-500
                      hover:bg-slate-50 transition-colors">
                Reset
            </a>
            @endif
        </form>

        {{-- Stats pills --}}
        <div class="flex flex-wrap gap-2 mb-6 text-xs font-semibold">
            @php
                $all = \App\Models\ProgramKerja::selectRaw('status, count(*) as total')->groupBy('status')->pluck('total','status');
            @endphp
            <span class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-600">
                Total: {{ array_sum($all->toArray()) }}
            </span>
            <span class="px-3 py-1.5 rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                Berjalan: {{ $all->get('berjalan', 0) }}
            </span>
            <span class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-500">
                Rencana: {{ $all->get('rencana', 0) }}
            </span>
            <span class="px-3 py-1.5 rounded-full bg-green-50 text-green-700 border border-green-200">
                Selesai: {{ $all->get('selesai', 0) }}
            </span>
        </div>

        {{-- Program Kerja list --}}
        @if ($programKerja->isEmpty())
        <div class="text-center py-16 text-slate-400">
            <p class="text-lg font-semibold mb-2">Belum ada program kerja</p>
            <p class="text-sm">Coba ubah filter atau kembali lagi nanti.</p>
        </div>
        @else
        <div class="space-y-3">
            @foreach ($programKerja as $pk)
            <div class="bg-white rounded-2xl border border-slate-200 p-5 hover:border-navy/30
                        hover:shadow-sm transition-all duration-200">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1.5">
                            <span class="text-[10px] font-black text-navy bg-navy/8 px-2 py-0.5 rounded-md">
                                {{ $pk->kementerian->kode ?? '—' }}
                            </span>
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold
                                @if($pk->status === 'berjalan') bg-blue-50 text-blue-700 border border-blue-200
                                @elseif($pk->status === 'selesai') bg-green-50 text-green-700 border border-green-200
                                @else bg-slate-100 text-slate-500 @endif">
                                {{ ucfirst($pk->status) }}
                            </span>
                        </div>
                        <h3 class="font-bold text-navy text-base">{{ $pk->nama_kegiatan }}</h3>
                        <p class="text-sm text-slate-500 mt-0.5">
                            {{ $pk->kementerian->nama_kementerian ?? '—' }}
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-xs text-slate-400">
                            {{ $pk->tanggal_pelaksanaan
                                ? \Carbon\Carbon::parse($pk->tanggal_pelaksanaan)->translatedFormat('d M Y')
                                : 'TBD' }}
                        </p>
                        @if ($pk->anggaran)
                        <p class="text-xs font-semibold text-slate-600 mt-0.5">
                            Rp {{ number_format($pk->anggaran, 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- CTA --}}
        <div class="mt-12 text-center">
            <a href="{{ url('/aspirasi') }}"
               class="inline-flex items-center gap-2 text-sm font-bold text-white px-6 py-3 rounded-full transition-colors"
               style="background:#102A52">
                Punya masukan untuk program kerja? Sampaikan di sini
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </div>
</div>

@endsection
