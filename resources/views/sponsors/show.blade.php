@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $sponsor->nume }}</h1>
        <p>Email: {{ $sponsor->email }}</p>
        <p>Phone: {{ $sponsor->phone }}</p>
        <p>Description: {{ $sponsor->description }}</p>
        @if(Auth::user() && Auth::user()->role == 'admin')
        <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-primary">Edit</a>
        <form action="{{ route('sponsors.destroy', $sponsor) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        @endif
    </div>
@endsection
