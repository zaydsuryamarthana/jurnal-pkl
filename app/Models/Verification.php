<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $table = "verifications";
    protected $fillable = [
        "id",
        "user_id",
        "file",
        "is_verified",
        "submitted_at",
        "verified_at",
        "komentar",
        "created_at",
        "updated_at"
    ];
}
