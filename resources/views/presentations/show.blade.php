@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Presentation Details</h1>

        <div class="card">
            <div class="card-header">
                <strong>{{ $presentation->title }}</strong>
                <span class="badge {{ $presentation->status === 'validé' ? 'badge-success' : ($presentation->status === 'refusé' ? 'badge-danger' : 'badge-warning') }}">
                    {{ ucfirst($presentation->status) }}
                </span>
            </div>
            <div class="card-body">
                <p><strong>Stagiaire:</strong> {{ $presentation->stagiaire->nom }} {{ $presentation->stagiaire->prenom }}</p>
                <p><strong>Uploaded on:</strong> {{ $presentation->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>File:</strong> <a href="{{ asset('storage/' . $presentation->lien) }}" target="_blank">Download Presentation</a></p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('presentations.index') }}" class="btn btn-secondary">Back to List</a>

            @if ($presentation->status === 'en attente')
                <form action="{{ route('presentations.approuver', $presentation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>

                <form action="{{ route('presentations.refuser', $presentation->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">Refuse</button>
                </form>
            @endif
        </div>
    </div>
@endsection
