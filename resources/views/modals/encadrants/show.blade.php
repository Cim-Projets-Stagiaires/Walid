<!-- encadrant Modal -->
<div class="modal fade" id="encadrantModal{{ $encadrant->id }}" tabindex="-1"
    aria-labelledby="encadrantModalLabel{{ $encadrant->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="encadrantModalLabel{{ $encadrant->id }}">Détails du encadrant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Profile Picture -->
                @if ($encadrant->profile_picture)
                    <div class="d-flex justify-content-center mb-3">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $encadrant->profile_picture) }}" alt="Profile Picture"
                                class="img-fluid" style="width: 150px; height: 150px; border-radius: 50%;">
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning text-center">
                        Veuillez ajouter votre photo de profil.
                    </div>
                @endif
                <!-- Personal Information -->
                <div class="d-flex justify-content-center">
                    <div class="row w-75">
                        <div class="col-md-6 mb-3">
                            <p><strong>Nom: </strong>{{ $encadrant->nom }}</p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%;">
                            <p><strong>Prénom: </strong>{{ $encadrant->prenom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Téléphone: </strong>{{ $encadrant->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%;">
                            <p><strong>Email: </strong>{{ $encadrant->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Permanent: </strong>{{ $encadrant->permanent ? 'oui' : 'non' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <div>
                    <a href="{{ route('encadrants.edit', $encadrant->id) }}" class="btn btn-warning me-2">Edit</a>
                    <a href="{{ route('encadrants.stagiaires', $encadrant->id) }}" class="btn btn-primary">Liste des Stagiaires</a>
                </div>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
