<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login &mdash; BEM KM UMMI</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased" style="font-family:'Plus Jakarta Sans',sans-serif;">

    {{-- Background gradient dengan floating orbs --}}
    <div class="min-h-screen flex items-center justify-center px-4 py-12 relative overflow-hidden"
         style="background: linear-gradient(135deg, #06101E 0%, #102A52 55%, #0D1433 100%);">

        {{-- Orbs --}}
        <div class="pointer-events-none absolute -top-24 -left-24 w-96 h-96 rounded-full"
             style="background: radial-gradient(circle, rgba(227,30,48,0.20) 0%, transparent 70%); filter: blur(60px);"></div>
        <div class="pointer-events-none absolute bottom-0 -right-16 w-80 h-80 rounded-full"
             style="background: radial-gradient(circle, rgba(80,110,200,0.16) 0%, transparent 70%); filter: blur(60px);"></div>

        {{-- Login Card --}}
        <div class="w-full max-w-md relative">

            {{-- Logo + Title --}}
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo BEM KM UMMI"
                     class="w-14 h-14 mx-auto mb-4 object-contain drop-shadow-lg">
                <h1 class="text-2xl font-extrabold text-white tracking-tight">BEM KM UMMI</h1>
                <p class="text-sm text-white/50 mt-1 font-mono-data uppercase tracking-widest">Panel Admin</p>
            </div>

            {{-- Glass Card --}}
            <div class="glass-dark rounded-2xl p-8">

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-4 text-sm text-green-400 bg-green-500/10 border border-green-500/20 rounded-lg px-4 py-3">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">
                            Email
                        </label>
                        <input id="email" type="email" name="email"
                               value="{{ old('email') }}" required autofocus autocomplete="username"
                               class="w-full px-4 py-3 rounded-xl text-sm text-white placeholder-white/30
                                      bg-white/10 border border-white/15
                                      focus:outline-none focus:ring-2 focus:ring-red/50 focus:border-red/50
                                      transition-all duration-200"
                               placeholder="presiden@bemkm.ac.id">
                        @error('email')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-xs font-semibold text-white/60 uppercase tracking-wider mb-2">
                            Password
                        </label>
                        <input id="password" type="password" name="password"
                               required autocomplete="current-password"
                               class="w-full px-4 py-3 rounded-xl text-sm text-white placeholder-white/30
                                      bg-white/10 border border-white/15
                                      focus:outline-none focus:ring-2 focus:ring-red/50 focus:border-red/50
                                      transition-all duration-200"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-2 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                   class="w-4 h-4 rounded border-white/30 bg-white/10 text-red
                                          focus:ring-red/50 focus:ring-offset-0">
                            <span class="text-sm text-white/60">Ingat saya</span>
                        </label>
                        <a href="{{ url('/') }}"
                           class="text-xs text-white/40 hover:text-white/70 transition-colors">
                            ← Kembali ke website
                        </a>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full py-3 rounded-xl font-bold text-sm text-white
                                   bg-red hover:bg-maroon
                                   transition-all duration-200
                                   hover:shadow-lg hover:shadow-red/30 hover:-translate-y-0.5
                                   focus:outline-none focus:ring-2 focus:ring-red/50">
                        Masuk ke Panel Admin
                    </button>
                </form>

                {{-- Demo credentials hint --}}
                <div class="mt-6 pt-5 border-t border-white/10">
                    <p class="text-[10px] text-white/30 text-center font-mono-data uppercase tracking-wider mb-3">Demo Login</p>
                    <div class="grid grid-cols-2 gap-2 text-[10px] text-white/40 font-mono-data">
                        <div class="bg-white/5 rounded-lg p-2">
                            <p class="text-white/60 font-semibold mb-0.5">Admin</p>
                            <p>admin@bemkm.ac.id</p>
                        </div>
                        <div class="bg-white/5 rounded-lg p-2">
                            <p class="text-white/60 font-semibold mb-0.5">Sekretaris</p>
                            <p>sekretaris@bemkm.ac.id</p>
                        </div>
                        <div class="bg-white/5 rounded-lg p-2">
                            <p class="text-white/60 font-semibold mb-0.5">Bendahara</p>
                            <p>bendahara@bemkm.ac.id</p>
                        </div>
                        <div class="bg-white/5 rounded-lg p-2">
                            <p class="text-white/60 font-semibold mb-0.5">Kementerian</p>
                            <p>kemenlu@bemkm.ac.id</p>
                        </div>
                    </div>
                    <p class="text-center text-[10px] text-white/25 mt-2">password: <span class="text-white/40">password</span></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
