<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'offer_id', 'message'];

    public function offer(): BelongsTo {
        return $this->belongsTo(JobOffer::class, 'offer_id');
    }
}
