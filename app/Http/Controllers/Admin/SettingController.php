<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        $title = "Pengaturan Umum";

        // Daftar key yang akan diambil dari database
        $keys = [
            'nama_sekolah',
            'npsn',
            'akreditasi',
            'telpon',
            'email',
            'website',
            'alamat_sekolah',
            'nama_kepsek',
            'nip_kepsek',
            'periode_jabatan',
            'kata_sambutan',
            'tahun_ajaran',
            'semester',
            'kalender_akademik',
            'logo_sekolah',
            'background_image',
        ];

        // Mengambil data berdasarkan key dan mengelompokkannya berdasarkan key
        $setting = Setting::whereIn('key', $keys)->get()->keyBy('key');

        return view('admin.setting', compact('title', 'setting'));
    }

    public function identitas(Request $request)
    {
        try {
            $request->validate([
                'nama_sekolah' => 'required|string|max:255',
                'alamat_sekolah' => 'required|string',
                'npsn' => 'required|string|max:20',
                'akreditasi' => 'required|string|max:20',
                'telpon' => 'required|string|max:13',
                'email' => 'required|email|max:255',
                'website' => 'required|url|max:255',
            ]);

            $data = $request->except(['_token', '_method']);

            // Update atau buat data identitas sekolah
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }

            return redirect()->back()->with('success', 'Identitas Sekolah berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function kepala_sekolah(Request $request)
    {
        try {
            $request->validate([
                'nama_kepsek' => 'required|string|max:255',
                'nip_kepsek' => 'required|string|max:20',
                'periode_jabatan' => 'required|string|max:20',
                'kata_sambutan' => 'required|string|max:255',
            ]);

            $data = $request->except(['_token', '_method']);

            // Proses upload logo sekolah
            if ($request->hasFile('foto_kepsek')) {
                $fotoPath = $request->file('foto_kepsek')->store('image/user', ['disk' => 'public']);
                $data['foto_kepsek'] = str_replace('public/', '', $fotoPath); // Sesuaikan path
            }

            // Update atau buat data identitas sekolah
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            return redirect()->back()->with('success', 'Data Kepala Sekolah berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function tahun_ajaran(Request $request)
    {
        try {
            $request->validate([
                'tahun_ajaran' => 'required|string|max:20',
                'semester' => 'required|string|max:20',
            ]);

            $data = $request->except(['_token', '_method']);

            // Proses upload logo sekolah
            if ($request->hasFile('kalender_akademik')) {
                $kalenderPath = $request->file('kalender_akademik')->store('file/kalender', ['disk' => 'public']);
                $data['kalender_akademik'] = str_replace('public/', '', $kalenderPath); // Sesuaikan path
            }

            // Update atau buat data identitas sekolah
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }
            return redirect()->back()->with('success', 'Data Tahun Ajaran dan Kalender Akademik berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function logo(Request $request)
    {
        try {
            $request->validate([
                'logo_sekolah' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'background_image' => 'file|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $data = [];

            // Proses upload logo sekolah
            if ($request->hasFile('logo_sekolah')) {
                $logoPath = $request->file('logo_sekolah')->store('image', ['disk' => 'public']);
                $data['logo_sekolah'] = str_replace('public/', '', $logoPath); // Sesuaikan path
            }

            // Proses upload background halaman login
            if ($request->hasFile('background_image')) {
                $bgPath = $request->file('background_image')->store('image', ['disk' => 'public']);
                $data['background_image'] = str_replace('public/', '', $bgPath); // Sesuaikan path
            }

            // Update atau buat data di database
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value]);
            }

            return redirect()->back()->with('success', 'Logo dan background berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error saat mengupload logo dan background: ' . $e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
