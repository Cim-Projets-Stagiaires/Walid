@extends('layouts.app')

@section('title', 'Stagiaire Details')

@section('content')
    <div class="container">
        <h1>Stagiaire Details</h1>
        <br>
        @if ($stagiaire->profile_picture)
            <div class="mb-3">
                <label class="form-label">Profile Picture:</label>
                <img src="{{ asset('storage/' . $stagiaire->profile_picture) }}" alt="Profile Picture" class="img-fluid"
                    style="width: 150px; height: 150px; border-radius: 50%; margin-left: 18%;">
            </div>
        @else
            @if (auth()->user()->type == 'stagiaire')
                <div class="alert alert-warning">
                    Veullez ajouter votre photo de profil.
                </div>
            @endif
        @endif
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Nom</label>
                <p>{{ $stagiaire->nom }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Prénom</label>
                <p>{{ $stagiaire->prenom }}</p>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Phone</label>
                <p>{{ $stagiaire->phone }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Email</label>
                <p>{{ $stagiaire->email }}</p>
            </div>
        </div>
        <!-- Progress Bar Section -->
        <div class="mt-4">
            <h4>Progression</h4>
            <div class="progress my-4">
                <div class="progress-bar" role="progressbar" style="width: {{ $progress }}%; background-color: #50ec49;"
                    aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                    {{ round($progress, 2) }}%
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <p>Rapports Semi Validés: {{ $validatedSemiRapports }}/{{ $requiredSemiRapports }}</p>
                <p>Rapports Finals Validés: {{ $validatedFinalRapports }}/{{ $requiredFinalRapports }}</p>
                <p>Presentations Validées: {{ $validatedPresentations }}/{{ $requiredPresentations }}</p>
            </div>
        </div>
        <div class="mt-4 ml-6">
            @if (Auth::user()->type != 'stagiaire')
                <a href="{{ route('stagiaires.index') }}" class="btn btn-secondary">Back to List</a> &nbsp;&nbsp;
            @endif
            <a href="{{ route('stagiaires.edit', $stagiaire->id) }}" class="btn btn-warning">Edit</a> &nbsp;&nbsp;
            @if ($encadrant)
                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#encadrantModal">
                    View Encadrant
                </button>
            @endif
            <a href="{{ route('rapports.index') }}" class="btn btn-secondary">Liste des rapports</a>
        </div>
    </div>
    <!-- Encadrant Modal -->
    @if ($encadrant)
        <div class="modal fade" id="encadrantModal" tabindex="-1" aria-labelledby="encadrantModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="encadrantModalLabel">Votre Encadrant</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @if ($encadrant->profile_picture)
                            <div class="mb-3">
                                <label class="form-label">Profile :</label>
                                <img src="{{ asset('storage/' . $encadrant->profile_picture) }}" alt="Profile Picture"
                                    class="img-fluid"
                                    style="width: 150px; height: 150px; border-radius: 50%; margin-left: 10%;">
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
