<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'BEM KM UMMI') &mdash; Kabinet Revolusioner</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-mist text-ink antialiased">

    {{-- ===== NAVBAR ===== --}}
    <header id="site-header" class="sticky top-0 z-50 px-4 pt-4 pb-2">
        <div class="max-w-5xl mx-auto glass-nav rounded-full px-4 sm:px-6 h-16 sm:h-[68px] flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 shrink-0">
                <img src="{{ asset('images/logo.png') }}" alt="BEM KM UMMI" class="w-9 h-9 object-contain">
                <div class="leading-tight hidden sm:block">
                    <p class="font-extrabold text-navy text-sm tracking-tight">BEM KM UMMI</p>
                    <p class="text-[9px] font-mono-data uppercase tracking-wider text-red">Kabinet Revolusioner</p>
                </div>
            </a>

            {{-- Desktop nav --}}
            <nav class="hidden md:flex items-center gap-6 text-sm font-semibold text-ink/70">
                @php
                    $navActive = fn($path) => request()->is($path) ? 'text-navy border-b-2 border-red pb-0.5' : 'hover:text-navy transition-colors duration-200';
                @endphp
                <a href="{{ url('/') }}"             class="{{ $navActive('/') }}">Beranda</a>
                <a href="{{ url('/profil') }}"        class="{{ $navActive('profil') }}">Tentang Kami</a>
                <a href="{{ url('/program-kerja') }}" class="{{ $navActive('program-kerja') }}">Program Kerja</a>
                <a href="{{ url('/berita') }}"        class="{{ $navActive('berita') }}">Berita</a>
                <a href="{{ url('/galeri') }}"        class="{{ $navActive('galeri') }}">Galeri</a>
            </nav>

            {{-- CTA + Hamburger --}}
            <div class="flex items-center gap-3">
                <a href="{{ url('/aspirasi') }}"
                   class="hidden md:inline-flex items-center bg-red text-white text-sm font-bold px-5 py-2.5 rounded-full hover:bg-maroon transition-colors duration-200 shadow-sm">
                    Sampaikan Aspirasi
                </a>
                {{-- Mobile hamburger --}}
                <button id="nav-toggle"
                        class="md:hidden flex flex-col gap-[5px] w-8 h-8 items-center justify-center"
                        aria-label="Toggle menu" aria-expanded="false">
                    <span class="hamburger-line block w-5 h-0.5 bg-navy rounded transition-all duration-300 origin-center"></span>
                    <span class="hamburger-line block w-5 h-0.5 bg-navy rounded transition-all duration-300 origin-center"></span>
                    <span class="hamburger-line block w-5 h-0.5 bg-navy rounded transition-all duration-300 origin-center"></span>
                </button>
            </div>
        </div>

        {{-- Mobile menu panel --}}
        <div id="mobile-menu"
             class="md:hidden max-w-5xl mx-auto mt-2 overflow-hidden"
             style="max-height:0; transition: max-height 0.35s ease, opacity 0.3s ease; opacity:0;">
            <div class="glass-nav rounded-2xl px-6 py-5 space-y-1">
                <a href="{{ url('/') }}"             class="block py-2.5 text-sm font-semibold text-ink/80 hover:text-navy border-b border-slate-100 transition-colors">Beranda</a>
                <a href="{{ url('/profil') }}"        class="block py-2.5 text-sm font-semibold text-ink/80 hover:text-navy border-b border-slate-100 transition-colors">Tentang Kami</a>
                <a href="{{ url('/program-kerja') }}" class="block py-2.5 text-sm font-semibold text-ink/80 hover:text-navy border-b border-slate-100 transition-colors">Program Kerja</a>
                <a href="{{ url('/berita') }}"        class="block py-2.5 text-sm font-semibold text-ink/80 hover:text-navy border-b border-slate-100 transition-colors">Berita</a>
                <a href="{{ url('/galeri') }}"        class="block py-2.5 text-sm font-semibold text-ink/80 hover:text-navy border-b border-slate-100 transition-colors">Galeri</a>
                <a href="{{ url('/aspirasi') }}"
                   class="block mt-3 text-center bg-red text-white text-sm font-bold py-3 rounded-full hover:bg-maroon transition-colors">
                    Sampaikan Aspirasi
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="bg-navy text-white/60">
        <div class="max-w-6xl mx-auto px-6 py-14 grid grid-cols-1 md:grid-cols-4 gap-10">
            <div class="col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-9 h-9 object-contain">
                    <div>
                        <p class="font-extrabold text-white text-sm">BEM KM UMMI</p>
                        <p class="text-[9px] font-mono-data uppercase tracking-wider text-orange">Kabinet Revolusioner</p>
                    </div>
                </div>
                <p class="text-sm max-w-sm leading-relaxed">Badan Eksekutif Mahasiswa Keluarga Mahasiswa Universitas Muhammadiyah Sukabumi, periode 2025&ndash;2026.</p>
            </div>
            <div>
                <p class="text-white font-bold text-xs uppercase tracking-widest mb-4">Tautan</p>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ url('/profil') }}"        class="hover:text-orange transition-colors">Tentang Kami</a></li>
                    <li><a href="{{ url('/program-kerja') }}" class="hover:text-orange transition-colors">Program Kerja</a></li>
                    <li><a href="{{ url('/aspirasi') }}"      class="hover:text-orange transition-colors">Aspirasi Mahasiswa</a></li>
                </ul>
            </div>
            <div>
                <p class="text-white font-bold text-xs uppercase tracking-widest mb-4">Kontak</p>
                <ul class="space-y-2 text-sm">
                    <li>bemkm@ummi.ac.id</li>
                    <li>@bemkmummi</li>
                    <li class="text-xs text-white/40 leading-relaxed">Jl. R. Syamsudin, S.H. No.50<br>Sukabumi, Jawa Barat 43113</li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/8 py-5 text-center text-xs text-white/30">
            &copy; {{ now()->year }} BEM KM UMMI &mdash; Kabinet Revolusioner.
        </div>
    </footer>

    {{-- Hamburger JS --}}
    <script>
    (function(){
        const btn = document.getElementById('nav-toggle');
        const menu = document.getElementById('mobile-menu');
        const lines = btn.querySelectorAll('.hamburger-line');
        let open = false;
        btn.addEventListener('click', () => {
            open = !open;
            btn.setAttribute('aria-expanded', open);
            if (open) {
                menu.style.maxHeight = menu.scrollHeight + 80 + 'px';
                menu.style.opacity = '1';
                lines[0].style.transform = 'translateY(7px) rotate(45deg)';
                lines[1].style.opacity = '0';
                lines[2].style.transform = 'translateY(-7px) rotate(-45deg)';
            } else {
                menu.style.maxHeight = '0';
                menu.style.opacity = '0';
                lines[0].style.transform = '';
                lines[1].style.opacity = '';
                lines[2].style.transform = '';
            }
        });
    })();
    </script>
</body>
</html>
