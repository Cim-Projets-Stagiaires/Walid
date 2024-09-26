@extends('layouts.app')

@section('title', 'Admin Details')

@section('content')
    <div class="container">
        <h1>Admin Details</h1>
        <br>
        @if ($admin->profile_picture)
            <div class="mb-3">
                <label class="form-label">Profile Picture</label>
                <img src="{{ asset('storage/' . $admin->profile_picture) }}" alt="Profile Picture" class="img-fluid"
                    style="width: 150px; height: 150px; border-radius: 50%; margin-left: 18%;">
            </div>
        @endif
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Nom</label>
                <p>{{ $admin->nom }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Prénom</label>
                <p>{{ $admin->prenom }}</p>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Phone</label>
                <p>{{ $admin->phone }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Email</label>
                <p>{{ $admin->email }}</p>
            </div>
        </div>
        <a href="{{ route('admins.index') }}" class="btn btn-secondary">Back to List</a> &nbsp;&nbsp;
        <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">Edit</a>
    </div>
@endsection
