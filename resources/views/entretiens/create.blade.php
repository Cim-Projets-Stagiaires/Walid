@extends('layouts.app')

@section('title', 'Ajouter un Entretien')

@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="col-md-8">
            <h1 class="text-center mb-4">Ajouter un Entretien</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Attention!</strong> Il y a des problèmes avec vos entrées.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('entretiens.store') }}" method="POST">
                @csrf

                <div class="form-row d-flex justify-content-between mb-3">
                    <div class="form-group col-md-4">
                        <label for="id_stagiaire">Stagiaire</label>
                        <select name="id_stagiaire" id="id_stagiaire" class="form-control" required>
                            <option value="">-- Sélectionnez un stagiaire --</option>
                            @foreach ($stagiaires as $stagiaire)
                                <option value="{{ $stagiaire->id }}"
                                    {{ old('id_stagiaire') == $stagiaire->id ? 'selected' : '' }}>
                                    {{ $stagiaire->nom }} {{ $stagiaire->prenom }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="form-group col-md-4">
                        <label for="date">Date de l'Entretien</label>
                        <input type="date" name="date" id="date" class="form-control" value="{{ old('date') }}"
                            required>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="form-group col-md-4">
                        <label for="time">Heure de l'entretien</label>
                        <div class="input-group">
                            <input type="time" name="time" id="time" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3">Créer</button>
                    <a href="{{ route('entretiens.index') }}" class="btn btn-secondary mt-3">Retour</a>
                </div>
            </form>
        </div>
    </div>
@endsection
