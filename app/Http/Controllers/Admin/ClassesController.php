<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassesRequest;
use App\Models\Classes;
use App\Models\User;

class ClassesController extends Controller
{
    public function index()
    {
        $title = "Data Kelas";
        $teachers = User::where('role', 'guru')->get();
        $classes = Classes::with('teacher:id,name') // relasi dengan guru
            ->select('id', 'name', 'teacher_id')
            ->get();

        return view('admin.classes.index', compact('title', 'classes', 'teachers'));
    }

    // simpan data kelas dan guru
    public function store(ClassesRequest $request)
    {
        try {
            Classes::create([
                'name' => $request->class_name,
                'teacher_id' => $request->teacher_id
            ]);

            return redirect()->back()->with('success', 'Data kelas berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function update(ClassesRequest $request, $id)
    {
        try {
            Classes::find($id)->update([
                'name' => $request->class_name,
                'teacher_id' => $request->teacher_id
            ]);

            return redirect()->back()->with('success', 'Data kelas berhasil diubah.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            Classes::find($id)->delete();
            return redirect()->back()->with('success', 'Data kelas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
