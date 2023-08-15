<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtilisateurReg extends Model
{
    use HasFactory;

    protected $fillable = ['regime_id','user_id'];

    public function regimes()
    {
        return $this->belongsToMany(Regime::class);
    }
}
