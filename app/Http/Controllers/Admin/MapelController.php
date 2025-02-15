<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subjects;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MapelController extends Controller
{
    public function index()
    {
        $title = 'Mata Pelajaran';
        return view('admin.mapel.list', compact('title'));
    }

    public function getMapel()
    {
        try {
            $students = Subjects::all();

            return DataTables::of($students)
                ->addColumn('action', function ($student) {
                    return '<form action="' . route('subject.destroy', $student->id) . '" method="POST" style="display:inline;">  
                        ' . csrf_field() . '  
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>  
                    </form>';
                })
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_mapel' => 'required|string|max:255',
        ], [
            'name_mapel.required' => 'Nama mata pelajaran harus diisi.',
            'name_mapel.string' => 'Nama mata pelajaran harus berupa string.',
            'name_mapel.max' => 'Nama mata pelajaran maksimal 255 karakter.',
        ]);

        try {
            Subjects::create([
                'name' => $request->name_mapel,
            ]);

            return redirect()->route('subject')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->route('subject')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Subjects::find($id)->delete();
            return redirect()->route('subject')->with('success', 'Mata Pelajaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('subject')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
