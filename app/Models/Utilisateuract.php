<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateuract extends Model
{
    use HasFactory;

    protected $fillable = ['activity_id','user_id'];

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}
