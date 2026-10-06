@extends('layouts.public')
@section('title', 'Galeri')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-navy/5">
    <div class="bg-navy text-white py-14 px-4">
        <div class="max-w-4xl mx-auto">
            <p class="text-blue-300 text-sm font-mono-data uppercase tracking-wider mb-2">Galeri Kegiatan</p>
            <h1 class="text-3xl font-bold">Dokumentasi BEM KM UMMI</h1>
        </div>
    </div>
    <div class="max-w-4xl mx-auto px-4 py-20 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6"
             style="background:#E8EEF5">
            <svg class="w-8 h-8" style="color:#102A52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-navy mb-3">Segera Hadir</h2>
        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
            Galeri dokumentasi kegiatan BEM KM UMMI sedang dalam pengembangan.
            Ikuti Instagram kami untuk foto dan video kegiatan terkini.
        </p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ url('/') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors"
               style="background:#102A52">
                Kembali ke Beranda
            </a>
            <a href="{{ url('/program-kerja') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200
                      text-slate-600 hover:bg-slate-50 transition-colors">
                Lihat Program Kerja
            </a>
        </div>
    </div>
</div>
@endsection
