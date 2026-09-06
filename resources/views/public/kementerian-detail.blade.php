@extends('layouts.public')
@section('title', $kementerian->nama_kementerian)

@section('content')

<div class="min-h-screen bg-gradient-to-br from-slate-50 to-navy/5">

    {{-- Hero --}}
    <div class="bg-navy text-white py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('profil') }}"
               class="inline-flex items-center gap-2 text-blue-300 hover:text-white text-sm mb-6 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Profil BEM
            </a>
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center shrink-0">
                    <span class="text-lg font-black text-white">{{ $kementerian->kode }}</span>
                </div>
                <div>
                    <p class="text-blue-300 text-sm mb-1">Kementerian</p>
                    <h1 class="text-2xl font-bold">{{ $kementerian->nama_kementerian }}</h1>
                </div>
            </div>
            @if ($kementerian->deskripsi)
            <p class="mt-4 text-blue-200 text-sm leading-relaxed max-w-2xl">
                {{ $kementerian->deskripsi }}
            </p>
            @endif
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-10 space-y-10">

        {{-- Pengurus --}}
        <div>
            <h2 class="text-xl font-bold text-navy mb-5">
                Pengurus
                <span class="text-sm font-normal text-slate-400 ml-2">
                    {{ $pengurus->count() }} anggota aktif
                </span>
            </h2>

            @if ($pengurus->isEmpty())
            <p class="text-slate-400 text-sm">Belum ada data pengurus.</p>
            @else
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($pengurus as $pg)
                <div class="bg-white rounded-2xl border border-slate-200 p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-navy/10 flex items-center justify-center shrink-0">
                        <span class="text-sm font-bold text-navy">
                            {{ strtoupper(substr($pg->nama, 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-navy text-sm truncate">{{ $pg->nama }}</p>
                        <p class="text-xs text-slate-400 truncate">{{ $pg->jabatan }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Program Kerja --}}
        <div>
            <h2 class="text-xl font-bold text-navy mb-5">
                Program Kerja
                <span class="text-sm font-normal text-slate-400 ml-2">
                    {{ $programKerja->count() }} kegiatan
                </span>
            </h2>

            @if ($programKerja->isEmpty())
            <p class="text-slate-400 text-sm">Belum ada program kerja.</p>
            @else
            <div class="space-y-3">
                @foreach ($programKerja as $pk)
                <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center justify-between gap-4">
                    <div class="min-w-0">
                        <p class="font-semibold text-navy text-sm">{{ $pk->nama_kegiatan }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">
                            {{ $pk->tanggal_pelaksanaan ? \Carbon\Carbon::parse($pk->tanggal_pelaksanaan)->translatedFormat('d M Y') : '—' }}
                        </p>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold
                            @if($pk->status === 'selesai') bg-green-50 text-green-700 border border-green-200
                            @elseif($pk->status === 'berjalan') bg-blue-50 text-blue-700 border border-blue-200
                            @else bg-slate-100 text-slate-500 @endif">
                            {{ ucfirst($pk->status) }}
                        </span>
                        @if ($pk->anggaran)
                        <p class="text-xs text-slate-400 mt-1">
                            Rp {{ number_format($pk->anggaran, 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

    </div>
</div>

@endsection
