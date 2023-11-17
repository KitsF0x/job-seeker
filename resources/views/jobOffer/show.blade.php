@extends('layout.default')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div>
                <h3>
                    <span>
                        {{ $jobOffer->name }}
                    </span>
                    @if ($jobOffer->jobOfferDetails != null)
                        <span class="badge bg-secondary">
                            {{ $details->lowest_salary }} - {{ $details->highest_salary }} {{ $details->salary_type }}
                        </span>
                    @endif
                </h3>
            </div>
            <hr>
            <h4>Description</h4>
            <p>{{ $jobOffer->description }}</p>
            <hr>
            @if ($jobOffer->jobOfferDetails != null)
                <h4>Details</h4>
                <div class="alert alert-light d-flex flex-wrap">
                    <div class="flex-grow-1">Start of the offer: <b>{{ $jobOffer->jobOfferDetails->start_date }}</b>.</div>
                    <div class="flex-grow-1">End of the offer: <b>{{ $jobOffer->jobOfferDetails->end_date }}</b>.</div>
                    <div class="flex-grow-1">There are <b>{{ $jobOffer->daysToOfferEnd() }}</b> days to end of the offer.
                    </div>
                </div>
                <hr>
            @endif
            <h4>Requirements</h4>
            <ul>
                @foreach ($requirements as $requirement)
                    <li>{{ $requirement->description }}</li>
                @endforeach
                <a href="{{ route('jobOffer.edit', $jobOffer) }}"><button class="btn btn-warning">Edit</button></a>
                <form action="{{ route('jobOffer.destroy', $jobOffer) }}" style="display: inline" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </ul>
        </div>
    </div>
@endsection
