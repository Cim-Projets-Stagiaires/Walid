<div class="modal fade" id="showAdminModal{{ $admin->id }}" tabindex="-1"
    aria-labelledby="showAdminModalLabel{{ $admin->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showAdminModalLabel{{ $admin->id }}">Détails de l'Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($admin->profile_picture)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $admin->profile_picture) }}" alt="Profile Picture"
                            class="img-fluid" style="width: 150px; height: 150px; border-radius: 50%;">
                    </div>
                @endif
                <div class="d-flex justify-content-center">
                    <div class="row w-75 pt-3">
                        <div class="col-md-6 mb-3">
                            <p><strong>Nom: </strong>{{ $admin->nom }}</p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%">
                            <p><strong>Prénom: </strong>{{ $admin->prenom }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <p><strong>Téléphone: </strong>{{ $admin->phone }}</p>
                        </div>
                        <div class="col-md-6 mb-3" style="padding-left: 15%">
                            <p><strong>Email: </strong>{{ $admin->email }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('admins.edit', $admin->id) }}" class="btn btn-warning">Modifier</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
