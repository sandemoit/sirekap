<?php

use App\Models\Setting;

if (!function_exists('configWeb')) {
    /**
     * Get model setting
     *
     * @param  string  $value
     * @return \App\Models\Profit
     */
    function configWeb($value = null)
    {
        static $web;

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
            'foto_kepsek',
        ];

        if (is_null($web)) {
            $web = Setting::whereIn('key', $keys)->get()->keyBy('key');
        }

        if ($value) {
            return $web->get($value);
        }

        return $web;
    }
}

if (!function_exists('tanggal')) {
    /**
     * Get model setting
     *
     * @param  string  $value
     * @return \App\Models\Profit
     */
    function tanggal($value = null)
    {
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $bulanIndo = $bulan[date('n') - 1];
        $hariIndo = $hari[date('w')];
        return $hariIndo . ', ' . date('j') . ' ' . $bulanIndo . ' ' . date('Y');
    }
}
