<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Imports\SiswaImport;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
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
    public function data()
    {
        try {
            $students = Student::with('teacher', 'class')->select('id', 'name', 'nis', 'nisn', 'gender', 'class_id', 'religion', 'nama_wali')
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
}
