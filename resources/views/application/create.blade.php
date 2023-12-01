@extends('layout.default')
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h3>You are applying to: <a href="{{ route('jobOffer.show', $jobOffer->id) }}">{{ $jobOffer->name }}</a></h3>
        </div>
        <hr>
        <form action="{{ route('application.store', $jobOffer->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="message">message</label>
                <textarea class="form-control" name="message" id="message" rows="3"></textarea>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="regulationsAccept" required>
                <label class="form-check-label" for="regulationsAccept">
                    I accept the regulations of the {{ config('app.name') }} website.
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="personalDataAccept" required>
                <label class="form-check-label" for="personalDataAccept">
                    I accept that the creator of the offer will have access to my personal data.
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>
    </div>
@endsection
