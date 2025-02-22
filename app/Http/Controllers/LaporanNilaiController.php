<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanNilaiController extends Controller
{
    public function index(Request $request)
    {
        $classes = Classes::all();
        $title = "Rekap Nilai Siswa";
        return view('user.report.nilai', compact('classes', 'title'));
    }

    public function exportLaporanNilai(Request $request)
    {
        $kelas = $request->input('kelas');
        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');

        $query = Student::with(['class', 'assessments.subject'])
            ->whereHas('assessments', function ($q) use ($bulan, $tahun) {
                if ($bulan) $q->whereMonth('date', $bulan);
                if ($tahun) $q->whereYear('date', $tahun);
            });

        if ($kelas) $query->where('class_id', $kelas);

        $students = $query->get();

        if ($students->isEmpty()) {
            return back()->with('error', 'Data tidak ditemukan!');
        }

        $studentsByClass = $students->groupBy('class_id')->map(function ($students) {
            return $students->map(function ($student) {
                $student->average_score = $student->assessments->avg('score') ?? 0; // Pastikan tidak null
                return $student;
            })->sortByDesc('average_score')->values();
        });


        $data = compact('studentsByClass', 'bulan', 'tahun');

        // Cek apakah ada data sebelum generate PDF
        if (empty($studentsByClass->toArray())) {
            return back()->with('error', 'Tidak ada data yang bisa diekspor.');
        }

        $pdf = PDF::loadView('pdf.rekap_nilai', $data);
        return $pdf->download('Laporan_Nilai.pdf');
    }
}
