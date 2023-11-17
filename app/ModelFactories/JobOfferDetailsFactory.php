<?php

namespace App\ModelFactories;

use App\Models\JobOfferDetails;

class JobOfferDetailsFactory
{
    const DEFAULT_START_DATE = '19-01-2023';
    const DEFAULT_END_DATE = '29-01-2023';
    const DEFAULT_LOWEST_SALARY = '1234';
    const DEFAULT_HIGHEST_SALARY = '5678';
    const DEFAULT_SALARY_TYPE = 'PLN';

    public static function create(string $start_date, string $end_date, int $lowest_salary, int $highest_salary, string $salary_type, int $jobOffer_id): JobOfferDetails
    {
        return JobOfferDetails::create([
            'start_date' => $start_date,
            'end_date' => $end_date,
            'lowest_salary' => $lowest_salary,
            'highest_salary' => $highest_salary,
            'salary_type' => $salary_type,
            'jobOffer_id' => $jobOffer_id
        ]);
    }
    public static function createWithDefaultValues(int $jobOffer_id): JobOfferDetails
    {
        return JobOfferDetailsFactory::create(
            self::DEFAULT_START_DATE, 
            self::DEFAULT_END_DATE, 
            self::DEFAULT_LOWEST_SALARY, 
            self::DEFAULT_HIGHEST_SALARY, 
            self::DEFAULT_SALARY_TYPE, 
            $jobOffer_id
        );
    }
}
