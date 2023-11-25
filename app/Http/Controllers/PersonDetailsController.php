<?php

namespace App\Http\Controllers;

use App\Models\PersonDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonDetailsController extends Controller
{
    public function update(Request $request)
    {
        $currentUser = Auth::user();
        if ($currentUser->personDetails == null) {
            PersonDetails::create([
                'name' => $request->name,
                'surname' => $request->surname,
                'day_of_birth' => $request->day_of_birth,
                'country' => $request->country,
                'city' => $request->city,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'user_id' => $currentUser->id
            ]);
        } else {
            $currentUser->personDetails->update($request->all());
        }
        return back();
    }
}
