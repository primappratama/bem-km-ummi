@extends('layouts.public')
@section('title', 'Berita')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-navy/5">
    <div class="bg-navy text-white py-14 px-4">
        <div class="max-w-4xl mx-auto">
            <p class="text-blue-300 text-sm font-mono-data uppercase tracking-wider mb-2">Berita & Informasi</p>
            <h1 class="text-3xl font-bold">Kabar Terkini BEM KM UMMI</h1>
        </div>
    </div>
    <div class="max-w-4xl mx-auto px-4 py-20 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl mb-6"
             style="background:#E8EEF5">
            <svg class="w-8 h-8" style="color:#102A52" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>
            </svg>
        </div>
        <h2 class="text-xl font-bold text-navy mb-3">Segera Hadir</h2>
        <p class="text-slate-500 text-sm max-w-md mx-auto leading-relaxed">
            Halaman berita dan informasi BEM KM UMMI sedang dalam pengembangan.
            Ikuti media sosial kami untuk informasi terkini.
        </p>
        <div class="mt-8 flex justify-center gap-3">
            <a href="{{ url('/') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white transition-colors"
               style="background:#102A52">
                Kembali ke Beranda
            </a>
            <a href="{{ url('/aspirasi') }}"
               class="px-5 py-2.5 rounded-xl text-sm font-semibold border border-slate-200
                      text-slate-600 hover:bg-slate-50 transition-colors">
                Sampaikan Aspirasi
            </a>
        </div>
    </div>
</div>
@endsection
