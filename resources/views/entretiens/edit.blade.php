{{-- resources/views/entretiens/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Modifier un Entretien')

@section('content')
    <div class="container">
        <h1>Modifier un Entretien</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Il y a des problèmes avec vos entrées.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('entretiens.update', $entretien->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row md-3">
                <div class="form-group col-6">
                    <label for="id_stagiaire">Stagiaire</label>
                    <select name="id_stagiaire" id="id_stagiaire" class="form-control" required>
                        <option value="">-- Sélectionnez un stagiaire --</option>
                        @foreach ($stagiaires as $stagiaire)
                            <option value="{{ $stagiaire->id }}"
                                {{ old('id_stagiaire', $entretien->id_stagiaire) == $stagiaire->id ? 'selected' : '' }}>
                                {{ $stagiaire->nom }} {{ $stagiaire->prenom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="date">Date de l'Entretien</label>
                    <input type="date" name="date" id="date" class="form-control"
                        value="{{ old('date', $entretien->date) }}" required>
                </div>
            </div>

            <div class="row md-3">
                <div class="form-group col-6">
                    <label for="time">Heure de l'entretien</label>
                    <div class="input-group">
                        <input type="time" name="time" id="time" class="form-control">
                    </div>
                </div>
                <div class="form-group col-6">
                    <label for="status">Statut</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="en attente"
                            {{ old('status', $entretien->status) == 'en attente' ? 'selected' : '' }}>
                            En Attente</option>
                        <option value="approuvé" {{ old('status', $entretien->status) == 'approuvé' ? 'selected' : '' }}>
                            Approuvé</option>
                        <option value="refusé" {{ old('status', $entretien->status) == 'refusé' ? 'selected' : '' }}>Refusé
                        </option>
                    </select>
                </div>
            </div>
            <div class="d-flex justify-content-evenly">
                <button type="submit" class="btn btn-primary mt-3" {{-- style="margin: 0px 50px 0px 0px;" --}}>Mettre à Jour</button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('entretiens.index') }}" class="btn btn-secondary mt-3">Retour</a>
            </div>
        </form>
    </div>
@endsection
