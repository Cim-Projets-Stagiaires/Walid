<!-- resources/views/rapports/show.blade.php -->
@extends('layouts.app')

@section('title', 'View Rapport')

@section('content')
<div class="container">
    <h1>{{ $rapport->title }}</h1>
    <div class="mb-3">
        <label for="stagiaire" class="form-label">Stagiaire</label>
        <p id="stagiaire">
            {{ $rapport->stagiaire ? $rapport->stagiaire->nom . ' ' . $rapport->stagiaire->prenom : 'No stagiaire assigned' }}
        </p>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <p id="type">{{ $rapport->type }}</p>
    </div>
    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <p id="content">{{ $rapport->content }}</p>
    </div>
    <div class="mb-3">
        <label for="rapport-file" class="form-label">Rapport File</label>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#rapportModal">
            View Rapport
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="rapportModal" tabindex="-1" aria-labelledby="rapportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rapportModalLabel">Rapport File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe src="{{ asset('storage/' . $rapport->lien) }}" frameborder="0" style="width: 100%; height: 600px;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
