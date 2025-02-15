<?php

namespace App\Imports;

use App\Models\Classes;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // $student = Student::where('nisn', $row['nisn'])->first();
                $class = Classes::where('name', $row['kelas'])->first();
                $waliKelas = User::where('role', 'guru')->where('name', $row['wali_kelas'])->first();

                Student::create([
                    'name' => $row['nama'],
                    'nis' => $row['nis'],
                    'nisn' => $row['nisn'],
                    'gender' => $row['gender'],
                    'religion' => $row['religion'],
                    'class_id' => $class->id ?? null,
                    'nama_wali' => $waliKelas->id ?? null,
                ]);
            } catch (\Exception $e) {
                Log::error(sprintf('Gagal mengimport data siswa: %s', $e->getMessage()));
            }
        }
    }
}
