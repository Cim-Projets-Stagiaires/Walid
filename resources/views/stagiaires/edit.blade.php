@extends('layouts.app')

@section('title', 'Edit Stagiaire')

@section('content')
    <div class="container">
        @if ($errors->any())
            {{-- Dump and die the errors --}}
            {{ dd($errors) }}
        @endif
        <h1>Edit Stagiaire</h1>
        <form action="{{ route('stagiaires.update', $stagiaire->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" id="nom" value="{{ $stagiaire->nom }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" id="prenom" value="{{ $stagiaire->prenom }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" value="{{ $stagiaire->phone }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $stagiaire->email }}"
                    required>
            </div>
            @if (Auth::user()->type === 'responsable admin')
                <div class="mb-3">
                    <label for="encadrant" class="form-label">Encadrant</label>
                    <select name="encadrant" id="encadrant" class="form-control">
                        <option value="">Select Encadrant</option>
                        @foreach($encadrants as $encadrant)
                            <option value="{{ $encadrant->id }}" {{ $stagiaire->encadrant_id == $encadrant->id ? 'selected' : '' }}>
                                {{ $encadrant->nom }} {{ $encadrant->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password">
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control" id="profile_picture">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
