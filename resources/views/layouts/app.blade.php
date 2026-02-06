<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <div class="bg-indigo-900 text-white w-64 py-6 px-4 fixed h-full shadow-xl">
            <h1 class="text-2xl font-bold mb-10 text-center tracking-wider">E-ABSEN</h1>
            
            <nav class="space-y-2">
                <p class="px-4 text-[10px] font-semibold text-indigo-300 uppercase mb-4 tracking-widest">Menu</p>
                <a href="/dashboard" class="flex items-center py-3 px-4 rounded-xl transition duration-200 bg-white text-indigo-900 font-bold shadow-lg">
                    <i class="fas fa-chalkboard-teacher mr-3"></i> Dashboard Guru
                </a>
            </nav>

            <div class="absolute bottom-10 left-0 w-full px-8">
                <a href="/logout" class="flex items-center text-sm text-indigo-300 hover:text-white transition">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar Sistem
                </a>
            </div>
        </div>

        <div class="flex-1 ml-64 p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>