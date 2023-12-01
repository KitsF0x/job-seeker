@extends('layout.default')

@section('content')
    @foreach ($jobOffers as $jobOffer)
        <div class="card mt-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-flex justify-content-start align-items-center">
                            <h3>
                                <a href="{{ route('jobOffer.show', $jobOffer) }}">{{ $jobOffer->name }}</a>
                            </h3>
                            <h5>
                                @if (isset($jobOffer->jobOfferDetails->start_date) && isset($jobOffer->jobOfferDetails->end_date))
                                    <span class="badge bg-warning ms-3" role="alert">
                                        Days to offer end {{ $jobOffer->daysToOfferEnd() }}
                                    </span>
                                @endif
                            </h5>
                        </div>
                    </div>
                    <h3>
                        @if (isset($jobOffer->jobOfferDetails->lowest_salary) &&
                                isset($jobOffer->jobOfferDetails->highest_salary) &&
                                isset($jobOffer->jobOfferDetails->salary_type))
                            <span class="badge bg-secondary">
                                {{ $jobOffer->jobOfferDetails->lowest_salary }} -
                                {{ $jobOffer->jobOfferDetails->highest_salary }}
                                {{ $jobOffer->jobOfferDetails->salary_type }}
                            </span>
                        @endif
                    </h3>
                </div>

                <p>{{ $jobOffer->description }}</p>
                @if (Auth::id() == $jobOffer->user_id)
                    <a href="{{ route('jobOffer.edit', $jobOffer->id) }}">
                        <button class="btn btn-warning">
                            Edit
                        </button>
                    </a>
                @endif
                @if (Auth::check() && Auth::id() != $jobOffer->user_id)
                    <a href="{{ route('application.create', $jobOffer) }}">
                        <button class="btn btn-primary">
                            Apply
                        </button>
                    </a>
                @endif
            </div>
        </div>
    @endforeach
    <a href="{{ route('jobOffer.create') }}">Create a new offer</a>
@endsection
