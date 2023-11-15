@extends('layout.default')

@section('content')
    <form action="{{route('jobOffer.store')}}" method="POST">
        @csrf
        <span>Name</span>
        <input type="text" name="name"> 
        <span>Description</span>
        <textarea name="description"></textarea>
        <button type="submit">Create offer</button>
    </form>
@endsection