@extends('layouts.admin')
@section('title', 'Kementerian')
@section('page-title', 'Kementerian')

@section('content')

<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-slate-400">{{ $kementerian->count() }} kementerian terdaftar</p>
</div>

<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @foreach ($kementerian as $k)
    <div class="glass-card p-5 flex flex-col gap-4">
        {{-- Header --}}
        <div class="flex items-start justify-between">
            <div>
                <span class="inline-block text-[10px] font-mono-data font-bold uppercase tracking-wider
                             text-navy bg-navy/8 px-2.5 py-1 rounded-lg mb-2">
                    {{ $k->kode }}
                </span>
                <h3 class="font-bold text-navy text-sm leading-snug">{{ $k->nama_kementerian }}</h3>
            </div>
            <span class="shrink-0 text-xs font-semibold text-slate-400 bg-slate-100 px-2 py-1 rounded-lg">
                {{ $k->pengurus_count }} pengurus
            </span>
        </div>

        {{-- Deskripsi --}}
        @if ($k->deskripsi)
        <p class="text-xs text-slate-500 leading-relaxed flex-1">
            {{ Str::limit($k->deskripsi, 100) }}
        </p>
        @else
        <p class="text-xs text-slate-300 italic flex-1">Belum ada deskripsi.</p>
        @endif

        {{-- Action --}}
        @if (auth()->user()->isAdmin())
        <div class="pt-3 border-t border-slate-100">
            <a href="{{ route('admin.kementerian.edit', $k) }}"
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy
                      hover:text-red transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit Deskripsi
            </a>
        </div>
        @endif
    </div>
    @endforeach
</div>

@endsection
