<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['nom_act', 'description_act', 'type_act' , 'max_imc' , 'min_imc' , 'video', 'user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'utilisateur_act');
    }
}
