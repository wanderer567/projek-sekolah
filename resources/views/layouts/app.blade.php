<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <div class="bg-indigo-900 text-white w-64 py-6 px-4 fixed h-full">
            <h1 class="text-2xl font-bold mb-10 text-center">E-ABSEN</h1>
            <nav>
                <p class="px-4 text-xs font-semibold text-indigo-300 uppercase mb-2">Menu Utama</p>
                <a href="/dashboard" class="block py-2.5 px-4 rounded transition duration-200 bg-indigo-700 mb-6">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                
                <p class="px-4 text-xs font-semibold text-indigo-300 uppercase mb-2">Filter Absensi</p>
                <a href="?range=hari" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-2">
                    <i class="fas fa-calendar-day mr-2"></i> Hari Ini
                </a>
                <a href="?range=minggu" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-2">
                    <i class="fas fa-calendar-week mr-2"></i> Minggu Ini
                </a>
                <a href="?range=bulan" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-2">
                    <i class="fas fa-calendar-alt mr-2"></i> Bulan Ini
                </a>
                <a href="?range=semester" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-2">
                    <i class="fas fa-graduation-cap mr-2"></i> Semester Ini
                </a>
            </nav>
        </div>

        <div class="flex-1 ml-64 p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>