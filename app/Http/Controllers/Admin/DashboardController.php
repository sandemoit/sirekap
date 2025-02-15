<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';
        $titleSiswa = 'Total Siswa';
        $classCount = Classes::count();

        // kondisi menampilkan jumlah siswa
        if (Auth::user()->role == 'guru') { // jika guru berdasarkan siswa yang diAmpu
            $siswaCount = Student::where('nama_wali', Auth::id())->count();
            $titleSiswa = 'Siswa diAmpu';
        } else {
            $siswaCount = Student::count(); // selain guru tampilkan seluruh siswa
        }

        return view('admin.dashboard', compact('title', 'siswaCount', 'titleSiswa', 'classCount'));
    }
}
