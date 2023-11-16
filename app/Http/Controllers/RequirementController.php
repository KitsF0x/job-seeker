<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use App\Models\Requirement;
use Illuminate\Http\Request;

class RequirementController extends Controller
{
    public function store(Request $request, JobOffer $jobOffer) {
        Requirement::create([
            'description' => $request->description,
            'jobOffer_id' => $jobOffer->id
        ]);
        return back();
    }

    public function destroy(Requirement $requirement) {
        $requirement->delete();
        return back();
    }

    public function update(Request $request, Requirement $requirement) {
        $requirement->update(['description' => $request->description]);
        return back();
    }
}
