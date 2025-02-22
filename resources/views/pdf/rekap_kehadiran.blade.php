<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Rekap Kehadiran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        .bg-warning {
            background-color: yellow;
        }

        .bg-info {
            background-color: lightblue;
        }

        .bg-danger {
            background-color: red;
        }

        .bg-primary {
            background-color: blue;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Rekap Kehadiran Siswa</h2>
    <p>Periode: {{ date('F Y', strtotime($startDate)) }}</p>

    <table>
        <thead>
            <tr>
                <th rowspan="2">NISN</th>
                <th rowspan="2">Nama</th>
                <th rowspan="2">Kelas</th>
                <th colspan="{{ (strtotime($endDate) - strtotime($startDate)) / 86400 + 1 }}">Tanggal</th>
                <th colspan="4">Total</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= date('t', strtotime($startDate)); $i++)
                    <th @if (date('w', strtotime("$startDate +" . ($i - 1) . ' days')) == 0) class="bg-warning" @endif>
                        {{ $i }}
                    </th>
                @endfor
                <th class="bg-primary">S</th>
                <th class="bg-info">I</th>
                <th class="bg-danger">A</th>
                <th class="bg-warning">T</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $row)
                <tr>
                    <td>{{ $row['nisn'] }}</td>
                    <td>{{ $row['name'] }}</td>
                    <td>{{ $row['kelas'] }}</td>
                    @foreach ($row['rekap'] as $status)
                        <td>{{ $status }}</td>
                    @endforeach
                    <td>{{ $row['summary']['S'] }}</td>
                    <td>{{ $row['summary']['I'] }}</td>
                    <td>{{ $row['summary']['A'] }}</td>
                    <td>{{ $row['summary']['T'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ (strtotime($endDate) - strtotime($startDate)) / 86400 + 1 }}" class="text-center">
                        Data tidak
                        ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
