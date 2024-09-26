@extends('layouts.app')

@section('title', 'Admins')

@section('content')
    <div class="container">
        <h1>Admins</h1>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createAdminModal">
            Ajouter Nouveau Admin
        </button>
        {{-- <a href="{{ route('admins.create') }}" class="btn btn-primary mb-3">Ajouter Nouveau Admin</a> --}}
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
                @foreach ($admins as $admin)
                    <tr>
                        <td>
                            @if ($admin->profile_picture)
                                <img src="{{ asset('storage/' . $admin->profile_picture) }}" alt="Profile Picture"
                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                            @else
                                <img src="{{ asset('/assets/images/profile/default-profile.png') }}"
                                    alt="Default Profile Picture" style="width: 50px; height: 50px; object-fit: cover;">
                            @endif
                        </td>
                        <td>{{ $admin->nom }}</td>
                        <td>{{ $admin->prenom }}</td>
                        <td>{{ $admin->phone }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                            <!-- Button to trigger View Admin Modal -->
                            <button class="btn btn-link p-0" style="font-size: 24px;" data-bs-toggle="modal"
                                data-bs-target="#showAdminModal{{ $admin->id }}">
                                <i class="ti ti-eye"></i>
                            </button>
                            <!-- Button to trigger Edit Modal -->
                            <a href="{{ route('admins.edit', $admin->id) }}" class="text-success btn btn-link p-0"
                                style="font-size: 24px;">
                                <i class="ti ti-edit"></i>
                            </a>
                            <!-- Button to trigger Delete Confirmation Modal -->
                            <button class="text-danger btn btn-link p-0" style="font-size: 24px;" data-bs-toggle="modal"
                                data-bs-target="#deleteAdminModal{{ $admin->id }}">
                                <i class="ti ti-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Include the show, delete modals for each admin -->
                    @include('modals.admins.show', ['admin' => $admin])
                    @include('modals.admins.delete', ['admin' => $admin])
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Include the create admin modal -->
    @include('modals.admins.create')
@endsection
