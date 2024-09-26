@extends('layouts.app')

@section('title', 'Create Encadrant')

@section('content')
    <div class="container">
        @if ($errors->any())
            {{-- Dump and die the errors --}}
            {{ dd($errors) }}
        @endif
        <h1>Create Encadrant</h1>
        <form action="{{ route('encadrants.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="mb-3 col">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" id="nom" required>
                </div>
                <div class="mb-3 col">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" id="prenom" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" required>
                </div>
                <div class="mb-3 col">
                    <label for="etablissement" class="form-label">Etablissement</label>
                    <select name="etablissement" class="form-control" id="etablissement" required>
                        <option value="">Select Etablissement</option>
                        <option value="CIM">Cité de l'innovation</option>
                        <option value="FST">FST</option>
                        <option value="ENSA">ENSA</option>
                        <option value="FSSM">FSSM</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3 radio-container">
                <label for="permanent" class="form-label">Permanent</label>
                <label>
                    <input type="radio" name="permanent" value="1" required>
                    <span>Oui</span>
                </label>
                <label>
                    <input type="radio" name="permanent" value="0" required>
                    <span>Non</span>
                </label>
            </div>
            {{-- <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
        </div> --}}
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Photo de Profile</label>
                <input type="file" name="profile_picture" class="form-control" id="profile_picture">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
    <style>
        .check {}
    </style>
@endsection
