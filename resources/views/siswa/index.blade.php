<!DOCTYPE html>
<html>
<head>
    <title>Daftar Siswa</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 60%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        tr:nth-child(even) { background-color: #fafafa; }
    </style>
</head>
<body>
    <h2>Daftar Siswa Projek Sekolah</h2>
    
    <table>
        <thead>
            <tr>
                <th>No. Absen</th> <th>Nama</th>
                <th>NISN</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach($list_siswa as $s)
            <tr>
                <td>{{ $s->nomor_absen }}</td> <td>{{ $s->nama }}</td>
                <td>{{ $s->nisn }}</td>
                <td>{{ $s->kelas }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>