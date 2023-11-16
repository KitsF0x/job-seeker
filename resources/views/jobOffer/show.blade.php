@extends('layout.default')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <h3>{{ $jobOffer->name }}</h3>
            <hr>
            <h4>Description</h4>
            <p>{{ $jobOffer->description }}</p>
            <hr>
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
