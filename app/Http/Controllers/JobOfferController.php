<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobOfferController extends Controller
{
    private $validations = [
        'name' => 'required',
        'description' => 'required'
    ];

    public function index()
    {
        return view('jobOffer.index', ['jobOffers' => JobOffer::all()]);
    }

    public function create()
    {
        if(Auth::guest()) {
            return redirect(route('auth.loginForm'));
        }
        return view('jobOffer.create');
    }

    public function store(Request $request)
    {
        if(Auth::guest()) {
            return redirect(route('auth.loginForm'));
        }
        $validated = $this->validate($request, $this->validations);
        $jobOffer = JobOffer::create([
            'name'=> $validated['name'],
            'description'=> $validated['description'],
            'user_id'=> Auth::id()
        ]);
        return redirect(route('jobOffer.show', $jobOffer));
    }

    public function show(JobOffer $jobOffer)
    {
        return view('jobOffer.show', [
            'jobOffer'=> $jobOffer,
            'requirements' => $jobOffer->requirements,
            'details' => $jobOffer->jobOfferDetails
        ]);
    }

    public function edit(JobOffer $jobOffer)
    {
        if(Auth::guest()) {
            return redirect(route('auth.loginForm'));
        }
        if(Auth::id() != $jobOffer->user_id) {
            return abort(401);
        }

        return view('jobOffer.edit', [
            'jobOffer'=> $jobOffer,
            'requirements' => $jobOffer->requirements,
            'details' => $jobOffer->jobOfferDetails
        ]);
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        if(Auth::guest()) {
            return redirect(route('auth.loginForm'));
        }
        if(Auth::id() != $jobOffer->user_id) {
            return abort(401);
        }
        $validated = $this->validate($request, $this->validations);
        $jobOffer->update($validated);
        return redirect(route('jobOffer.show', $jobOffer));
    }


    public function destroy(JobOffer $jobOffer)
    {
        if(Auth::guest()) {
            return redirect(route('auth.loginForm'));
        }
        if(Auth::id() != $jobOffer->user_id) {
            return abort(401);
        }
        // Delete all requirements assigned to offer
        foreach($jobOffer->requirements as $requirement) {
            $requirement->delete();
        }
        $jobOffer->delete();
        return redirect(route('jobOffer.index'));
    }
}
