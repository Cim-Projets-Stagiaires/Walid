@extends('layouts.app')

@section('title', 'Demande de Stage Details')

@section('content')
    <style>
        .iframe {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            border: none;
            border-radius: 10px;
            width: 70%;
            height: 90%;
            z-index: 10;
            display: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: flex-end;
            align-items: flex-start;
            padding: 10px;
            box-sizing: border-box;
            z-index: 2;
        }
    </style>
    <div class="container">
        <h1>Demande de Stage Details</h1>
        <br>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Stagiaire</label>
                <p>{{ $demande->stagiaire->nom }} {{ $demande->stagiaire->prenom }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Etablissement</label>
                <p>{{ $demande->etablissement }}</p>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Type de Stage</label>
                <p>{{ $demande->type_de_stage }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Modalité de Stage</label>
                <p>{{ $demande->modalite_de_stage }}</p>
            </div>
        </div>
        <div class="row">
            <div class="mb-3 col">
                <label class="form-label">Obligation</label>
                <p>{{ $demande->obligation }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Status</label>
                <p>{{ $demande->status }}</p>
            </div>
        </div>
        <br>
        <div class="row mt">
            <div class="mb-3 col">
                <label class="form-label">Date de Début</label>
                <p>{{ $demande->date_de_debut }}</p>
            </div>
            <div class="mb-3 col">
                <label class="form-label">Date de Fin</label>
                <p>{{ $demande->date_de_fin }}</p>
            </div>
        </div>
        <div class="row">
            @if ($demande->cv)
                <div class="mb-3 col">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cvModal">
                        View CV
                    </button>
                </div>
            @endif
            @if ($demande->lettre_de_motivation)
                <div class="mb-3 col">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#lettreModal">
                        View Lettre de motivation
                    </button>
                </div>
            @endif
            @if ($demande->attestation_assurance)
                <div class="mb-3 col">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#attestationModal">
                        View Attestation d'assurance
                    </button>
                </div>
            @endif
        </div>
        <a href="{{ route('demande-de-stage.index') }}" class="btn btn-secondary">Back to List</a>
        <form action="{{ route('demande-de-stage.approve', $demande->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-success">Approve</button>
        </form>
        <form action="{{ route('demande-de-stage.deny', $demande->id) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger">Deny</button>
        </form>
    </div>

    <!-- CV Modal -->
    <div class="modal fade" id="cvModal" tabindex="-1" aria-labelledby="cvModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cvModalLabel">CV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="cvFrame" src="{{ asset('storage/' . $demande->cv) }}" frameborder="0"
                        style="width: 100%; height: 600px;"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- lettre Modal -->
    <div class="modal fade" id="lettreModal" tabindex="-1" aria-labelledby="lettreModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="lettreModalLabel">Lettre de motivation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="cvFrame" src="{{ asset('storage/' . $demande->lettre_de_motivation) }}" frameborder="0"
                        style="width: 100%; height: 600px;"></iframe>
                </div>
            </div>
        </div>
    </div>
     <!-- attestation Modal -->
     <div class="modal fade" id="attestationModal" tabindex="-1" aria-labelledby="attestationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attestationModalLabel">attestation d'assurance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="cvFrame" src="{{ asset('storage/' . $demande->attestation_assurance) }}" frameborder="0"
                        style="width: 100%; height: 600px;"></iframe>
                </div>
            </div>
        </div>
    </div>

@endsection
