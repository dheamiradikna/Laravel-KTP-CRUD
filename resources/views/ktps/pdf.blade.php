<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data KTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <h1>Data KTP</h1>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Agama</th>
                <th>Status</th>
                <th>Pekerjaan</th>
                <th>Umur</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ktps as $index => $ktp)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ktp->nik }}</td>
                    <td>{{ $ktp->nama }}</td>
                    <td>{{ $ktp->tempat_lahir }}, {{ \Carbon\Carbon::parse($ktp->tanggal_lahir)->format('d-m-Y') }}</td>
                    <td>{{ $ktp->jenis_kelamin }}</td>
                    <td>{{ $ktp->alamat }}, RT/RW {{ $ktp->rt_rw }}, {{ $ktp->kelurahan_desa }}, {{ $ktp->kecamatan }}</td>
                    <td>{{ $ktp->agama }}</td>
                    <td>{{ $ktp->status_perkawinan }}</td>
                    <td>{{ $ktp->pekerjaan }}</td>
                    <td>{{ $ktp->umur }} tahun</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
