<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Get all applications submitted by this user (if role is 'magang')
     */
    public function applications()
    {
        return $this->hasMany(InternshipApplications::class, 'siswa_id');
    }

    /**
     * Get all programs supervised by this user (if role is 'mentor')
     */
    public function programs()
    {
        return $this->hasMany(InternshipProgram::class, 'mentor_id');
    }

    /**
     * Check if this user is a mentor
     */
    public function isMentor()
    {
        return $this->role === 'mentor';
    }

    /**
     * Check if this user is a student (magang)
     */
    public function isMagang()
    {
        return $this->role === 'magang';
    }
}
