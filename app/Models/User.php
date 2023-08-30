<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'date_of_birth',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard = 'admin';

    // For admin users
    public function isAdmin()
    {
    return $this->role === 'admin';
    }

    public function getRoleAttribute($value)
    {
    return strtolower($value);
    } 

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function regimes()
    {
        return $this->hasMany(Regime::class);
    }

    public function imc()
    {
        return $this->hasOne(Imc::class);
    }

    


    /*public function getCompatibleRegimeByIMC($imcValue)
    {
    $userIMC = $this->imc->imc; // Assuming you have a one-to-one relationship with the IMC model
    
    // Find a compatible regime based on the IMC range
    $compatibleRegime = Regime::where('min_imc_reg', '<=', $userIMC)
        ->where('max_imc_reg', '>=', $userIMC)
        ->first();

    return $compatibleRegime;
    }*/

    /*public function getCompatibleActivitiesByIMC($imcValue)
    {
    // Get the user's IMC value from the related Imc model
    $userIMC = $this->imc->imc;

    // Retrieve compatible activities based on the IMC range
    $compatibleActivities = Activity::where('min_imc', '<=', $userIMC)
        ->where('max_imc', '>=', $userIMC)
        ->get();

    return $compatibleActivities;
}*/

}
