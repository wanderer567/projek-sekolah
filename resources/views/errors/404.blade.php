<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Maintenance - E-ABSEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f3f4f9; }
        .error-card { background: white; border-radius: 30px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04); }
        .btn-back { background-color: #2d336b; transition: all 0.3s ease; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full text-center p-10 error-card">
        <div class="mb-8 flex justify-center">
            <svg width="180" height="180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" fill="#F1F5F9" stroke="#2d336b" stroke-width="8"/>
                <path d="M60 100C65 110 85 110 90 100" stroke="#2d336b" stroke-width="8" stroke-linecap="round"/>
                <path d="M110 100C115 110 135 110 140 100" stroke="#2d336b" stroke-width="8" stroke-linecap="round"/>
                <circle cx="100" cy="140" r="10" fill="#2d336b"/>
                <text x="145" y="60" fill="#2d336b" font-weight="bold" font-size="24">Z</text>
                <text x="165" y="45" fill="#2d336b" font-weight="bold" font-size="16">z</text>
            </svg>
        </div>
        <h1 class="text-4xl font-bold text-slate-800 mb-2">Maintenance</h1>
        <h2 class="text-xl font-semibold text-slate-600 mb-4 tracking-tight">Sistem Sedang Istirahat</h2>
        <p class="text-slate-400 mb-10 leading-relaxed text-sm px-4">
            Kami sedang melakukan pemeliharaan rutin untuk meningkatkan layanan E-ABSEN. Kami akan segera kembali!
        </p>
        <div class="text-sm font-medium text-slate-500 italic">
            — Devloper
        </div>
    </div>
</body>
</html>