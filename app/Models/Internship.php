<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{

    public $timestamps = false;
    protected $dates = ['tanggal_masuk', 'tanggal_penarikan'];
    protected $table = "internships";
    protected $fillable = [
        'admin_id',
        'dudika',
        'alamat',
        'deskripsi',
        'foto',
        'map',
        'jam_masuk',
        'jam_keluar',
        'tgl_masuk',
        'tgl_penarikan',
        'verifikasi'
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
