<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Kehadiran Persentase</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>

    <h3 style="text-align: center;">Rekap Kehadiran Siswa - {{ DateTime::createFromFormat('!m', $bulan)->format('F') }}
        {{ $tahun }}</h3>
    <p style="text-align: center;">Kelas: {{ $kelasId === 'all' ? 'Semua Kelas' : $kelasId }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Sakit (%)</th>
                <th>Izin (%)</th>
                <th>Alpa (%)</th>
                <th>Terlambat (%)</th>
                <th>Kehadiran (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekapSiswa as $data)
                <tr>
                    <td>{{ $data['nama'] }}</td>
                    <td>{{ $data['kelas'] }}</td>
                    <td>{{ number_format($data['sakit'], 2) }}</td>
                    <td>{{ number_format($data['ijin'], 2) }}</td>
                    <td>{{ number_format($data['alpa'], 2) }}</td>
                    <td>{{ number_format($data['terlambat'], 2) }}</td>
                    <td><strong>{{ number_format($data['kehadiran'], 2) }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
