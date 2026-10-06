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
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .bg-login {
            background: #07121F;
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }

        /* Orbs dekoratif */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            pointer-events: none;
        }
        .orb-1 { width: 500px; height: 500px; background: rgba(240,135,30,0.18); top: -120px; right: -120px; }
        .orb-2 { width: 400px; height: 400px; background: rgba(16,42,82,0.7);   bottom: -100px; left: -100px; }
        .orb-3 { width: 280px; height: 280px; background: rgba(122,21,21,0.2);  top: 40%; left: 10%; }

        .login-card {
            background: rgba(255,255,255,0.055);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(255,255,255,0.10);
            border-radius: 24px;
            box-shadow: 0 32px 80px rgba(0,0,0,0.5), 0 0 0 1px rgba(255,255,255,0.04) inset;
        }

        .input-field {
            width: 100%;
            padding: 13px 16px;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            color: #fff;
            background: rgba(255,255,255,0.07);
            border: 1.5px solid rgba(255,255,255,0.10);
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .input-field::placeholder { color: rgba(255,255,255,0.22); }
        .input-field:focus {
            background: rgba(255,255,255,0.10);
            border-color: rgba(240,135,30,0.6);
            box-shadow: 0 0 0 3px rgba(240,135,30,0.12);
        }
        .input-field.error {
            border-color: rgba(231,50,50,0.7);
            box-shadow: 0 0 0 3px rgba(231,50,50,0.10);
        }
        .input-wrapper { position: relative; }
        .input-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: rgba(255,255,255,0.3);
            pointer-events: none;
        }
        .input-field.has-icon { padding-left: 42px; }
        .btn-toggle-pw {
            position: absolute;
            right: 12px; top: 50%;
            transform: translateY(-50%);
            background: none; border: none;
            color: rgba(255,255,255,0.28);
            cursor: pointer; padding: 4px;
            transition: color .2s;
        }
        .btn-toggle-pw:hover { color: rgba(255,255,255,0.7); }

        .btn-login {
            width: 100%;
            padding: 13px;
            border-radius: 12px;
            border: none;
            font-size: 14px;
            font-weight: 700;
            font-family: inherit;
            color: #fff;
            cursor: pointer;
            background: linear-gradient(135deg, #F0871E 0%, #E04E18 50%, #A83232 100%);
            box-shadow: 0 4px 24px rgba(240,135,30,0.35);
            transition: opacity .2s, transform .15s, box-shadow .2s;
        }
        .btn-login:hover { opacity: .92; box-shadow: 0 6px 32px rgba(240,135,30,0.45); }
        .btn-login:active { transform: scale(.98); }

        .label-field {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            margin-bottom: 7px;
        }

        .error-msg {
            font-size: 12px;
            color: #f87171;
            margin-top: 6px;
        }

        .divider {
            height: 1px;
            background: rgba(255,255,255,0.08);
            margin: 24px 0;
        }

        .badge-kabinet {
            display: inline-block;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: rgba(240,135,30,0.8);
            border: 1px solid rgba(240,135,30,0.25);
            border-radius: 20px;
            padding: 3px 10px;
            margin-bottom: 16px;
        }
    </style>
</head>
<body>
<div class="bg-login flex items-center justify-center p-4" style="min-height:100vh">

    {{-- Orbs --}}
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    {{-- Wrapper --}}
    <div style="width:100%; max-width:400px; position:relative; z-index:10">

        {{-- Logo & Judul --}}
        <div style="text-align:center; margin-bottom:28px">
            <img src="{{ asset('images/logo.png') }}" alt="Logo BEM KM UMMI"
                 style="width:68px; height:68px; object-fit:contain; margin:0 auto 16px; display:block;">
            <div class="badge-kabinet">Kabinet Revolusioner</div>
            <h1 style="font-size:22px; font-weight:800; color:#fff; margin:0 0 4px; line-height:1.2">
                BEM KM UMMI
            </h1>
            <p style="font-size:13px; color:rgba(255,255,255,0.35); margin:0">
                Universitas Muhammadiyah Sukabumi
            </p>
        </div>

        {{-- Card --}}
        <div class="login-card" style="padding:32px">

            <h2 style="font-size:16px; font-weight:700; color:#fff; margin:0 0 4px">
                Masuk ke Panel Admin
            </h2>
            <p style="font-size:13px; color:rgba(255,255,255,0.35); margin:0 0 24px">
                Gunakan username dan password akun kamu.
            </p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Username --}}
                <div style="margin-bottom:16px">
                    <label class="label-field">Username</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input type="text" name="username"
                               value="{{ old('username') }}"
                               required autofocus autocomplete="username"
                               placeholder="Masukkan username"
                               class="input-field has-icon {{ $errors->has('username') ? 'error' : '' }}">
                    </div>
                    @error('username')
                    <p class="error-msg">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div style="margin-bottom:20px">
                    <label class="label-field">Password</label>
                    <div class="input-wrapper">
                        <span class="input-icon">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </span>
                        <input type="password" name="password" id="pw"
                               required autocomplete="current-password"
                               placeholder="Masukkan password"
                               class="input-field has-icon" style="padding-right:42px">
                        <button type="button" class="btn-toggle-pw" onclick="togglePw()" id="pw-btn" aria-label="Toggle password">
                            <svg id="eye-show" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            <svg id="eye-hide" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div style="display:flex; align-items:center; gap:8px; margin-bottom:24px">
                    <input type="checkbox" name="remember" id="remember"
                           style="width:15px; height:15px; border-radius:4px; accent-color:#F0871E; cursor:pointer">
                    <label for="remember" style="font-size:13px; color:rgba(255,255,255,0.4); cursor:pointer; user-select:none">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit" class="btn-login">
                    Masuk ke Panel Admin
                </button>
            </form>

            <div class="divider"></div>

            <p style="text-align:center; font-size:12px; color:rgba(255,255,255,0.2); margin:0">
                <a href="{{ url('/') }}" style="color:rgba(240,135,30,0.6); text-decoration:none; font-weight:600">
                    ← Kembali ke Website
                </a>
            </p>
        </div>

        <p style="text-align:center; font-size:11px; color:rgba(255,255,255,0.15); margin-top:20px">
            &copy; {{ now()->year }} BEM KM UMMI &mdash; Kabinet Revolusioner
        </p>
    </div>
</div>

<script>
function togglePw() {
    const pw   = document.getElementById('pw');
    const show = document.getElementById('eye-show');
    const hide = document.getElementById('eye-hide');
    if (pw.type === 'password') {
        pw.type = 'text';
        show.style.display = 'none';
        hide.style.display = 'block';
    } else {
        pw.type = 'password';
        show.style.display = 'block';
        hide.style.display = 'none';
    }
}
</script>
</body>
</html>