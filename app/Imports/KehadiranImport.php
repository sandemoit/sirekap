<?php

namespace App\Imports;

use App\Models\Classes;
use App\Models\Kehadiran;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KehadiranImport implements ToCollection, WithHeadingRow
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
                $student = Student::where('nisn', $row['nisn'])->first();
                $class = Classes::where('name', $row['kelas'])->first();

                Kehadiran::create([
                    'student_id' => $student->id ?? null,
                    'date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal'])),
                    'class_id' => $class->id ?? null,
                    'status' => $row['status'],
                    'semester' => configWeb('semester')->value,
                    'tahun_ajaran' => configWeb('tahun_ajaran')->value
                ]);
            } catch (\Exception $e) {
                Log::error(sprintf('Gagal mengimport data kehadiran: %s', $e->getMessage()));
            }
        }
    }
}
