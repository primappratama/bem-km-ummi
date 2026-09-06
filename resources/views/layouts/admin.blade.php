<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') &mdash; Admin BEM KM UMMI</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="h-full font-sans antialiased bg-mist" style="font-family:'Plus Jakarta Sans',sans-serif;">

@php
    $user  = auth()->user();
    $role  = $user->role;
    $isAdmin      = $user->isAdmin();
    $isSekretaris = $user->isSekretaris();
    $isBendahara  = $user->isBendahara();
    $isKementerian = $user->isKementerian();

    $navItems = [
        [
            'label'   => 'Dashboard',
            'icon'    => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6',
            'route'   => 'admin.dashboard',
            'allowed' => ['super_admin','sekretaris','bendahara','kementerian'],
        ],
        [
            'label'   => 'Data Pengurus',
            'icon'    => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
            'route'   => 'admin.pengurus.index',
            'allowed' => ['super_admin','sekretaris'],
        ],
        [
            'label'   => 'Kementerian',
            'icon'    => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
            'route'   => 'admin.kementerian.index',
            'allowed' => ['super_admin'],
        ],
        [
            'label'   => 'Program Kerja',
            'icon'    => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01',
            'route'   => 'admin.program-kerja.index',
            'allowed' => ['super_admin','sekretaris','kementerian'],
        ],
        [
            'label'   => 'Keuangan',
            'icon'    => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'route'   => 'admin.keuangan.index',
            'allowed' => ['super_admin','bendahara'],
        ],
        [
            'label'   => 'Absensi',
            'icon'    => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
            'route'   => 'admin.absensi.index',
            'allowed' => ['super_admin','sekretaris','kementerian'],
        ],
        [
            'label'   => 'Aspirasi',
            'icon'    => 'M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z',
            'route'   => 'admin.aspirasi.index',
            'allowed' => ['super_admin','sekretaris'],
        ],
        [
            'label'   => 'Dokumen / LPJ',
            'icon'    => 'M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z',
            'route'   => 'admin.dokumen.index',
            'allowed' => ['super_admin','sekretaris','kementerian'],
        ],
        [
            'label'   => 'Profil Publik',
            'icon'    => 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
            'route'   => 'admin.profil.index',
            'allowed' => ['super_admin'],
        ],
        [
            'label'   => 'Pengaturan',
            'icon'    => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z',
            'route'   => 'admin.pengaturan.index',
            'allowed' => ['super_admin','sekretaris','bendahara','kementerian'],
        ],
    ];
@endphp

<div class="flex h-screen overflow-hidden">

    {{-- ===== SIDEBAR ===================================================== --}}
    <aside id="sidebar"
           class="fixed inset-y-0 left-0 z-40 flex flex-col w-64 shrink-0
                  transform -translate-x-full md:translate-x-0
                  transition-transform duration-300 ease-in-out"
           style="background: linear-gradient(180deg, #0D1A2D 0%, #102A52 100%);">

        {{-- Logo --}}
        <div class="flex items-center gap-3 px-5 py-5 border-b border-white/8">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-9 h-9 object-contain shrink-0">
            <div class="min-w-0">
                <p class="font-extrabold text-white text-sm truncate">BEM KM UMMI</p>
                <p class="text-[9px] font-mono-data text-orange/80 uppercase tracking-wider">Panel Admin</p>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-0.5">
            @foreach ($navItems as $item)
                @if (in_array($role, $item['allowed']))
                    @php
                        $isActive = request()->routeIs($item['route']);
                        $routeExists = \Illuminate\Support\Facades\Route::has($item['route']);
                    @endphp
                    @if ($routeExists)
                        <a href="{{ route($item['route']) }}"
                           class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                                  {{ $isActive
                                     ? 'bg-white/15 text-white font-semibold'
                                     : 'text-white/55 hover:text-white hover:bg-white/8' }}">
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-red' : 'text-white/40' }}"
                                 fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                            {{ $item['label'] }}
                            @if ($isActive)
                                <span class="ml-auto w-1 h-4 rounded-full bg-red"></span>
                            @endif
                        </a>
                    @else
                        {{-- Route belum dibuat — tampil disabled --}}
                        <span class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium
                                     text-white/25 cursor-not-allowed select-none">
                            <svg class="w-5 h-5 shrink-0 text-white/15"
                                 fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                            </svg>
                            {{ $item['label'] }}
                            <span class="ml-auto text-[9px] font-mono-data text-white/20">soon</span>
                        </span>
                    @endif
                @endif
            @endforeach
        </nav>

        {{-- User info + Logout --}}
        <div class="border-t border-white/8 px-4 py-4">
            <div class="flex items-center gap-3 mb-3">
                {{-- Avatar initials --}}
                <div class="w-8 h-8 rounded-full bg-red/20 border border-red/30 flex items-center justify-center shrink-0">
                    <span class="text-xs font-bold text-red">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ $user->name }}</p>
                    <p class="text-[10px] text-white/40 truncate">{{ $user->role_label }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-xs font-medium
                               text-white/40 hover:text-white hover:bg-white/8 transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- Sidebar overlay (mobile) --}}
    <div id="sidebar-overlay"
         class="fixed inset-0 z-30 bg-black/50 hidden md:hidden"
         onclick="closeSidebar()"></div>

    {{-- ===== MAIN CONTENT ================================================= --}}
    <div class="flex-1 flex flex-col min-w-0 md:ml-64">

        {{-- Topbar --}}
        <header class="sticky top-0 z-20 flex items-center justify-between px-4 sm:px-6 h-16 border-b border-slate-100"
                style="background: rgba(245,247,255,0.90); backdrop-filter: blur(16px);">

            {{-- Mobile: hamburger --}}
            <button id="sidebar-toggle"
                    onclick="toggleSidebar()"
                    class="md:hidden flex items-center justify-center w-9 h-9 rounded-lg hover:bg-slate-100 transition-colors">
                <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            {{-- Page title --}}
            <div class="flex items-center gap-2">
                <h1 class="font-bold text-navy text-base">@yield('page-title', 'Dashboard')</h1>
                @hasSection('page-subtitle')
                    <span class="text-slate-300">·</span>
                    <span class="text-sm text-slate-400">@yield('page-subtitle')</span>
                @endif
            </div>

            {{-- Right: role badge + user --}}
            <div class="flex items-center gap-3">
                <span class="hidden sm:inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold {{ $user->role_color }}">
                    {{ $user->role_label }}
                </span>
                <div class="w-8 h-8 rounded-full bg-red/15 border border-red/20 flex items-center justify-center">
                    <span class="text-xs font-bold text-red">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">

            {{-- Flash messages --}}
            @if (session('success'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-green-50 border border-green-100 text-green-700 text-sm">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-5 flex items-center gap-3 px-4 py-3 rounded-xl bg-red/5 border border-red/10 text-red text-sm">
                    <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

{{-- Sidebar toggle JS --}}
<script>
function toggleSidebar() {
    const sidebar  = document.getElementById('sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    const open     = ! sidebar.classList.contains('-translate-x-full');
    if (open) { closeSidebar(); } else { openSidebar(); }
}
function openSidebar() {
    document.getElementById('sidebar').classList.remove('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.remove('hidden');
}
function closeSidebar() {
    document.getElementById('sidebar').classList.add('-translate-x-full');
    document.getElementById('sidebar-overlay').classList.add('hidden');
}
</script>

@stack('scripts')
</body>
</html>
