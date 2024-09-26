@extends('layouts.app')

@section('title', 'Demandes de Stage')

@section('content')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <div class="container">
        <h1>Demandes de Stage</h1>
        @if (session('approve'))
            <script>
                $(document).ready(function() {
                    $('#approveModal').modal('show');
                });
            </script>
        @endif
        @if (session('deny'))
            <script>
                $(document).ready(function() {
                    $('#denyModal').modal('show');
                });
            </script>
        @endif
        <table class="table">
            <thead>
                <tr>
                    <th>Stagiaire</th>
                    <th>Etablissement</th>
                    <th>Type de Stage</th>
                    <th>Modalité de Stage</th>
                    <th>Obligation</th>
                    <th>Statut</th>
                    <th>Pôle</th>
                    <th>Date de Début</th>
                    <th>Date de Fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($demandes as $demande)
                    <tr>
                        <td>{{ $demande->stagiaire->nom }} {{ $demande->stagiaire->prenom }}</td>
                        <td>{{ $demande->etablissement }}</td>
                        <td>{{ $demande->type_de_stage }}</td>
                        <td>{{ $demande->modalite_de_stage }}</td>
                        <td>{{ $demande->obligation }}</td>
                        <td>
                            @if ($demande->status == 'approuvé')
                                <span class="alert alert-success p-2">{{ $demande->status }}</span>
                            @elseif($demande->status == 'refusé')
                                <span class="alert alert-danger p-2">{{ $demande->status }}</span>
                            @else
                                <span class="alert alert-secondary p-2">{{ $demande->status }}</span>
                            @endif
                        </td>
                        <td>{{ $demande->pole }}</td>
                        <td>{{ $demande->date_de_debut }}</td>
                        <td>{{ $demande->date_de_fin }}</td>
                        <td>
                            <div class="actions">
                                <div>
                                    <span>
                                        <a href="{{ route('demande-de-stage.show', $demande->id) }}"
                                            class="text-info btn btn-link p-0" style="font-size: 24px; margin-right: 5px;">
                                            <i class="ti ti-info-circle"></i>
                                        </a>
                                    </span>
                                    <span>
                                        <button type="button" class="btn btn-link p-0" style="font-size: 24px; color: red;"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-id="{{ $demande->id }}">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </span>
                                </div>
                                <div>
                                    <form action="{{ route('demande-de-stage.approve', $demande->id) }}" method="POST"
                                        data-id="{{ $demande->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0"
                                            style="font-size: 24px; color: green; margin-right: 5px;">
                                            <i class="ti ti-circle-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('demande-de-stage.deny', $demande->id) }}" method="POST"
                                        data-id="{{ $demande->id }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0"
                                            style="font-size: 24px; color: red;">
                                            <i class="ti ti-alert-triangle"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $demandes->links('pagination::bootstrap-4') }} <!-- Use Bootstrap 4 pagination -->
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Êtes-vous sûr de vouloir supprimer cette demande de stage ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <form action="{{ route('demande-de-stage.destroy', $demande->id) }}" id="deleteForm" method="POST"
                        class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Approve Confirmation Modal -->
    <div class="modal fade " id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="approveModalLabel">Demande Approuvée</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    La demande a été approuvée avec succès.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Deny Confirmation Modal -->
    <div class="modal fade" id="denyModal" tabindex="-1" aria-labelledby="denyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="denyModalLabel">Demande Refusée</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    La demande a été refusée.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('assets/js/scripts.js') }}" defer></script>
