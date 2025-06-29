<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $fillable = [
        'user_id',
        'judul',
        'tujuan',
        'dudi',
        'deskripsi',
        'izin',
        'verifikasi',
        'tgl',
        'komentar',
        'file',
        'created_at',
        'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
