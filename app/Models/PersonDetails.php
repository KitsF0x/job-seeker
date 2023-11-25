<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'day_of_birth',
        'country',
        'city',
        'phone_number',
        'email',
        'user_id',
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
