<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Kehadiran;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
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

        $pdf = PDF::loadView('pdf.rekap_kehadiran', compact('data', 'startDate', 'endDate'));
        return $pdf->setPaper('a4', 'landscape')->setWarnings(false)->download("Rekap_Kehadiran_{$bulan}_{$tahun}.pdf");
    }
}
