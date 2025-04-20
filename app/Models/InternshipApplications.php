<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipApplications extends Model
{
    protected $table = "internship_applications";
    protected $fillable = [
        "siswa_id",
        "status",
        "resume",
    ];

    public function siswa() {
        return $this->belongsTo('App\Models\User');
    }
}
