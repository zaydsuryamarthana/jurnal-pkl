<?php

namespace App\Models;

use App\Models\Journal;
use App\Models\Schedule;
use App\Models\Attendance;
use App\Models\Internship;
use App\Models\Verification;
use Illuminate\Notifications\Notifiable;
use App\Notifications\CustomResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    public function verification()
    {
        return $this->belongsTo(Verification::class, 'verified_id');
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function journal()
    {
        return $this->hasMany(Journal::class, 'user_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id')->where('role', 'admin');
    }

    public function pembimbing()
    {
        return $this->hasMany(User::class, 'admin_id')->where('role', 'user');
    }

    public function submittedVerification()
    {
        return $this->hasOne(Verification::class, 'user_id');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'user_id');
    }

    public function reports()
    {
        return $this->hasOne(Report::class);
    }

    protected $fillable = [
        'niy',
        'nip',
        'nisn',
        'role',
        'password',
        'nis',
        'nama',
        'jk',
        'kelas',
        'jurusan',
        'email',
        'telp',
        'internship_id',
        'admin_id',
        'verified_id',
        'foto'
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
