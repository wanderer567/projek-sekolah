<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Absensi Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <div class="bg-indigo-900 text-white w-64 py-6 px-4 fixed h-full">
            <h1 class="text-2xl font-bold mb-10 text-center">E-ABSEN</h1>
            <nav>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 bg-indigo-700 mb-2">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-2">
                    <i class="fas fa-user-graduates mr-2"></i> Data Siswa
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700 mb-2">
                    <i class="fas fa-clipboard-check mr-2"></i> Absensi
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-indigo-700">
                    <i class="fas fa-file-alt mr-2"></i> Laporan
                </a>
            </nav>
        </div>

        <div class="flex-1 ml-64 p-8">
            @yield('content')
        </div>
    </div>
</body>
</html>