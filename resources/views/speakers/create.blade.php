@extends('layouts.app')

@section('content')
    <div class="container">
        @if(Auth::user() && Auth::user()->role == 'admin')
        <h1>Add Speaker</h1>
        @endif
        <form action="{{ route('speakers.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nume">Name</label>
                <input type="text" class="form-control" id="nume" name="nume" required>
            </div>
            <div class="form-group">
                <label for="prenume">Surname</label>
                <input type="text" class="form-control" id="prenume" name="prenume" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="telefon">Phone</label>
                <input type="text" class="form-control" id="telefon" name="telefon" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <input type="text" class="form-control" id="bio" name="bio" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

    </div>
@endsection
