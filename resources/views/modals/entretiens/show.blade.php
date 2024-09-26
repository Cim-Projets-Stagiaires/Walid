<div class="modal fade" id="showEntretienModal{{ $entretien->id }}" tabindex="-1" aria-labelledby="showEntretienModalLabel{{ $entretien->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="showEntretienModalLabel{{ $entretien->id }}">Détails de l'Entretien #{{ $entretien->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p><strong>Stagiaire:</strong>
                    @if ($entretien->stagiaire)
                        {{ $entretien->stagiaire->nom }} {{ $entretien->stagiaire->prenom }}
                    @else
                        No stagiaire assigned
                    @endif
                </p>
                <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($entretien->date)->format('d/m/Y') }}</p>
                <p><strong>Heure:</strong> {{ \Carbon\Carbon::parse($entretien->time)->format('H:i') }}</p>
                <p><strong>Status:</strong>
                    @if ($entretien->status == 'approuvé')
                        <span class="badge bg-success p-2">{{ $entretien->status }}</span>
                    @elseif($entretien->status == 'refusé')
                        <span class="badge bg-danger p-2">{{ $entretien->status }}</span>
                    @elseif($entretien->status == 'en attente')
                        <span class="badge bg-warning text-dark p-2">{{ $entretien->status }}</span>
                    @endif
                </p>
                <p><strong>Créé le:</strong> {{ $entretien->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Mis à Jour le:</strong> {{ $entretien->updated_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
