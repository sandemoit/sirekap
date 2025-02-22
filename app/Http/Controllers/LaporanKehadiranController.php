<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Kehadiran;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKehadiranController extends Controller
{
    public function index()
    {
        $title = 'Rekap Kehadiran Siswa';
        $kelas = Classes::select('id', 'name')->get();
        return view('user.report.kehadiran', compact('title', 'kelas'));
    }

    public function exportPDF(Request $request)
    {
        $kelasFilter = $request->query('kelas', 'all');

        $bulan = $request->query('bulan', date('m'));
        $tahun = $request->query('tahun', date('Y'));

        $startDate = date("$tahun-$bulan-01");
        $endDate = date("$tahun-$bulan-t");

        // Ambil data siswa & kehadiran
        $query = Kehadiran::with(['student:id,nisn,name,class_id', 'class:id,name'])
            ->select('student_id', 'date', 'status')
            ->whereBetween('date', [$startDate, $endDate])
            ->whereIn('status', ['S', 'I', 'A', 'T']); // Hanya status tertentu

        if ($kelasFilter !== 'all') {
            $query->whereHas('student', function ($q) use ($kelasFilter) {
                $q->where('class_id', $kelasFilter);
            });
        }

        $kehadiran = $query->get()->groupBy('student_id');

        // Proses data ke format laporan
        $data = $kehadiran->map(function ($item, $key) use ($startDate, $endDate) {
            $siswa = Student::find($key);
            $daysRange = range(1, date('t', strtotime($startDate)));

            $rekap = [];
            foreach ($daysRange as $day) {
                $currentDate = date("Y-m-$day");
                $status = $item->firstWhere('date', $currentDate)?->status ?? '-';
                $rekap[$day] = $status;
            }

            return [
                'nisn' => $siswa->nisn,
                'name' => $siswa->name,
                'kelas' => $siswa->class->name,
                'rekap' => $rekap,
                'summary' => [
                    'S' => $item->where('status', 'S')->count(),
                    'I' => $item->where('status', 'I')->count(),
                    'A' => $item->where('status', 'A')->count(),
                    'T' => $item->where('status', 'T')->count()
                ]
            ];
        });

        $data = compact('data', 'startDate', 'endDate');

        $pdf = Pdf::loadView('pdf.rekap_kehadiran', $data);
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download("Rekap_Kehadiran_{$bulan}_{$tahun}.pdf");
    }

    public function exportPDFPersen(Request $request)
    {
        $kelasId = $request->query('kelas', 'all');

        $bulan = $request->query('bulan', date('m'));
        $tahun = $request->query('tahun', date('Y'));

        // Hitung jumlah hari aktif dalam bulan (tanpa Minggu)
        $start = Carbon::create($tahun, $bulan, 1);
        $end = $start->copy()->endOfMonth();
        $jumlah_hari_aktif = $start->diffInDaysFiltered(fn($date) => $date->dayOfWeek != Carbon::SUNDAY, $end);

        // Ambil data siswa sesuai filter
        $query = Student::with(['kehadiran' => function ($q) use ($bulan, $tahun) {
            $q->whereMonth('date', $bulan)
                ->whereYear('date', $tahun);
        }, 'class'])
            ->select('id', 'name', 'class_id', 'nisn');

        if ($kelasId !== 'all') {
            $query->where('class_id', $kelasId);
        }

        $siswaList = $query->get();

        // Hitung persen kehadiran tiap siswa
        $rekapSiswa = [];
        foreach ($siswaList as $siswa) {
            // Hitung jumlah tiap status
            $sakit = $siswa->kehadiran->where('status', 'S')->count();
            $ijin = $siswa->kehadiran->where('status', 'I')->count();
            $alpa = $siswa->kehadiran->where('status', 'A')->count();
            $terlambat = $siswa->kehadiran->where('status', 'T')->count();
            $hadir = $siswa->kehadiran->where('status', 'H')->count();

            // Hitung persen
            $rekapSiswa[] = [
                'nama' => $siswa->name,
                'kelas' => $siswa->class->name ?? '-',
                'sakit' => $jumlah_hari_aktif ? ($sakit / $jumlah_hari_aktif) * 100 : 0,
                'ijin' => $jumlah_hari_aktif ? ($ijin / $jumlah_hari_aktif) * 100 : 0,
                'alpa' => $jumlah_hari_aktif ? ($alpa / $jumlah_hari_aktif) * 100 : 0,
                'terlambat' => $jumlah_hari_aktif ? ($terlambat / $jumlah_hari_aktif) * 100 : 0,
                'kehadiran' => $jumlah_hari_aktif ? ($hadir / $jumlah_hari_aktif) * 100 : 0,
            ];
        }

        $pdf = Pdf::loadView('pdf.rekap_kehadiran_persen', compact('bulan', 'tahun', 'rekapSiswa', 'kelasId'));

        return $pdf->setPaper('a4', 'landscape')->download("Rekap_Kehadiran_Persen_$bulan-$tahun.pdf");
    }
}
