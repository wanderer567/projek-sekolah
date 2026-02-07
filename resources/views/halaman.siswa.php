<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            background: #f1f5f9;
            display: flex;
        }

        /* SIDEBAR */
        .sidebar {
            width: 240px;
            background: #0f172a;
            color: white;
            min-height: 100vh;
        }

        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .sidebar-header img {
            width: 60px;
            margin-bottom: 10px;
        }

        .sidebar-header h3 {
            margin: 0;
            font-size: 15px;
        }

        .sidebar-header span {
            font-size: 12px;
            color: #94a3b8;
        }

        .menu {
            padding: 10px;
        }

        .menu a {
            display: block;
            padding: 12px 15px;
            color: #cbd5e1;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 14px;
        }

        .menu a:hover,
        .menu a.active {
            background: #1e293b;
            color: white;
        }

        /* MAIN */
        .main {
            flex: 1;
        }

        .header {
            background: linear-gradient(135deg, #06b6d4, #0ea5e9);
            color: white;
            padding: 18px 25px;
            font-size: 18px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
        }

        .title {
            text-align: center;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,.08);
            cursor: pointer;
            transition: .2s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0,0,0,.12);
        }

        .card span {
            font-size: 36px;
            display: block;
            margin-bottom: 10px;
        }

        .card h4 {
            margin: 0;
            color: #1e293b;
        }

        .card p {
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-header">
        <img src="{{ asset('images/logo.png') }}">
        <h3>DIVO ENRUL PRATAMA</h3>
        <span>XI RPL 1</span>
    </div>

    <div class="menu">
        <a class="active">Dashboard</a>
        <a>Informasi Sekolah</a>
        <a>Absen Sekolah</a>
        <a>Absen Mapel</a>
        <a>Materi Siswa</a>
        <a>Tugas Siswa</a>
        <a>Hasil Ujian</a>
    </div>
</div>

<!-- MAIN -->
<div class="main">
    <div class="header">
        MENU E-LEARNING SISWA
    </div>

    <div class="content">
        <h2 class="title">Dashboard Siswa</h2>

        <div class="grid">
            <div class="card">
                <span>📝</span>
                <h4>Absen Sekolah</h4>
                <p>Isi kehadiran harian</p>
            </div>

            <div class="card">
                <span>📚</span>
                <h4>Materi Siswa</h4>
                <p>Download materi pelajaran</p>
            </div>

            <div class="card">
                <span>📂</span>
                <h4>Tugas Siswa</h4>
                <p>Kumpulkan tugas</p>
            </div>

            <div class="card">
                <span>📊</span>
                <h4>Hasil Ujian</h4>
                <p>Lihat nilai ujian</p>
            </div>
        </div>
    </div>
</div>

</body>
</html>
