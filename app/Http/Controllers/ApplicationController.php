<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function create(JobOffer $jobOffer)
    {
        if (isset(Auth::user()->applications)) {
            foreach (Auth::user()->applications as $application) {
                if ($application->offer_id == $jobOffer->id) {
                    return abort(403);
                }
            }
        }
        if ($jobOffer->user_id == Auth::id()) {
            return abort(403);
        }
        return view('application.create', [
            'jobOffer' => $jobOffer
        ]);
    }

    public function store(Request $request, JobOffer $jobOffer)
    {
        if ($jobOffer->user_id == Auth::id()) {
            return abort(403);
        }
        Application::create([
            'user_id' => Auth::id(),
            'offer_id' => $jobOffer->id,
            'message' => $request->message
        ]);

        return redirect(route('application.index'));
    }

    public function index()
    {
        return view('application.index', [
            'applications' => Auth::user()->applications
        ]);
    }

    public function destroy(Application $application)
    {
        if ($application->user_id != Auth::id()) {
            return abort(403);
        }
        $application->delete();
        return redirect(route('application.index'));
    }
}
