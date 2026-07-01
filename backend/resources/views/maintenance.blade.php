<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ $brand ?? 'teslić' }} — Održavanje</title>
    <style>
        :root { --primary:#0E8275; --primary-dark:#0A645A; --heading:#12151C; --muted:#5C6573; --border:#DCE0E6; --bg:#F6F3EC; --surface:#fff; --error:#C62828; --error-bg:#FBE3E3; }
        * { box-sizing:border-box; margin:0; padding:0; }
        body { font-family:'Inter',system-ui,-apple-system,Segoe UI,Roboto,sans-serif; background:var(--bg); color:var(--heading); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
        .card { background:var(--surface); border:1px solid var(--border); border-radius:16px; box-shadow:0 10px 40px rgba(14,24,40,.08); max-width:440px; width:100%; padding:40px 36px; text-align:center; }
        .logo { font-weight:800; font-size:28px; letter-spacing:-.5px; color:var(--primary); margin-bottom:20px; }
        .badge { display:inline-flex; align-items:center; gap:8px; background:#E1F4F1; color:var(--primary-dark); font-size:13px; font-weight:700; padding:6px 14px; border-radius:999px; margin-bottom:18px; }
        h1 { font-size:24px; font-weight:800; margin-bottom:10px; }
        .msg { color:var(--muted); font-size:15px; line-height:1.6; margin-bottom:24px; }
        form { display:flex; flex-direction:column; gap:12px; }
        input { width:100%; padding:12px 14px; border:1px solid var(--border); border-radius:8px; font-size:15px; background:var(--bg); }
        input:focus { outline:none; border-color:var(--primary); background:#fff; }
        button { width:100%; padding:13px; border:0; border-radius:8px; background:var(--primary); color:#fff; font-weight:700; font-size:15px; cursor:pointer; transition:background .15s; }
        button:hover { background:var(--primary-dark); }
        .err { background:var(--error-bg); color:var(--error); font-size:14px; font-weight:600; padding:10px 14px; border-radius:8px; margin-bottom:16px; }
        .hint { color:var(--muted); font-size:12px; margin-top:16px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="logo">{{ $brand ?? 'teslić' }}</div>
        <div class="badge">● U pripremi</div>
        <h1>Sajt je privremeno u pripremi</h1>
        <p class="msg">{{ $poruka }}</p>

        @if ($greska)
            <div class="err">{{ $greska }}</div>
        @endif

        <form method="POST" action="{{ url('/odrzavanje/otkljucaj') }}">
            @csrf
            <input type="password" name="lozinka" placeholder="Lozinka za pristup" autofocus autocomplete="off">
            <button type="submit">Otključaj pristup</button>
        </form>

        <p class="hint">Pristup ostaje otključan {{ $minuta ?? 120 }} min na ovom uređaju.</p>
    </div>
</body>
</html>
