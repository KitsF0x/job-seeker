@extends('layout.default')
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            {{-- General --}}
            <div>
                <h3>General settings</h3>
                <form action="{{ route('personDetails.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name"
                            value="{{ isset($personDetails) ? $personDetails->name : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Surname</label>
                        <input type="text" class="form-control" name="surname"
                            value="{{ isset($personDetails) ? $personDetails->surname : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Day of birth</label>
                        <input type="date" class="form-control" name="day_of_birth"
                            value="{{ isset($personDetails) ? $personDetails->day_of_birth : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Country</label>
                        <input type="text" class="form-control" name="country"
                            value="{{ isset($personDetails) ? $personDetails->country : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city"
                            value="{{ isset($personDetails) ? $personDetails->city : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone number</label>
                        <input type="text" class="form-control" name="phone_number"
                            value="{{ isset($personDetails) ? $personDetails->phone_number : '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="{{ isset($personDetails) ? $personDetails->email : '' }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
                <hr>
            </div>
        </div>
    </div>
@endsection
