<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\KehadiranRequest;
use App\Imports\KehadiranImport;
use App\Models\Classes;
use App\Models\Kehadiran;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class KehadiranController extends Controller
{
    public function input()
    {
        $user = Auth::user();
        $kelasQuery = Classes::select('id', 'name');

        if ($user->role === 'guru') {
            $kelasQuery->where('teacher_id', $user->id);
        }

        $kelas = $kelasQuery->get();
        $title = 'Input Kehadiran Siswa';

        return view('user.kehadiran.input', compact('kelas', 'title'));
    }

    // get data siswa ke frontend
    public function getSiswa(Request $request)
    {
        $siswa = Student::where('class_id', $request->kelas_id)->get();
        return response()->json($siswa);
    }

    // simpan data kehadiran
    public function store(KehadiranRequest $request)
    {
        try {
            $tanggal = Carbon::parse($request->tanggal);

            foreach ($request->kehadiran as $siswa_id => $status) {
                if (!empty($status)) {
                    // Cek apakah data kehadiran sudah ada
                    $existingKehadiran = Kehadiran::where([
                        'date' => $tanggal,
                        'student_id' => $siswa_id,
                        'class_id' => $request->kelas_id,
                    ])->first();

                    if ($existingKehadiran) {
                        throw new \Exception('Data kehadiran untuk siswa ini sudah ada pada tanggal tersebut');
                    }

                    Kehadiran::create([
                        'date' => $tanggal,
                        'student_id' => $siswa_id,
                        'class_id' => $request->kelas_id,
                        'status' => $status,
                        'semester' => configWeb('semester')->value,
                        'tahun_ajaran' => configWeb('tahun_ajaran')->value
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Data kehadiran berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function rekap(Request $request)
    {
        $title = 'Rekap Kehadiran Siswa';

        $user = Auth::user();
        $kelasQuery = Classes::select('id', 'name');

        if ($user->role === 'guru') {
            $kelasQuery->where('teacher_id', $user->id);
        }

        $kelas = $kelasQuery->get();

        $start = $request->query('start', date('Y-m-01'));
        $end = $request->query('end', date('Y-m-d'));

        $tahunAjaran = $request->query('tahun_ajaran');
        $semester = $request->query('semester');

        $kelasFilter = $request->query('kelas', 'all');

        $query = Kehadiran::with(['student:id,nisn,name,class_id', 'class:id,name'])
            ->select('student_id', 'date', 'status')
            ->whereBetween('date', [$start, $end]);

        $query->where(function ($q) use ($user, $kelasFilter, $tahunAjaran, $semester) {
            if ($user->role === 'guru') {
                $q->whereHas('class', function ($qq) use ($user) {
                    $qq->where('teacher_id', $user->id);
                });
            }

            if ($kelasFilter !== 'all') {
                $q->whereHas('student', function ($qq) use ($kelasFilter) {
                    $qq->where('class_id', $kelasFilter);
                });
            }

            if ($tahunAjaran) {
                $q->whereHas('class', function ($qq) use ($tahunAjaran) {
                    $qq->where('tahun_ajaran', $tahunAjaran);
                });
            }

            if ($semester) {
                $q->where('semester', $semester);
            }
        });

        $kehadiran = $query->get()->groupBy('student_id');

        $data = $kehadiran->map(function ($item, $key) use ($start, $end) {
            $siswa = Student::where('id', $key)->where('status', 'active')->first();

            if (!$siswa) {
                return null;
            }

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
        })->filter();

        return view('user.kehadiran.rekap', compact('title', 'kelas', 'data'));
    }

    public function import()
    {
        $title = 'Import Kehadiran Siswa';
        return view('user.kehadiran.import', compact('title'));
    }

    public function importProcess(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            Excel::import(new KehadiranImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data kehadiran berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data kehadiran: ' . $e->getMessage());
        }
    }
}
