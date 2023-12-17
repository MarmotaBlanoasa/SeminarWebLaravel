@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Speaker</h1>
        <form action="{{ route('speakers.update', $speaker) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nume">Name</label>
                <input type="text" class="form-control" id="nume" name="nume" value="{{ $speaker->nume }}" required>
            </div>
            <div class="form-group">
                <label for="prenume">Surname</label>
                <input type="text" class="form-control" id="prenume" name="prenume" value="{{ $speaker->prenume }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $speaker->email }}" required>
            </div>
            <div class="form-group">
                <label for="telefon">Phone</label>
                <input type="text" class="form-control" id="telefon" name="telefon" value="{{ $speaker->telefon }}" required>
            </div>
            <div class="form-group">
                <label for="bio">Bio</label>
                <input type="text" class="form-control" id="bio" name="bio" value="{{ $speaker->bio }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
