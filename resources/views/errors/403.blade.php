@extends('layout.default')

@section('content')
    <h1 class="text-center">Action forbidden</h1>
    <h2 class="text-center text-secondary">HTTP 403</h2>
    <div class="d-flex justify-content-around mt-4">
        @include('errors.buttons')
    </div>
@endsection
