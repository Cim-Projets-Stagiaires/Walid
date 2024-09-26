@extends('layouts.app')

@section('title', 'Edit Encadrant')

@section('content')
    <div class="container">
        <h1>Edit Encadrant</h1>
        @if ($errors->any())
            {{-- Dump and die the errors --}}
            {{ dd($errors) }}
        @endif
        <form action="{{ route('encadrants.update', $encadrant->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="mb-3 col">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" id="nom" value="{{ $encadrant->nom }}"
                        required>
                </div>
                <div class="mb-3 col">
                    <label for="prenom" class="form-label">Prénom</label>
                    <input type="text" name="prenom" class="form-control" id="prenom"
                        value="{{ $encadrant->prenom }}" required>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" id="phone" value="{{ $encadrant->phone }}"
                        required>
                </div>
                <div class="mb-3 col">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $encadrant->email }}"
                        required>
                </div>
                @if (Auth::user()->type == 'responsable admin')
                    <div class="mb-3 radio-container">
                        <label for="permanent" class="form-label">Permanent</label>
                        <label>
                            <input type="radio" name="permanent" value="1">
                            <span>Oui</span>
                        </label>
                        <label>
                            <input type="radio" name="permanent" value="0">
                            <span>Non</span>
                        </label>
                    </div>
                @endif
            </div>
            @if (Auth::user()->type == 'responsable admin' || (Auth::user()->type == 'encadrant' || Auth::user()->id == $encadrant->id))
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password">
                </div>
            @endif
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Profile Picture</label>
                <input type="file" name="profile_picture" class="form-control" id="profile_picture">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
