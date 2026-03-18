<table border="1">
    <thead>
        <tr>
            <th>No Absen</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>QR Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($absens as $absen)
        <tr>
            <td>{{ $absen->siswa->nomor_absen }}</td>
            <td>{{ $absen->siswa->nama }}</td>
            <td>{{ $absen->siswa->kelas->nama_kelas }}</td>
            <td>{{ $absen->code_qr }}</td>
        </tr>
        @endforeach
    </tbody>
</table>



