@extends('layouts.app')
@section('title', 'Détails de l\'Entretien')
@section('content')
    <div class="container">
        <h1>Détails de l'Entretien</h1>
        <div class="card">
            <div class="card-header">
                Entretien #{{ $entretien->id }}
            </div>
            <div class="card-body">
                <p><strong>Stagiaire:</strong>
                    @if ($entretien->stagiaire)
                        {{ $entretien->stagiaire->nom }} {{ $entretien->stagiaire->prenom }}
                    @else
                        No stagiaire assigned
                    @endif
                </p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y') }}</p>
                <p><strong>Heure:</strong> {{ \Carbon\Carbon::parse($entretien->time)->format('H:i') }}</p> <!-- Added time display -->
                <p><strong>Status:</strong>
                    @if ($entretien->status == 'approuvé')
                    <span class="alert alert-success p-2">{{ $entretien->status }}</span>
                    @elseif($entretien->status == 'refusé')
                    <span class="alert alert-danger p-2">{{ $entretien->status }}</span>
                    @elseif($entretien->status == 'en attente')
                    <span class="alert alert-warning p-2">{{ $entretien->status }}</span>
                    @endif
                </p>
                <p><strong>Créé le:</strong> {{ $entretien->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Mis à Jour le:</strong> {{ $entretien->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        <a href="{{ route('entretiens.index') }}" class="btn btn-secondary mt-3">Retour</a>
    </div>
@endsection
