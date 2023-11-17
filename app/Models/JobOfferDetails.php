<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobOfferDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'lowest_salary',
        'highest_salary',
        'salary_type',
        'jobOffer_id'
    ];

    public function jobOffer() : BelongsTo 
    {
        return $this->belongsTo(JobOffer::class, 'jobOffer_id');
    }
}
