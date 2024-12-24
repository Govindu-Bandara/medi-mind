@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Search Results</h1>
    @foreach($doctors as $doctor)
        <div>
            <h4>{{ $doctor->name }}</h4>
            <p>{{ $doctor->specialty }}</p>
            <form action="{{ route('send.request', ['id' => $doctor->id]) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Send Request</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
