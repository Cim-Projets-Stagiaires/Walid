<!-- Stagiaire Modal -->
<div class="modal fade" id="stagiaireModal{{ $stagiaire->id }}" tabindex="-1"
    aria-labelledby="stagiaireModalLabel{{ $stagiaire->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stagiaireModalLabel{{ $stagiaire->id }}">Détails du Stagiaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Profile Picture -->
                @if ($stagiaire->profile_picture)
                    <div class="d-flex justify-content-center mb-3">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $stagiaire->profile_picture) }}" alt="Profile Picture"
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
                            <p><strong>Nom: </strong>{{ $stagiaire->nom }}</p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%;">
                            <p><strong>Prénom: </strong>{{ $stagiaire->prenom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Téléphone: </strong>{{ $stagiaire->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%;">
                            <p><strong>Email: </strong>{{ $stagiaire->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Encadrement: </strong>
                                @if ($stagiaire->encadrant)
                                    {{ $stagiaire->encadrant->nom }} {{ $stagiaire->encadrant->prenom }}
                                @else
                                    Non attribué
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%;">
                            <p><strong>Pole: </strong>{{ $stagiaire->demande->pole }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Etablissement: </strong>{{ $stagiaire->demande->etablissement }}</p>
                        </div>
                    </div>
                </div>
                <!-- Progress Bar Section -->
                <div class="mt-4">
                    <h4>Progression</h4>
                    <div class="progress my-4">
                        <div class="progress-bar" role="progressbar"
                            style="width: {{ $stagiaire->progress }}%; background-color: #50ec49;"
                            aria-valuenow="{{ $stagiaire->progress }}" aria-valuemin="0" aria-valuemax="100">
                            {{ round($stagiaire->progress, 2) }}%
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Rapports Semi Validés:
                            {{ $stagiaire->validatedSemiRapports }}/{{ $stagiaire->requiredSemiRapports }}</p>
                        <p>Rapports Finals Validés:
                            {{ $stagiaire->validatedFinalRapports }}/{{ $stagiaire->requiredFinalRapports }}</p>
                        <p>Presentations Validées:
                            {{ $stagiaire->validatedPresentations }}/{{ $stagiaire->requiredPresentations }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between w-100">
                <div>
                    <a href="{{ route('rapports.list', $stagiaire->id) }}" class="btn btn-primary me-2">Les
                        Rapports</a>
                    <a href="{{ route('presentations.list', $stagiaire->id) }}" class="btn btn-secondary">Les
                        Presentations</a>
                </div>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
