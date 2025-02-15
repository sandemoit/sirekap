<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Competitions;
use App\Models\Student;
use Illuminate\Http\Request;

class CompetitionsController extends Controller
{
    public function index()
    {
        $title = 'Daftar Kompetisi';
        $competitions = Competitions::select('id', 'class_id', 'competition_name', 'description', 'date', 'image')->get();
        return view('admin.competitions.list', compact('title', 'competitions'));
    }

    public function add()
    {
        $students = Student::select('id', 'name')->get();
        $class = Classes::select('id', 'name')->get();
        $title = 'Tambah Kompetisi';
        return view('admin.competitions.add', compact('title', 'students', 'class'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'description' => 'required|max:255',
                'tanggal' => 'required',
                'class_id' => 'required',
                'student_id' => 'required',
                // 'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            // Proses upload logo sekolah
            if ($request->hasFile('image')) {
                $fotoPath = $request->file('image')->store('image/competition', ['disk' => 'public']);
                $image = str_replace('public/', '', $fotoPath); // Sesuaikan path
            }

            Competitions::create([
                'competition_name' => $request->name,
                'description' => $request->description,
                'date' => $request->tanggal,
                'student_id' => $request->student_id,
                'class_id' => $request->class_id,
                'image' => $image,
            ]);

            return redirect()->back()->with('success', 'Data kompetisi berhasil disimpan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
