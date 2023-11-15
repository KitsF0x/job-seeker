<?php

namespace App\ModelFactories;

use App\Models\JobOffer;

class JobOfferFactory
{

    const DEFAULT_NAME = 'Junior PHP developer';
    const DEFAULT_DESCRIPTION = 'We are looking for junior PHP developers';

    public static function create(string $name, string $description): JobOffer
    {
        return JobOffer::create([
            'name' => $name,
            'description' => $description
        ]);
    }
    public static function createWithDefaultValues(): JobOffer
    {
        return JobOfferFactory::create(self::DEFAULT_NAME, self::DEFAULT_DESCRIPTION);
    }
}
