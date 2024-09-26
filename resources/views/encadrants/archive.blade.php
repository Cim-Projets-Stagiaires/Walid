@extends('layouts.app')

@section('title', 'Encadrants')

@section('content')
    <div class="container">
        <h1>Encadrants</h1>
        {{-- <a href="{{ route('encadrants.create') }}" class="btn btn-primary mb-3">Ajouter un Encadrant</a> --}}
        <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createEncadrantModal">Ajouter un
            Encadrant</a>
        @if ($encadrants->isEmpty())
            <div class="alert alert-info">Aucun Encadrant archivé.</div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Profile Picture</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Telephone</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($encadrants as $encadrant)
                        <tr>
                            <td>
                                @if ($encadrant->profile_picture)
                                    <img src="{{ asset('storage/' . $encadrant->profile_picture) }}" alt="Profile Picture"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('/assets/images/profile/default-profile.png') }}"
                                        alt="Default Profile Picture" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $encadrant->nom }}</td>
                            <td>{{ $encadrant->prenom }}</td>
                            <td>{{ $encadrant->phone }}</td>
                            <td>{{ $encadrant->email }}</td>
                            <td>
                                {{-- <a href="{{ route('encadrants.show', $encadrant->id) }}" class="btn btn-link p-0"
                                style="font-size: 24px;">
                                <i class="ti ti-eye"></i></a> --}}
                                <a href="#" class="btn btn-link p-0 text-info" style="font-size: 24px;"
                                    data-bs-toggle="modal" data-bs-target="#encadrantModal{{ $encadrant->id }}"
                                    title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('encadrants.edit', $encadrant->id) }}"
                                    class="text-success btn btn-link p-0" style="font-size: 24px;">
                                    <i class="ti ti-edit"></i></a>
                                <button type="button" class="text-danger btn btn-link p-0" style="font-size: 24px;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $encadrant->id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @include('modals.encadrants.show', ['encadrant' => $encadrant])
                        @include('modals.encadrants.delete', ['encadrant' => $encadrant])
                    @endforeach
                </tbody>
            </table>
            @include('modals.encadrants.create')
            <div class="d-flex justify-content-center">
                {{ $encadrants->links('pagination::bootstrap-4') }} <!-- Use Bootstrap 4 pagination -->
            </div>
        @endif
    </div>
@endsection
