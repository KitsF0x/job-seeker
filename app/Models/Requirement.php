<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = ["description", "jobOffer_id"];

    public function jobOffer() : BelongsTo {
        return $this->belongsTo(JobOffer::class, 'jobOffer_id');
    }
}
