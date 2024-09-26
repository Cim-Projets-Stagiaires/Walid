<div class="modal fade" id="addEntretienModal" tabindex="-1" aria-labelledby="addEntretienModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEntretienModalLabel">Ajouter un Entretien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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

                    <div class="mb-3">
                        <label for="id_stagiaire">Stagiaire</label>
                        <select name="id_stagiaire" id="id_stagiaire" class="form-control" required>
                            <option value="">-- Sélectionnez un stagiaire --</option>
                            @foreach ($stagiaires as $stagiaire)
                                <option value="{{ $stagiaire->id }}">{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="date">Date de l'Entretien</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="time">Heure de l'entretien</label>
                        <input type="time" name="time" id="time" class="form-control" required>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Créer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
