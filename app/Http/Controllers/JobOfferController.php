<?php

namespace App\Http\Controllers;

use App\Models\JobOffer;
use Illuminate\Http\Request;

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
        return view('jobOffer.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validate($request, $this->validations);
        $jobOffer = JobOffer::create($validated);
        return redirect(route('jobOffer.show', $jobOffer));
    }

    public function show(JobOffer $jobOffer)
    {
        return view('jobOffer.show', ['jobOffer'=> $jobOffer]);
    }

    public function edit(JobOffer $jobOffer)
    {
        return view('jobOffer.edit', ['jobOffer'=> $jobOffer]);
    }

    public function update(Request $request, JobOffer $jobOffer)
    {
        $validated = $this->validate($request, $this->validations);
        $jobOffer->update($validated);
        return redirect(route('jobOffer.show', $jobOffer));
    }


    public function destroy(JobOffer $jobOffer)
    {
        $jobOffer->delete();
        return redirect(route('jobOffer.index'));
    }
}