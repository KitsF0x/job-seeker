@extends('layout.default')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <form action="{{ route('jobOffer.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" rows="3" name="description" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
