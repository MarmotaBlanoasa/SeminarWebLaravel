@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sponsors</h1>
        @if(Auth::user() && Auth::user()->role == 'admin')
        <a href="{{ route('sponsors.create') }}" class="btn btn-primary mb-3">Create New Sponsor</a>
        @endif
        @foreach ($sponsors as $sponsor)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $sponsor->nume }}</h5>
                    <p class="card-text">{{ $sponsor->email }}</p>
                    <p class="card-text">{{ $sponsor->phone }}</p>
                    <p class="card-text">{{ $sponsor->description }}</p>
                    <a href="{{ route('sponsors.show', $sponsor) }}" class="btn btn-primary">View</a>
                    @if(Auth::user() && Auth::user()->role == 'admin')
                    <a href="{{ route('sponsors.edit', $sponsor) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('sponsors.destroy', $sponsor) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    @endif

                </div>
            </div>
        @endforeach
    </div>
@endsection
