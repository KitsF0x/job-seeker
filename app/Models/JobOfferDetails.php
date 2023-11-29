<?php

namespace App\Models;

use Carbon\Carbon;
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

    public function daysToOfferEnd() {
        if($this->start_date == null || $this->end_date == null) {
            return "";
        }
        $start_date = Carbon::today();
        $end_date = Carbon::parse($this->end_date);
        return $end_date->diffInDays($start_date);
    }

    public function jobOffer() : BelongsTo 
    {
        return $this->belongsTo(JobOffer::class, 'jobOffer_id');
    }
}
