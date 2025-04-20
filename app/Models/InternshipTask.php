<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipTask extends Model
{
    protected $table = "internship_task";
    protected $fillable = [
        "title",
        "description",
        "application_id",
        "report_file",
        "comments",
    ];
}
