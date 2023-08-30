<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regime extends Model
{
    use HasFactory;

    protected $fillable = ['nom_reg', 'description_reg', 'type_reg' ,  'calories_reg', 'max_imc_reg' , 'min_imc_reg' , 'user_id'];

    public function users()
    {
    return $this->hasMany(User::class);
    }

}
