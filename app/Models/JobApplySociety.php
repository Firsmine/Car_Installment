<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplySociety extends Model
{
    public $timestamps = false;

    protected $table = 'installment_apply_societies';

    protected $fillable = [
        'society_id',
        'installment_id',
        'available_month_id',
        'date',
        'notes'
    ];

    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    public function installment()
    {
        return $this->belongsTo(Installment::class, 'installment_id');
    }
    public function availableMonth()
    {
        return $this->belongsTo(AvailableMonth::class, 'available_months_id');
    }
}
