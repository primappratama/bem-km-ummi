@extends('layouts.public')
@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4"
     style="background: linear-gradient(135deg, #06101E 0%, #102A52 60%, #0D1433 100%);">

    {{-- Orb accents --}}
    <div class="pointer-events-none absolute top-0 right-0 w-96 h-96 rounded-full opacity-20"
         style="background: radial-gradient(circle, #F0871E 0%, transparent 70%); filter:blur(60px);"></div>
    <div class="pointer-events-none absolute bottom-0 left-0 w-72 h-72 rounded-full opacity-15"
         style="background: radial-gradient(circle, #E31E30 0%, transparent 70%); filter:blur(50px);"></div>

    <div class="relative text-center max-w-lg mx-auto">

        {{-- 404 besar --}}
        <div class="mb-6">
            <p class="font-extrabold leading-none select-none"
               style="font-size:9rem; background: linear-gradient(135deg, #F0871E 0%, #F5A623 50%, #E31E30 100%);
                      -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                404
            </p>
        </div>

        <h1 class="text-2xl font-bold text-white mb-3">Halaman Tidak Ditemukan</h1>
        <p class="text-white/50 text-sm leading-relaxed mb-10 max-w-sm mx-auto">
            Halaman yang kamu cari tidak ada atau telah dipindahkan.
            Coba kembali ke beranda atau sampaikan aspirasi kamu.
        </p>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ url('/') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold
                      text-navy transition-colors duration-200"
               style="background:#F0871E">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Kembali ke Beranda
            </a>
            <a href="{{ url('/aspirasi') }}"
               class="inline-flex items-center gap-2 px-6 py-3 rounded-full text-sm font-bold
                      text-white border border-white/20 hover:bg-white/10 transition-colors duration-200">
                Sampaikan Aspirasi
            </a>
        </div>

        {{-- BEM branding --}}
        <div class="mt-14 flex items-center justify-center gap-2 opacity-30">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-6 h-6 object-contain">
            <p class="text-white text-xs font-bold">BEM KM UMMI</p>
        </div>
    </div>
</div>
@endsection
