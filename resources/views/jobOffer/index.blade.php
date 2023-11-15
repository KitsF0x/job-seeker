@extends('layout.default')

@section('content')
    @foreach ($jobOffers as $jobOffer)
        <div class="card mt-3">
            <div class="card-body">
                <p>{{ $jobOffer->name }}</p>
                <p>{{ $jobOffer->description }}</p>
                <a href="{{ route('jobOffer.show', $jobOffer) }}"><button class="btn btn-primary">Show</button></a>
                <a href="{{ route('jobOffer.edit', $jobOffer) }}"><button class="btn btn-warning">Edit</button></a>
                <form action="{{ route('jobOffer.destroy', $jobOffer) }}" style="display: inline" method="POST">
                    @method('POST')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    @endforeach
    <a href="{{ route('jobOffer.create') }}">Create a new offer</a>
@endsection
