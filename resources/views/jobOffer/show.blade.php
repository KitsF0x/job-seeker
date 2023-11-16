@extends('layout.default')

@section('content')
    <p>{{ $jobOffer->name }}</p>
    <p>{{ $jobOffer->description }}</p>
    <ul>
        @foreach ($requirements as $requirement)
            <li>{{ $requirement->description }}</li>
        @endforeach
    </ul>
@endsection
