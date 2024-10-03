@extends('layouts.app')

@section('title', 'Candidats')

@section('content')
    <div class="container">
        <h1>Candidats</h1>
        @if ($candidatsPaginated->isEmpty())
            <div class="alert alert-info">Aucun candidat trouvé.</div>
        @else
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Profile Picture</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Encadrant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($candidatsPaginated as $candidat)
                        {{-- {{ dd($candidat) }} --}}
                        <tr>
                            <td>
                                @if ($candidat->profile_picture)
                                    <img src="{{ asset('storage/' . $candidat->profile_picture) }}" alt="Profile Picture"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <img src="{{ asset('/assets/images/profile/default-profile.png') }}"
                                        alt="Default Profile Picture" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $candidat->nom }}</td>
                            <td>{{ $candidat->prenom }}</td>
                            <td>{{ $candidat->email }}</td>
                            <td>
                                @if ($candidat->encadrant)
                                    {{ $candidat->encadrant->nom }} {{ $candidat->encadrant->prenom }}
                                @else
                                    Not Assigned
                                @endif
                            </td>
                            <td>
                                {{-- <a href="{{ route('stagiaires.show', $candidat->id) }}" class="btn btn-link p-0"
                                    style="font-size: 24px;">
                                    <i class="ti ti-eye"></i>
                                </a> --}}
                                <a href="#" class="btn btn-link p-0 text-info" style="font-size: 24px;"
                                    data-bs-toggle="modal" data-bs-target="#stagiaireModal{{ $candidat->id }}"
                                    title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('stagiaires.edit', $candidat->id) }}"
                                    class="btn btn-link p-0 text-success" style="font-size: 24px;">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                {{-- <form action="{{ route('stagiaires.destroy', $candidat->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0" style="font-size: 24px; color: red;">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form> --}}
                                <button type="button" class="btn btn-link p-0 text-danger" style="font-size: 24px;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $candidat->id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <!-- Include the stagiaire modal -->
                        @include('modals.stagiaires.show', ['stagiaire' => $candidat])
                        @include('modals.stagiaires.delete', ['stagiaire' => $candidat])
                        @include('modals.stagiaires.archive', ['stagiaire' => $candidat])
                        @include('modals.stagiaires.restore', ['stagiaire' => $candidat])
                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal{{ $candidat->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel{{ $candidat->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $candidat->id }}">Confirmer la
                                            suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce candidat ?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Annuler</button>
                                        <form action="{{ route('stagiaires.destroy', $candidat->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $candidatsPaginated->links('pagination::bootstrap-4') }} <!-- Use Bootstrap 4 pagination -->
            </div>
        @endif
    </div>
@endsection
