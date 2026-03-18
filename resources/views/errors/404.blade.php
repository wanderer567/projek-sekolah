<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan - E-ABSEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f3f4f9; /* Abu-abu muda sesuai background dashboard */
        }
        .error-card {
            background: white;
            border-radius: 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        }
        .btn-back {
            background-color: #2d336b; /* Warna biru tua sidebar Anda */
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #1e234a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(45, 51, 107, 0.3);
        }
        .icon-container svg {
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.08));
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full text-center p-10 error-card">
        <div class="icon-container mb-8 flex justify-center">
            <svg width="180" height="180" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="80" fill="#F1F5F9" stroke="#2d336b" stroke-width="8"/>
                
                <path d="M70 85L90 105M90 85L70 105" stroke="#2d336b" stroke-width="8" stroke-linecap="round"/>
                
                <path d="M110 85L130 105M130 85L110 105" stroke="#2d336b" stroke-width="8" stroke-linecap="round"/>
                
                <path d="M70 150C70 150 85 135 100 135C115 135 130 150 130 150" stroke="#2d336b" stroke-width="8" stroke-linecap="round"/>
                
        </div>

        <h1 class="text-7xl font-bold text-slate-800 mb-2">404</h1>
        <h2 class="text-xl font-semibold text-slate-600 mb-4 tracking-tight">Waduh! Halaman Tidak Ditemukan</h2>
        <p class="text-slate-400 mb-10 leading-relaxed text-sm px-4">
            Halaman yang Anda cari tidak ditemukan. Mungkin Anda salah mengetik alamat atau halaman telah dipindahkan.
        </p>
        
        <a href="{{ url('/') }}" class="btn-back text-white px-10 py-3.5 rounded-2xl inline-block font-semibold text-sm">
            Kembali ke Dashboard
        </a>
    </div>

</body>
</html>