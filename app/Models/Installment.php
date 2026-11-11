<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installment';

    protected $fillable = [
        'brand_id',
        'cars',
        'description',
        'price'
    ];

    public function availableMonth()
    {
        return $this->hasMany(AvailableMonth::class, 'installment_id');
    }
    public function application()
    {
        return $this->hasMany(JobApplySociety::class);
    }
}
