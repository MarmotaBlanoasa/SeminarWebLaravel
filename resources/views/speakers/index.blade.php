@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Speakers</h1>
        @if($speakers->count() === 0)
            <p>No speakers added yet. Click on the button below to add new speakers</p>
        @endif
        @if(Auth::user() && Auth::user()->role == 'admin')
        <a href="{{ route('speakers.create') }}" class="btn btn-primary mb-4">Add Speaker</a>
        @endif

        @if($speakers->count() > 0)
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    @if(Auth::user() && Auth::user()->role == 'admin')
                    <th>Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($speakers as $speaker)
                    <tr>
                        <td><a href="{{ route('speakers.show', $speaker) }}">{{ $speaker->nume }}</a></td>
                        <td>{{ $speaker->email }}</td>
                        <td>{{ $speaker->telefon }}</td>
                        <td>
                            @if(Auth::user() && Auth::user()->role == 'admin')
                            <a href="{{ route('speakers.edit', $speaker) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('speakers.destroy', $speaker) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
