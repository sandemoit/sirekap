<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Nilai Siswa</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
    </style>
</head>

<body>
    <h2 align="center">Laporan Nilai Siswa</h2>
    <p align="center">Bulan: {{ $bulan }} | Tahun Ajaran: {{ $tahun }}</p>

    @foreach ($studentsByClass as $classId => $students)
        <h3>Kelas: {{ $students->first()->class->name }}</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid black; padding: 8px;">Ranking</th>
                    <th style="border: 1px solid black; padding: 8px;">Nama</th>
                    <th style="border: 1px solid black; padding: 8px;">NISN</th>
                    <th style="border: 1px solid black; padding: 8px;">Rata-rata</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $rank => $student)
                    <tr>
                        <td style="border: 1px solid black; padding: 8px; text-align: center;">{{ $rank + 1 }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $student->name }}</td>
                        <td style="border: 1px solid black; padding: 8px;">{{ $student->nisn }}</td>
                        <td style="border: 1px solid black; padding: 8px; text-align: center;">
                            {{ number_format($student->average_score, 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
