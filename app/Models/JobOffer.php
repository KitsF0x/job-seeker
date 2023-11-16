<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function requirements() : HasMany {
        return $this->hasMany(Requirement::class, 'jobOffer_id');
    }
}
