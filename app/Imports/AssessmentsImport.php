<?php

namespace App\Imports;

use App\Models\Assessments;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Subjects;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AssessmentsImport implements ToCollection, WithHeadingRow
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
                $user = Auth::user();

                $student = Student::where('nisn', $row['nisn'])->first();
                $class = Classes::where('name', $row['kelas'])->first();
                $subject = Subjects::where('name', $row['mapel'])->first();

                Assessments::create([
                    'student_id' => $student->id,
                    'class_id' => $class->id,
                    'subject_id' => $subject->id,
                    'assessment_name' => $row['nama_ujian'],
                    'score' => $row['score'],
                    'date' => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['date'])),
                    'semester' => configWeb('semester')->value,
                    'tahun_ajaran' => configWeb('tahun_ajaran')->value
                ]);
            } catch (\Exception $e) {
                Log::error(sprintf('Gagal mengimport data kehadiran: %s', $e->getMessage()));
            }
        }
    }
}
