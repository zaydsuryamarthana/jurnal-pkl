<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'user_id',
        'tgl',
        'ket',
        'komentar',
        'masuk',
        'keluar',
        'foto_masuk',
        'foto_keluar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
