<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\JobOfferDetails;
use Illuminate\Http\Request;

class JobOfferDetailsController extends Controller
{
    public function update(Request $request, JobOffer $jobOffer)
    {
        if($jobOffer->jobOfferDetails == null) {
            JobOfferDetails::create([
                "start_date" => $request->start_date,
                "end_date" => $request->end_date,
                "lowest_salary" => $request->lowest_salary,
                "highest_salary" => $request->highest_salary,
                "salary_type" => $request->salary_type,
                "jobOffer_id" => $jobOffer->id
            ]);
        } else {
            $jobOffer->jobOfferDetails->update($request->all());
        }
        return back();
    } 
}
