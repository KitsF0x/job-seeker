@extends('layout.default')
@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Your applications</h3>
            <hr>
            @foreach ($applications as $application)
                <a href="{{ route('jobOffer.show', $application->offer->id) }}">
                    <h4>{{ $application->offer->name }}</h4>
                </a>
                <p>Applied at: <b>{{ $application->created_at }}</b></p>
                <form action="{{ route('application.destroy', $application->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button class="btn btn-danger" href="#" type="submit">Remove</button>
                </form>
                <hr>
            @endforeach
        </div>
    </div>
@endsection
