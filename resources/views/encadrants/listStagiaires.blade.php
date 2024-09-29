@extends('layouts.app')

@section('title', 'List of Stagiaires')

@section('content')
    <div class="container">
        <h1>List of Stagiaires</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Profile</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stagiaires as $stagiaire)
                    <tr>
                        <td>
                            @if ($stagiaire->profile_picture)
                                <img src="{{ asset('storage/' . $stagiaire->profile_picture) }}" alt="Profile Picture"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                                <img src="{{ asset('/assets/images/profile/default-profile.png') }}"
                                    alt="Default Profile Picture" style="width: 50px; height: 50px; object-fit: cover;">
                            @endif
                        </td>
                        <td>{{ $stagiaire->nom }}</td>
                        <td>{{ $stagiaire->prenom }}</td>
                        <td>{{ $stagiaire->email }}</td>
                        <td>
                            {{-- <a href="{{ route('stagiaires.show', $stagiaire->id) }}" class="btn btn-primary">Voir</a> --}}
                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#stagiaireModal{{ $stagiaire->id }}" title="Voir">
                                Voir
                            </a>
                        </td>
                        @include('modals.stagiaires.show', ['stagiaire' => $stagiaire])
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $stagiaires->links('pagination::bootstrap-4') }} <!-- Use Bootstrap 4 pagination -->
        </div>
    </div>
@endsection
