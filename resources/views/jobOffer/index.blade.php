@extends('layout.default')

@section('content')
    @foreach ($jobOffers as $jobOffer)
        <div class="card mt-3">
            <div class="card-body">
                <a href="{{ route('jobOffer.show', $jobOffer) }}">
                    <h3>{{ $jobOffer->name }}</h3>
                </a>
                <p>{{ $jobOffer->description }}</p>
            </div>
        </div>
    @endforeach
    <a href="{{ route('jobOffer.create') }}">Create a new offer</a>
@endsection
