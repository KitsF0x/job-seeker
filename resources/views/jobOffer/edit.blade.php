@extends('layout.default')

@section('content')
    <form action="{{route('jobOffer.update', $jobOffer)}}" method="POST">
        @csrf
        @method('PUT')
        <span>Name</span>
        <input type="text" name="name" value="{{$jobOffer->name}}">
        <span>Description</span>
        <textarea name="description">{{$jobOffer->description}}</textarea>
        <button type="submit">Update</button>
    </form>
@endsection