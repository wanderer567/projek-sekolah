<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Error - E-ABSEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f9; }
        .error-card { background: white; border-radius: 30px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04); }
        .btn-back { background-color: #2d336b; transition: all 0.3s ease; }
        .btn-back:hover { background-color: #1e234a; transform: translateY(-2px); }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center p-10 error-card">
        <div class="mb-8 flex justify-center">
            <svg width="180" height="180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" fill="#F1F5F9" stroke="#2d336b" stroke-width="8"/>
                <path d="M60 95C60 85 85 85 85 95C85 105 65 105 65 95C65 90 80 90 80 95" stroke="#2d336b" stroke-width="5" stroke-linecap="round"/>
                <path d="M115 95C115 85 140 85 140 95C140 105 120 105 120 95C120 90 135 90 135 95" stroke="#2d336b" stroke-width="5" stroke-linecap="round"/>
                <path d="M80 140L90 130L100 140L110 130L120 140" stroke="#2d336b" stroke-width="8" stroke-linecap="round"/>
            </svg>
        </div>
        <h1 class="text-7xl font-bold text-slate-800 mb-2">500</h1>
        <h2 class="text-xl font-semibold text-slate-600 mb-4 tracking-tight">Ups! Server Sedang Pusing</h2>
        <p class="text-slate-400 mb-10 leading-relaxed text-sm px-4">
            Terjadi kesalahan internal pada sistem kami. Tim teknis sedang berusaha memperbaikinya. Mohon tunggu sebentar.
        </p>
        <a href="{{ url('/') }}" class="btn-back text-white px-10 py-3.5 rounded-2xl inline-block font-semibold text-sm">
            Coba Lagi Nanti
        </a>
    </div>
</body>
</html>