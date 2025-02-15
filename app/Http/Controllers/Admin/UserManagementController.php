<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsersRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function index()
    {
        $title = "User Management";
        $users = User::select('id', 'name', 'email', 'role', 'nip', 'nohp')->get();
        return view('admin.user-management.index', compact('title', 'users'));
    }

    public function data()
    {
        try {
            $users = User::select('id', 'name', 'email', 'role', 'nip', 'nohp')
                ->orderBy('id', 'desc')
                ->get();

            return DataTables::of($users)
                ->addColumn('action', function ($users) {
                    return '<a href="javascript:void(0)" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal' . $users->id .
                        '">Edit</a>  
                    <form action="' . route('users.destroy', $users->id) . '" method="POST" style="display:inline;">  
                        ' . csrf_field() . '  
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus data ini?\')">Hapus</button>  
                    </form>';
                })
                ->addColumn('role', function ($users) {
                    $roles = [
                        'kepala_sekolah' => 'Kepala Sekolah',
                        'admin' => 'Admin',
                        'guru' => 'Guru',
                        'staff_administrasi' => 'Staff Administrasi'
                    ];
                    return $roles[$users->role] ?? $users->role;
                })
                ->rawColumns(['action', 'role'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function add()
    {
        $title = "Tambah User";
        return view('admin.user-management.add', compact('title'));
    }

    public function store(UsersRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($data['password']);
            User::create($data);
            return redirect()->route('user-management')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(UsersRequest $request, $id)
    {
        try {
            $data = $request->validated();

            // Hanya update password jika diinputkan
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']); // Jangan update jika kosong
            }

            User::findOrFail($id)->update($data);

            return redirect()->back()->with('success', 'Data berhasil diubah');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            User::find($id)->delete();
            return redirect()->back()->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
