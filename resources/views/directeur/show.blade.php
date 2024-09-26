@extends('layouts.app')

@section('title', 'Directeur Details')

@section('content')
    <div class="container">
        <h1>Directeur Details</h1>
        <br>
        @if ($user->profile_picture)
            <div class="mb-3">
                <label class="form-label">Profile Picture:</label>
                <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="img-fluid"
                    style="width: 150px; height: 150px; border-radius: 50%; margin-left: 18%;">
            </div>
        @endif
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Nom</label>
                <p>{{ $user->nom }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Prénom</label>
                <p>{{ $user->prenom }}</p>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Phone</label>
                <p>{{ $user->phone }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Email</label>
                <p>{{ $user->email }}</p>
            </div>
        </div>
        <div class="mt-4 ml-6">
            <a href="{{ route('directeur.edit', $user->id) }}" class="btn btn-warning">Edit</a> &nbsp;&nbsp;
        </div>
    </div>
@endsection
