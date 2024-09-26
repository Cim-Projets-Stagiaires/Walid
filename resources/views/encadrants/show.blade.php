@extends('layouts.app')

@section('title', 'Encadrant Details')

@section('content')
    <div class="container">
        <h1>Encadrant Details</h1>
        <br>
        @if ($encadrant->profile_picture)
            <div class="mb-3">
                <label class="form-label">Profile Picture:</label>
                <img src="{{ asset('storage/' . $encadrant->profile_picture) }}" alt="Profile Picture" class="img-fluid"
                    style="width: 150px; height: 150px; border-radius: 50%; margin-left: 18%;">
            </div>
        @endif
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Nom</label>
                <p>{{ $encadrant->nom }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Prénom</label>
                <p>{{ $encadrant->prenom }}</p>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Phone</label>
                <p>{{ $encadrant->phone }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Email</label>
                <p>{{ $encadrant->email }}</p>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label class="form-label">Permanent</label>
                    <p>{{ $encadrant->permanent ? 'oui' : 'non' }}</p>
                </div>
            </div>
        </div>
        <div class="mt-4 ml-6">
            @if (Auth::user()->type == 'responsable admin')
                <a href="{{ route('encadrants.index') }}" class="btn btn-secondary">Back to List</a>
            @endif
            <a href="{{ route('encadrants.edit', $encadrant->id) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('encadrants.stagiaires', $encadrant->id) }}" class="btn btn-primary">Liste des Stagiaires</a>
        </div>
    </div>
@endsection
