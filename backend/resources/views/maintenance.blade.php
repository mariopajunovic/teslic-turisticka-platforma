<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $brand ?? 'Teslić' }} - U pripremi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary:#0E8275; --primary-dark:#0A645A; --primary-darker:#06443D;
            --tint:#E1F4F1; --secondary:#C8D848; --white:#fff;
        }
        * { box-sizing:border-box; margin:0; padding:0; }
        html, body { height:100%; }
        body {
            font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif;
            color:var(--white);
            background:var(--primary-darker);
            min-height:100vh;
            display:flex; flex-direction:column;
            align-items:center; justify-content:center;
            padding:32px 24px;
            position:relative; overflow:hidden;
            -webkit-font-smoothing:antialiased;
        }
        .glow {
            position:absolute; border-radius:50%; filter:blur(90px); pointer-events:none; z-index:0;
        }
        .glow-1 { width:520px; height:520px; background:rgba(14,130,117,.55); top:-160px; right:-140px; }
        .glow-2 { width:420px; height:420px; background:rgba(200,216,72,.20); bottom:-160px; left:-120px; }
        .glow-3 { width:360px; height:360px; background:rgba(14,130,117,.35); bottom:-120px; right:10%; }

        .wrap {
            position:relative; z-index:1;
            max-width:560px; width:100%; text-align:center;
            display:flex; flex-direction:column; align-items:center;
        }
        .logo-card {
            display:inline-flex; align-items:center; justify-content:center;
            background:var(--white); border-radius:26px;
            padding:24px 30px;
            box-shadow:0 20px 50px rgba(0,0,0,.28);
            margin-bottom:32px;
        }
        .logo-card img { display:block; height:110px; width:auto; max-width:340px; object-fit:contain; }

        .badge {
            display:inline-flex; align-items:center; gap:9px;
            background:rgba(255,255,255,.10); color:var(--white);
            border:1px solid rgba(255,255,255,.16);
            font-size:13px; font-weight:600; letter-spacing:.2px;
            padding:8px 16px; border-radius:999px; margin-bottom:22px;
        }
        .dot { width:9px; height:9px; border-radius:50%; background:var(--secondary); box-shadow:0 0 0 0 rgba(200,216,72,.6); animation:pulse 1.8s infinite; }
        @keyframes pulse {
            0% { box-shadow:0 0 0 0 rgba(200,216,72,.55); }
            70% { box-shadow:0 0 0 12px rgba(200,216,72,0); }
            100% { box-shadow:0 0 0 0 rgba(200,216,72,0); }
        }

        h1 {
            font-size:clamp(28px, 5vw, 42px); font-weight:800;
            line-height:1.12; letter-spacing:-.5px; margin-bottom:16px;
        }
        .msg {
            color:var(--tint); font-size:clamp(15px,2vw,17px); line-height:1.65;
            max-width:460px; margin:0 auto 30px;
        }
        .contact {
            display:inline-flex; align-items:center; gap:10px;
            background:var(--white); color:var(--primary-darker);
            font-size:15px; font-weight:700; text-decoration:none;
            padding:13px 22px; border-radius:12px;
            transition:transform .15s ease, box-shadow .15s ease;
            box-shadow:0 8px 24px rgba(0,0,0,.18);
        }
        .contact:hover { transform:translateY(-1px); box-shadow:0 12px 30px rgba(0,0,0,.24); }
        .contact svg { width:18px; height:18px; }

        footer {
            position:relative; z-index:1;
            margin-top:44px; color:rgba(255,255,255,.55); font-size:13px;
        }

        @media (max-width:520px) {
            .logo-card { padding:20px 24px; border-radius:22px; }
            .logo-card img { height:88px; max-width:76vw; }
        }
    </style>
</head>
<body>
    <span class="glow glow-1"></span>
    <span class="glow glow-2"></span>
    <span class="glow glow-3"></span>

    <main class="wrap">
        <div class="logo-card">
            <img src="{{ $logo }}" alt="{{ $brand ?? 'Teslić' }}">
        </div>

        <span class="badge"><span class="dot"></span> Uskoro se vraćamo</span>

        <h1>Radimo na poboljšanjima</h1>

        <p class="msg">{{ $poruka ?: 'Sajt je trenutno u pripremi. Uskoro ćemo biti ponovo dostupni sa novim sadržajem.' }}</p>

        @if (!empty($email))
            <a class="contact" href="mailto:{{ $email }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                {{ $email }}
            </a>
        @endif
    </main>

    <footer>&copy; {{ date('Y') }} {{ $brand ?? 'Teslić' }}</footer>
</body>
</html>
