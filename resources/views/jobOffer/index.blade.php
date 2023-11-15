@extends('layout.default')

@section('content')
    @foreach ($jobOffers as $jobOffer)
        <p>{{$jobOffer->name}}</p>
        <p>{{$jobOffer->description}}</p>
        <a href="{{route('jobOffer.show', $jobOffer)}}"><button>Show</button></a>
        <a href="{{route('jobOffer.edit', $jobOffer)}}"><button>Edit</button></a>
        <form action="{{route('jobOffer.destroy', $jobOffer)}}" style="display: inline" method="POST">
            @method('POST')
            <button type="submit">Delete</button>
        </form>
    @endforeach
    <a href="{{route('jobOffer.create')}}">Create a new offer</a>
@endsection