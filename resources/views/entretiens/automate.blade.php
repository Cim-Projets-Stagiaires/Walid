{{-- resources/views/entretiens/automate.blade.php --}}
@extends('layouts.app')

@section('title', 'Automate Entretiens')

@section('content')
    <div class="container">
        <h1>Automatiser les Entretiens</h1>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('entretiens.automate') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="date">Date of the Entretien</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" name="start_time" id="start_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="end_time">End Time</label>
                <input type="time" name="end_time" id="end_time" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="number_of_stagiaires">Number of Stagiaires</label>
                <input type="number" name="number_of_stagiaires" id="number_of_stagiaires" class="form-control" min="1" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Create Entretiens</button>
            <a href="{{ route('entretiens.index') }}" class="btn btn-secondary mt-3">Back</a>
        </form>
    </div>
@endsection
