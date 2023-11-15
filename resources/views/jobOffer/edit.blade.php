@extends('layout.default')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('jobOffer.update', $jobOffer) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" value="{{ $jobOffer->name }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" name="description">{{ $jobOffer->description }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
