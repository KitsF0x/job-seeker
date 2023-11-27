<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];


    public function daysToOfferEnd() {
        if($this->jobOfferDetails == null) {
            return "";
        }   
        $start_date = Carbon::parse($this->jobOfferDetails->start_date);
        $end_date = Carbon::parse($this->jobOfferDetails->end_date);
        return $end_date->diffInDays($start_date);
    }

    // Relationships
    public function requirements() : HasMany {
        return $this->hasMany(Requirement::class, 'jobOffer_id');
    }

    public function jobOfferDetails() :HasOne {
        return $this->hasOne(JobOfferDetails::class, 'jobOffer_id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
