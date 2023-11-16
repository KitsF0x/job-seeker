@extends('layout.default')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div>
                <h3>General settings</h3>
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
            <hr>
            <div>
                <div class="mb-3">
                    <h3>Addtitions</h3>
                    <label class="form-label">Requirements</label>
                    <ul>
                        @foreach ($requirements as $requirement)
                            <li>
                                {{-- Update --}}
                                <form action="{{ route('requirement.update', $requirement) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="text" name="description" value="{{ $requirement->description }}"
                                        size="50">
                                    <button class="btn btn-warning">Edit</button>
                                </form>
                                {{-- Delete --}}
                                <form action="{{ route('requirement.destroy', $requirement) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">-</button>
                                </form>
                            </li>
                        @endforeach

                        <li>
                            <form action="{{ route('requirement.store', $jobOffer) }}" method="POST"
                                style="display: inline">
                                @csrf
                                <input type="text" name="description" size="50">
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
