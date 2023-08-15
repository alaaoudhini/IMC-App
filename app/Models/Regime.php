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
    return $this->belongsToMany(User::class, 'utilisateur_reg');
    }

    public function isCompatibleWithIMC($imc)
{
    // Define BMI ranges and their corresponding tag types
    $bmiRanges = [
        ['max' => 18.4, 'tag' => 'sous_poids'],
        ['max' => 24.8, 'tag' => 'poids_normal'],
        ['max' => 29.8, 'tag' => 'surpoids'],
        ['max' => 34.8, 'tag' => 'obesite_moderee'],
        ['max' => PHP_FLOAT_MAX, 'tag' => 'obesite_severe']
    ];

    foreach ($bmiRanges as $range) {
        if ($imc <= $range['max']) {
            return $this->compatibleWithTag($range['tag']);
        }
    }

    return false;
}

public function compatibleWithTag($tag)
{
    // Check if the regime has the specified tag
    $tags = $this->tags;

    if ($tags) {
        return $tags->where('type_reg', $tag)->isNotEmpty();
    }

    return false;
}

}
