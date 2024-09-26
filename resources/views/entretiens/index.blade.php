{{-- resources/views/entretiens/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Entretiens')

@section('content')
    <div class="container">
        <h1>Entretiens</h1>
        <div class="d-flex justify-content-between align-items-center mb-3">
            {{-- <a href="{{ route('entretiens.create') }}" class="btn btn-primary mt-3" style="margin-bottom: 10px">Ajouter un
                Entretien</a>
            <a href="{{ route('entretiens.automateForm') }}" class="btn btn-secondary mt-3"
                style="margin-bottom: 10px">Automatiser
                les Entretiens</a> --}}
            <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#addEntretienModal">
                Ajouter un Entretien
            </button>
            <button class="btn btn-secondary mt-3" data-bs-toggle="modal" data-bs-target="#automateEntretienModal">
                Automatiser les Entretiens
            </button>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('refuse'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('refuse') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($entretiens->isEmpty())
        <div class="alert alert-info">
            Aucun entretien programmé pour le moment.
        </div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Stagiaire</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entretiens as $entretien)
                    <tr>
                        <td>
                            @if ($entretien->stagiaire)
                                {{ $entretien->stagiaire->nom }} {{ $entretien->stagiaire->prenom }}
                            @else
                                No stagiaire assigned
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y') }} {{ $entretien->time }}</td>
                        <td>{{ \Carbon\Carbon::parse($entretien->time)->format('H:i') }}</td>
                        <td>
                            @if ($entretien->status == 'approuvé')
                                <span class="alert alert-success p-2">{{ $entretien->status }}</span>
                            @elseif($entretien->status == 'refusé')
                                <span class="alert alert-danger p-2">{{ $entretien->status }}</span>
                            @elseif($entretien->status == 'en attente')
                                <span class="alert alert-warning p-2">{{ $entretien->status }}</span>
                            @endif
                        </td>
                        <td>
                            {{--  <a href="{{ route('entretiens.show', $entretien->id) }}" class="text-primary btn btn-link p-0"
                                style="font-size: 24px; margin-right: 5px;">
                                <i class="ti ti-info-circle"></i></a> --}}
                            <button type="button" class="text-info btn btn-link p-0"
                                style="font-size: 24px; margin-right: 5px;" data-bs-toggle="modal"
                                data-bs-target="#showEntretienModal{{ $entretien->id }}">
                                <i class="ti ti-info-circle"></i>
                            </button>
                            <a href="{{ route('entretiens.edit', $entretien->id) }}" class="text-warning btn btn-link p-0"
                                style="font-size: 24px; margin-right: 5px;">
                                <i class="ti ti-edit"></i></a>
                            <button type="button" class="text-danger btn btn-link p-0"
                                style="font-size: 24px; margin-right: 5px;" data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $entretien->id }}">
                                <i class="ti ti-trash"></i>
                            </button>
                            @include('modals.entretiens.delete', ['entretien' => $entretien])
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            {{-- Status Change Buttons --}}
                            @if ($entretien->status !== 'approuvé')
                                <form action="{{ route('entretiens.approuver', $entretien->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-success btn btn-link p-0"
                                        style="font-size: 24px; margin-right: 5px;" title="Approuver candidat">
                                        <i class="ti ti-circle-check"></i></button>
                                </form>
                            @endif
                            @if ($entretien->status !== 'refusé')
                                <form action="{{ route('entretiens.refuser', $entretien->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-danger btn btn-link p-0"
                                        style="font-size: 24px; margin-right: 5px;" title="Refuser candidat">
                                        <i class="ti ti-playstation-x"></i></button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @include('modals.entretiens.show', ['entretien' => $entretien])
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $entretiens->links('pagination::bootstrap-4') }}
        </div>
    @endif
    @include('modals.entretiens.create', ['stagiaires' => $stagiaires])
    @include('modals.entretiens.automate')
    </div>
@endsection
