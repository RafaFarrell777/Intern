<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InternshipTask extends Model
{
    use HasFactory;

    protected $table = 'internship_tasks';

    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',
        'application_id',
        'report_file',
        'comments'
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    /**
     * Get the application that this task belongs to
     */
    public function application()
    {
        return $this->belongsTo(InternshipApplications::class, 'application_id');
    }

    /**
     * Check if the task is overdue
     */
    public function isOverdue()
    {
        return $this->deadline && $this->deadline->isPast() && $this->status === 'pending';
    }

    /**
     * Determine if the task is submitted
     */
    public function isSubmitted()
    {
        return in_array($this->status, ['submitted', 'approved', 'rejected']);
    }

    /**
     * Determine if the task is approved
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Determine if the task is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
