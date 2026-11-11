<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'society_id',
        'validator_id',
        'status',
        'job',
        'job_description',
        'income',
        'reason_accepted',
        'validator_notes'
    ];

    public function society()
    {
        return $this->belongsTo(Society::class, 'society_id');
    }
    public function jobCategory()
    {
        return $this->belongsTo(JobCategory::class, 'job_category_id');
    }
    public function validator()
    {
        return $this->belongsTo(Validator::class, 'validator_id');
    }
}
