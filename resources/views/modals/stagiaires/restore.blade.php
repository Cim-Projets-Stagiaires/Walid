<!-- Restore Confirmation Modal -->
<div class="modal fade" id="restoreModal{{ $stagiaire->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $stagiaire->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $stagiaire->id }}">Confirmer la restauration</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir restaurer ce stagiaire ?
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('stagiaires.restore', $stagiaire->id) }}" method="POST"
                    style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-secondary">
                        <i class="ti ti-rotate-clockwise"></i> Restaurer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
