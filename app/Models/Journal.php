<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Journal extends Model
{

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    use HasFactory;
    public $timestamps = false;
    protected $table = "journals";
    protected $fillable = [
        'user_id',
        'judul',
        'isi',
        'tgl',
        'foto',
        'verifikasi',
        'komentar'
    ];
}
