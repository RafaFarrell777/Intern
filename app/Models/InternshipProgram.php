<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipProgram extends Model
{
    use HasFactory;

    protected $table = "internship_programs";
    protected $fillable = [
        'title',
        'description',
        'mentor_id',
        'start_date',
        'end_date',
        'location',
        'max_participants',
        'requirements',
        'benefits',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function applications()
    {
        return $this->hasMany(InternshipApplications::class, 'program_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'program_id');
    }

    public function hasApplied($siswaId)
    {
        return $this->applications()->where('siswa_id', $siswaId)->exists();
    }
}
