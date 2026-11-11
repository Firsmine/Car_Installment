<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Society extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    protected $fillable = [
        'id_card_number',
        'password',
        'name',
        'born_date',
        'gender',
        'address',
        'regional_id',
        'login_tokens'
    ];

    public function casts()
    {
        return ['password' => 'hashed'];
    }

    public function regional()
    {
        return $this->belongsTo(Regional::class, 'regional_id');
    }
    public function jobApplication()
    {
        return $this->hasMany(JobApplySociety::class, 'society_id');
    }
    public function appliedPosition()
    {
        return $this->hasMany(JobApplyPosition::class, 'society_id');
    }
    public function validations()
    {
        return $this->hasMany(Validation::class, 'society_id');
    }
}
