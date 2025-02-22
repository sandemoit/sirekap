<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index()
    {
        $title = "Students";
        $siswa = Student::with(['teacher:id,name', 'class:id,name,teacher_id']) // Pastikan relasi mengambil id
            ->select('id', 'name', 'nis', 'nisn', 'gender', 'class_id', 'religion', 'nama_wali')
            ->whereHas('class', function ($query) {
                $query->where('teacher_id', Auth::id());
            })
            ->orderBy('name')
            ->get();

        return view('user.students.index', compact('title', 'siswa'));
    }


    public function storeDeskripsi($id)
    {
        try {
            $student = Student::where('id', $id)->first();

            // Assume that 'deskripsi' is a column in the 'students' table
            $student->updateOrCreate(
                ['id' => $id],
                ['deskripsi' => request('deskripsi')]
            );

            return redirect()->back()->with('success', 'Deskripsi siswa berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan server, coba lagi');
        }
    }
}
