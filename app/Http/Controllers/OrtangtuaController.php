<?php

namespace App\Http\Controllers;

use App\Models\Assessments;
use App\Models\Kehadiran;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrtangtuaController extends Controller
{
    public function index()
    {
        if (Session::has('parent_authenticated')) {
            return redirect()->route('ortu.akademis');
        }

        $title = 'Login Orangtua';
        return view('user.orangtua.login', compact('title'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'nisn' => 'required|string',
            'birth_date' => 'required|date',
        ], [
            'nisn.required' => 'NISN wajib diisi',
            'birth_date.required' => 'Tanggal lahir wajib diisi',
            'birth_date.date' => 'Format tanggal lahir tidak sesuai'
        ]);

        $student = Student::validateParentCredentials(
            $request->nisn,
            $request->birth_date
        );

        // Cek NISN dulu
        if (!$student) {
            return back()->withErrors([
                'nisn' => 'NISN tidak ditemukan'
            ])->withInput();
        }

        // Jika NISN ada, cek tanggal lahir
        if ($student->birth_date != $request->birth_date) {
            return back()->withErrors([
                'birth_date' => 'Tanggal lahir tidak sesuai'
            ])->withInput();
        }

        // Jika semua sesuai, buat session
        Session::put('parent_authenticated', true);
        Session::put('student_id', $student->id);
        Session::put('student_name', $student->name);

        return redirect()->route('ortu.akademis')
            ->with('success', 'Login berhasil! Selamat datang orangtua dari ' . $student->name);
    }

    public function logout()
    {
        Session::forget(['parent_authenticated', 'student_id', 'student_name']);
        return redirect()->route('ortu.login')
            ->with('success', 'Berhasil logout');
    }

    public function akademis(Request $request)
    {
        if (!Session::has('parent_authenticated')) {
            return redirect()->route('ortu.login');
        }

        $start = $request->query('start', date('Y-m-01'));
        $end = $request->query('end', date('Y-m-d'));

        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $student = Student::with(['class', 'teacher'])
            ->find(Session::get('student_id'));

        // penilaian
        $queryPenilaian = Assessments::with(['subject', 'student:id',])
            ->WhereHas('student', function ($q) {
                $q->where('student_id', session('student_id'));
            })
            ->whereBetween('date', [$start, $end]);

        $queryPenilaian->where(function ($q) use ($tahunAjaran, $semester) {
            if ($tahunAjaran) {
                $q->where('tahun_ajaran', $tahunAjaran);
            }

            if ($semester) {
                $q->where('semester', $semester);
            }
        });

        // kehadiran
        $queryKehadiran = Kehadiran::with(['student:id,nisn,name,class_id', 'class:id,name'])
            ->select('student_id', 'date', 'status')
            ->where('student_id', session('student_id'))
            ->whereBetween('date', [$start, $end]);

        $kehadiran = $queryKehadiran->get()->groupBy('student_id');

        $data = $kehadiran->map(function ($item, $key) use ($start, $end) {
            $siswa = Student::find($key);
            $daysRange = range(
                (int)date('d', strtotime($start)),
                (int)date('d', strtotime($end))
            );

            $rekap = [];
            foreach ($daysRange as $day) {
                $currentDate = date('Y-m-' . str_pad($day, 2, '0', STR_PAD_LEFT));
                $status = $item->firstWhere('date', $currentDate)?->status ?? '-';
                $class = match ($status) {
                    'H' => 'bg-success',
                    'S' => 'bg-primary',
                    'I' => 'bg-info',
                    'A' => 'bg-danger',
                    'T' => 'bg-warning',
                    default => '',
                };
                $rekap[$day] = $status === '-' ? '-' : "class='text-center $class'>$status";
            }

            $summary = [
                'H' => $item->where('status', 'H')->count(),
                'S' => $item->where('status', 'S')->count(),
                'I' => $item->where('status', 'I')->count(),
                'A' => $item->where('status', 'A')->count(),
                'T' => $item->where('status', 'T')->count()
            ];

            return [
                'nisn' => $siswa->nisn,
                'name' => $siswa->name,
                'kelas' => $siswa->class->name,
                'rekap' => $rekap,
                'summary' => $summary
            ];
        });

        $penilaian = $queryPenilaian->get();
        $kehadiran = $data;

        $title = 'Akademis Siswa';

        return view('user.orangtua.akademis', compact('student', 'title', 'penilaian', 'kehadiran'));
    }
}
