<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'nama_wali', 'id');
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessments::class);
    }

    public static function validateParentCredentials($nisn, $birth_date)
    {
        return self::where('nisn', $nisn)
            ->where('birth_date', $birth_date)
            ->first();
    }
}
