<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = "schedules";
    protected $fillable = [
        'user_id',
        'week_start_date',
        'senin_masuk',
        'senin_keluar',
        'selasa_masuk',
        'selasa_keluar',
        'rabu_masuk',
        'rabu_keluar',
        'kamis_masuk',
        'kamis_keluar',
        'jumat_masuk',
        'jumat_keluar',
        'sabtu_masuk',
        'sabtu_keluar',
        'minggu_masuk',
        'minggu_keluar',
        'status_verifikasi',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
