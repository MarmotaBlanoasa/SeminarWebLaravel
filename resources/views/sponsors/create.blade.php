@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Sponsor</h1>
        <form action="{{ route('sponsors.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nume">Name</label>
                <input type="text" class="form-control" id="nume" name="nume" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection
