@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $speaker->nume }} {{ $speaker->prenume }}</h5>
                <p class="card-text"><strong>Email:</strong> {{ $speaker->email }}</p>
                <p class="card-text"><strong>Phone:</strong> {{ $speaker->telefon }}</p>
                <p class="card-text"><strong>Bio:</strong> {{ $speaker->bio }}</p>
                @if(Auth::user() && Auth::user()->role == 'admin')
                <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                @endif
            </div>
        </div>
    </div>
@endsection
