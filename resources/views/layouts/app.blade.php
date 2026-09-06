<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') &mdash; BEM KM UMMI</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    {{-- Breeze/Vite punya ini, biarkan tetap ada agar Tailwind build jalan --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-data { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
{{--
    Palette resmi Kabinet Revolusioner (diambil langsung dari PPT & logo,
    bukan rekaan) -- tambahkan di tailwind.config.js -> theme.extend.colors,
    lihat catatan di bawah file ini:
        navy        #102A52   (sidebar / dasar gelap)
        navy-soft   #1B3A6B   (hover / card gelap)
        red         #E31E30   (aksen utama, banner, tombol primary)
        orange      #F0871E   (aksen sekunder, highlight, progress bar)
        maroon      #690000   (aksen gelap, dipakai tipis/jarang)
        mist        #F6F7FB   (background konten)
        ink         #1C1E26   (teks utama di area terang)
--}}
<body class="bg-mist text-ink antialiased">
    <div class="flex min-h-screen">

        {{-- ================= SIDEBAR ================= --}}
        <aside class="hidden lg:flex w-64 flex-col bg-navy text-white shrink-0">
            <div class="px-6 py-6 border-b border-white/10 flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BEM KM UMMI" class="w-10 h-10 object-contain">
                <div>
                    <p class="text-base font-extrabold tracking-tight leading-tight">
                        BEM KM <span class="text-orange">UMMI</span>
                    </p>
                    <p class="text-[11px] text-white/50 font-mono-data uppercase tracking-wide">Kabinet Revolusioner</p>
                </div>
            </div>

            <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                @php $user = auth()->user(); @endphp

                <a href="{{ url('/dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2
                          {{ request()->is('dashboard') ? 'bg-navy-soft text-white border-red' : 'text-white/70 hover:text-white hover:bg-navy-soft border-transparent' }}">
                    Dashboard
                </a>

                @if($user && $user->hasRole(['super_admin', 'sekretaris']))
                <a href="{{ url('/pengurus') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2
                          {{ request()->is('pengurus*') ? 'bg-navy-soft text-white border-red' : 'text-white/70 hover:text-white hover:bg-navy-soft border-transparent' }}">
                    Data Pengurus
                </a>
                @endif

                @if($user && $user->hasRole(['super_admin', 'sekretaris', 'kementerian']))
                <a href="{{ url('/program-kerja') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2
                          {{ request()->is('program-kerja*') ? 'bg-navy-soft text-white border-red' : 'text-white/70 hover:text-white hover:bg-navy-soft border-transparent' }}">
                    Program Kerja
                </a>
                <a href="{{ url('/absensi') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2
                          {{ request()->is('absensi*') ? 'bg-navy-soft text-white border-red' : 'text-white/70 hover:text-white hover:bg-navy-soft border-transparent' }}">
                    Absensi Pengurus
                </a>
                @endif

                @if($user && $user->hasRole(['super_admin', 'bendahara']))
                <a href="{{ url('/keuangan') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2
                          {{ request()->is('keuangan*') ? 'bg-navy-soft text-white border-red' : 'text-white/70 hover:text-white hover:bg-navy-soft border-transparent' }}">
                    Keuangan
                </a>
                @endif

                @if($user && $user->hasRole(['super_admin', 'sekretaris', 'kementerian']))
                <a href="{{ url('/dokumen-lpj') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2
                          {{ request()->is('dokumen-lpj*') ? 'bg-navy-soft text-white border-red' : 'text-white/70 hover:text-white hover:bg-navy-soft border-transparent' }}">
                    Dokumen / Arsip LPJ
                </a>
                <a href="{{ url('/berita') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2 text-white/70 hover:text-white hover:bg-navy-soft border-transparent">
                    Berita
                </a>
                <a href="{{ url('/galeri') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2 text-white/70 hover:text-white hover:bg-navy-soft border-transparent">
                    Galeri
                </a>
                @endif

                @if($user && $user->isSuperAdmin())
                <a href="{{ url('/aspirasi') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2 text-white/70 hover:text-white hover:bg-navy-soft border-transparent">
                    Aspirasi Mahasiswa
                </a>
                <a href="{{ url('/settings') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium border-l-2 text-white/70 hover:text-white hover:bg-navy-soft border-transparent">
                    Pengaturan
                </a>
                @endif
            </nav>

            <div class="px-4 py-4 border-t border-white/10">
                <p class="text-sm font-semibold truncate">{{ $user->name ?? '' }}</p>
                <p class="text-xs text-white/50 font-mono-data uppercase truncate">{{ $user->role ?? '' }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="text-xs text-white/60 hover:text-orange transition">
                        Keluar &rarr;
                    </button>
                </form>
            </div>
        </aside>

        {{-- ================= MAIN ================= --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Topbar --}}
            <header class="bg-white border-b border-slate-200 px-4 sm:px-8 py-4 flex items-center justify-between">
                <h1 class="text-lg font-bold text-ink">@yield('title', 'Dashboard')</h1>
                <div class="text-xs font-mono-data text-slate-400">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </header>

            {{-- Flash messages --}}
            <div class="px-4 sm:px-8 pt-4">
                @if (session('success'))
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 text-emerald-700 text-sm px-4 py-3 mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="rounded-lg border border-rose-200 bg-rose-50 text-rose-700 text-sm px-4 py-3 mb-4">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <main class="flex-1 px-4 sm:px-8 py-2 pb-10">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

{{--
================================================================
CARA PAKAI di view lain, misal resources/views/dashboard.blade.php:

@extends('layouts.app')
@section('title', 'Dashboard Monitoring')
@section('content')
    <p>Isi halaman di sini...</p>
@endsection
================================================================

TAMBAHKAN ke tailwind.config.js punya kamu, di dalam theme.extend.colors:

    colors: {
        navy: '#102A52',
        'navy-soft': '#1B3A6B',
        red: '#E31E30',
        orange: '#F0871E',
        maroon: '#690000',
        ink: '#1C1E26',
        mist: '#F6F7FB',
    }

Lalu jalankan ulang: npm run dev (atau npm run build)
================================================================
--}}
