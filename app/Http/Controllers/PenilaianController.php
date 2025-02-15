<?php

namespace App\Http\Controllers;

use App\Imports\AssessmentsImport;
use App\Models\Assessments;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subjects;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PenilaianController extends Controller
{
    public function input()
    {
        $user = Auth::user();
        $kelasQuery = Classes::select('id', 'name');

        if ($user->role === 'guru') {
            $kelasQuery->where('teacher_id', $user->id);
        }

        $kelas = $kelasQuery->get();

        $mapel = Subjects::select('id', 'name')->get();

        $title = 'Input Penilaian';

        return view('user.penilaian.input', compact('title', 'kelas', 'mapel'));
    }

    // get data siswa ke frontend
    public function getSiswa(Request $request)
    {
        $siswa = Student::where('class_id', $request->kelas_id)->get();
        return response()->json($siswa);
    }

    public function store(Request $request)
    {
        try {
            $tanggal = Carbon::parse($request->tanggal);

            // Debugging untuk melihat struktur request
            if (empty($request->nilai) || !is_array($request->nilai)) {
                throw new \Exception('Data penilaian kosong atau tidak valid.');
            }

            foreach ($request->nilai as $siswa_id => $nilai) {
                if (!is_numeric($nilai)) {
                    throw new \Exception("Nilai untuk siswa ID $siswa_id tidak valid.");
                }

                // Cek apakah data penilaian sudah ada
                $existingPenilaian = Assessments::where([
                    'date' => $tanggal,
                    'student_id' => $siswa_id,
                    'class_id' => $request->kelas_id,
                    'subject_id' => $request->mapel_id,
                    'assessment_name' => $request->nama_penilaian,
                ])->first();

                if ($existingPenilaian) {
                    throw new \Exception("Data penilaian untuk siswa ID $siswa_id sudah ada.");
                }

                Assessments::create([
                    'date' => $tanggal,
                    'student_id' => $siswa_id,
                    'class_id' => $request->kelas_id,
                    'subject_id' => $request->mapel_id,
                    'assessment_name' => $request->nama_penilaian,
                    'score' => $nilai,
                    'semester' => configWeb('semester')->value,
                ]);
            }

            return redirect()->back()->with('success', 'Data penilaian berhasil disimpan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function import()
    {
        $title = 'Import Penilaian Siswa';
        return view('user.penilaian.import', compact('title'));
    }

    public function importProcess(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            Excel::import(new AssessmentsImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data nilai berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data nilai: ' . $e->getMessage());
        }
    }
}
