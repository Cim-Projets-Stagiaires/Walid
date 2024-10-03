@extends('layouts.app')

@section('title', 'Stagiaires')

@section('content')
    <div class="container">
        <h1>Stagiaires</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <!-- Pole Filter Form -->
        <form method="GET" action="{{ route('stagiaires.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="pole" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Tout les Poles --</option>
                        @foreach ($poles as $pole)
                            <option value="{{ $pole }}" {{ $selectedPole == $pole ? 'selected' : '' }}>
                                {{ $pole }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
        @if ($stagiaires->isEmpty())
            <div class="alert alert-info">Aucun stagiaire trouvé.</div>
        @else
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="text-center">Profile Picture</th>
                        <th class="text-center">Matricule</th>
                        <th class="text-center">Nom</th>
                        <th class="text-center">Prénom</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Encadrant</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stagiaires as $stagiaire)
                        <tr>
                            <td class="text-center">
                                @if ($stagiaire->profile_picture)
                                    <img src="{{ asset('storage/' . $stagiaire->profile_picture) }}" alt="Profile Picture"
                                        class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('/assets/images/profile/default-profile.png') }}"
                                        alt="Default Profile Picture" class="rounded-circle"
                                        style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            @php
                                // Get the current year
                                $year = \Carbon\Carbon::now()->format('y'); // Current year (e.g., '24')
                            @endphp
                            @if ($stagiaire->demande->pole == 'Services transverses')
                                <td class="text-center">{{ $year }}/ST/{{ $stagiaire->code }}</td>
                            @elseif($stagiaire->demande->pole == 'Valorisation')
                                <td class="text-center">{{ $year }}/Val/{{ $stagiaire->code }}</td>
                            @else
                                <td class="text-center">{{ $year }}/Inc/{{ $stagiaire->code }}</td>
                            @endif
                            <td class="text-center">{{ $stagiaire->nom }}</td>
                            <td class="text-center">{{ $stagiaire->prenom }}</td>
                            <td class="text-center">{{ $stagiaire->email }}</td>
                            <td class="text-center">
                                @if ($stagiaire->encadrant)
                                    {{ $stagiaire->encadrant->nom }} {{ $stagiaire->encadrant->prenom }}
                                @else
                                    Not Assigned
                                @endif
                            </td>
                            <td class="text-center">
                                {{-- <a href="{{ route('stagiaires.show', $stagiaire->id) }}" class="btn btn-link p-0 text-info"
                                    style="font-size: 24px;" title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a> --}}
                                <a href="#" class="btn btn-link p-0 text-info" style="font-size: 24px;"
                                    data-bs-toggle="modal" data-bs-target="#stagiaireModal{{ $stagiaire->id }}"
                                    title="Voir">
                                    <i class="ti ti-eye"></i>
                                </a>
                                <a href="{{ route('stagiaires.edit', $stagiaire->id) }}"
                                    class="btn btn-link p-0 text-success" style="font-size: 24px;" title="Modifier">
                                    <i class="ti ti-pencil"></i>
                                </a>
                                {{-- <form action="{{ route('stagiaires.destroy', $stagiaire->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 text-danger" style="font-size: 24px;"
                                        title="Supprimer">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form> --}}
                                <!-- Delete Button triggers the modal -->
                                <button type="button" class="btn btn-link p-0 text-danger" style="font-size: 24px;"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $stagiaire->id }}"
                                    title="Supprimer">
                                    <i class="ti ti-trash"></i>
                                </button>
                                @if ($stagiaire->deleted == false)
                                    {{-- Archive Button triggers the modal --}}
                                    <button type="button" class="btn btn-link p-0 text-warning" style="font-size: 24px;"
                                        data-bs-toggle="modal" data-bs-target="#archiveModal{{ $stagiaire->id }}"
                                        title="Archiver stagiaire">
                                        <i class="ti ti-archive"></i>
                                    </button>
                                @elseif($stagiaire->deleted == true)
                                    {{-- Restore Button triggers the modal --}}
                                    <button type="button" class="btn btn-link p-0 text-secondary" style="font-size: 24px;"
                                        data-bs-toggle="modal" data-bs-target="#restoreModal{{ $stagiaire->id }}"
                                        title="Restaurer stagiaire">
                                        <i class="ti ti-rotate-clockwise"></i>
                                    </button>
                                @endif
                                <a href="{{ route('stagiaires.downloadAttestation', $stagiaire->id) }}"
                                    class="btn btn-link p-0 text-success" style="font-size: 24px;" title="Generer attetestation">
                                    <i class="ti ti-file-text"></i>
                                </a>
                            </td>
                        </tr>
                        <!-- Include the stagiaire modals -->
                        @include('modals.stagiaires.show', ['stagiaire' => $stagiaire])
                        @include('modals.stagiaires.delete', ['stagiaire' => $stagiaire])
                        @include('modals.stagiaires.archive', ['stagiaire' => $stagiaire])
                        @include('modals.stagiaires.restore', ['stagiaire' => $stagiaire])
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-3">
                {{ $stagiaires->links('pagination::bootstrap-4') }}
            </div>
        @endif
    </div>
@endsection
