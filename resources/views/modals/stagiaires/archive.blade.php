<!-- Archive Confirmation Modal -->
<div class="modal fade" id="archiveModal{{ $stagiaire->id }}" tabindex="-1"
    aria-labelledby="archiveModalLabel{{ $stagiaire->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel{{ $stagiaire->id }}">Confirmer l'archivation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir archiver ce stagiaire ?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('stagiaires.archiver', $stagiaire->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-archive"></i> Archiver
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
