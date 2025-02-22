<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Imports\SiswaImport;
use App\Models\Assessments;
use App\Models\Classes;
use App\Models\Competitions;
use App\Models\Kehadiran;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    public function index()
    {
        $title = "Students";
        return view('admin.students.index', compact('title'));
    }

    // get data siswa ke frontend untuk datatable
    public function dataSiswa()
    {
        try {
            $students = Student::with('teacher', 'class')->select('id', 'name', 'birth_date', 'nis', 'nisn', 'gender', 'class_id', 'religion', 'nama_wali')
                ->where('status', 'active')
                ->orderBy('class_id')
                ->orderBy('name');

            return DataTables::of($students)
                ->addColumn('class', function ($student) {
                    return $student->class->name ?? 'Tidak Diketahui';
                })
                ->addColumn('wali_kelas', function ($student) {
                    return $student->teacher->name ?? 'Tidak Diketahui';
                })
                ->addColumn('action', function ($student) {
                    return '<a href="' . route('students.edit', $student->id) . '" class="btn btn-sm btn-primary">Edit</a>  
                    <form action="' . route('students.destroy', $student->id) . '" method="POST" style="display:inline;">  
                        ' . csrf_field() . '  
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>  
                    </form>';
                })
                ->rawColumns(['class', 'action', 'wali_kelas'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function add()
    {
        $classes = Classes::select('id', 'name')->get();
        $title = "Tambah Siswa";
        return view('admin.students.add', compact('title', 'classes'));
    }

    public function store(StudentRequest $request)
    {
        try {
            $nameWali = Classes::where('id', $request->class_id)->select('teacher_id')->first();

            Student::create([
                'name' => $request->name,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'birth_date' => $request->birth_date,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'class_id' => $request->class_id,
                'nama_wali' => $nameWali->teacher_id
            ]);

            return redirect()->back()->with('success', 'Data siswa berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $title = "Edit Student";
        $student = Student::findOrFail($id);
        $classes = Classes::select('id', 'name')->get();
        return view('admin.students.edit', compact('student', 'title', 'classes'));
    }

    public function update(StudentRequest $request, $id)
    {
        try {
            $student = Student::findOrFail($id);
            $nameWali = Classes::where('id', $request->class_id)->select('teacher_id')->first();
            $student->update([
                'name' => $request->name,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'class_id' => $request->class_id,
                'nama_wali' => $nameWali->teacher_id
            ]);

            return redirect()->route('students')->with('success', 'Data siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'Data siswa berhasil dihapus.');
    }

    public function import()
    {
        $title = 'Import Kehadiran Siswa';
        return view('admin.students.import', compact('title'));
    }
    public function importProcess(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:2048',
            ]);

            Excel::import(new SiswaImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data siswa berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengimport data siswa: ' . $e->getMessage());
        }
    }

    public function upClass()
    {
        DB::beginTransaction();
        try {
            // Ambil semua kelas yang ada
            $classes = Classes::all()->keyBy('id'); // Simpan berdasarkan ID untuk akses cepat

            // Ambil semua siswa
            $students = Student::all();

            foreach ($students as $student) {
                $currentClass = $classes[$student->class_id] ?? null;

                if (!$currentClass) continue;

                $currentClassName = $currentClass->name; // Contoh: 7A, 8B
                $classNumber = (int) substr($currentClassName, 0, 1); // Ambil angka depan (7, 8, 9)
                $classSuffix = substr($currentClassName, 1); // Ambil huruf belakang (A, B, C)

                if ($classNumber === 9) {
                    // Jika sudah kelas 9, ubah status jadi "graduated"
                    $student->update(['status' => 'graduated']);
                } else {
                    // Naik 1 kelas
                    $newClassName = ($classNumber + 1) . $classSuffix; // Misal 7A → 8A

                    // Cari ID kelas baru berdasarkan nama
                    $newClass = Classes::where('name', $newClassName)->first();
                    if ($newClass) {
                        $student->update(['class_id' => $newClass->id, 'nama_wali' => $newClass->teacher_id]);

                        // Update class_id di tabel lain
                        Kehadiran::where('student_id', $student->id)->update(['class_id' => $newClass->id]);
                        Assessments::where('student_id', $student->id)->update(['class_id' => $newClass->id]);
                        Competitions::where('student_id', $student->id)->update(['class_id' => $newClass->id]);
                    }
                }
            }

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Siswa berhasil naik kelas']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
