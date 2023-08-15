<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imc extends Model
{
    use HasFactory;

    protected $fillable = ['weight', 'height', 'imc'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($imc) {
            // Récupérer l'utilisateur actuellement authentifié
            $user = auth()->user();

            // Assurez-vous qu'un utilisateur est connecté avant d'associer l'ID
            if ($user) {
                $imc->user_id = $user->id;
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
