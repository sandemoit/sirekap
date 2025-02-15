<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = 'attendance';
    protected $fillable = [
        'date',
        'student_id',
        'class_id',
        'status', // S, I, A, T
        'semester',
        'tahun_ajaran'
    ];

    protected $dates = ['date'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }
}
