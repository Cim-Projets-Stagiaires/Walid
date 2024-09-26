<div class="modal fade" id="automateEntretienModal" tabindex="-1" aria-labelledby="automateEntretienModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="automateEntretienModalLabel">Automatiser les Entretiens</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Oops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('entretiens.automate') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="date">Date de l'Entretien</label>
                        <input type="date" name="date" id="date" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="start_time">Heure de début</label>
                        <input type="time" name="start_time" id="start_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_time">Heure de fin</label>
                        <input type="time" name="end_time" id="end_time" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="number_of_stagiaires">Nombre de Stagiaires</label>
                        <input type="number" name="number_of_stagiaires" id="number_of_stagiaires" class="form-control" min="1" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Créer Entretiens</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
