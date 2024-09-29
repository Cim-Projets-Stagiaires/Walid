<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal{{ $stagiaire->id }}" tabindex="-1"
    aria-labelledby="deleteModalLabel{{ $stagiaire->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $stagiaire->id }}">Confirmer la suppression</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir supprimer ce stagiaire ?
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('stagiaires.destroy', $stagiaire->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="ti ti-trash"></i>Supprimer</button>
                </form>
            </div>
           {{--  <form action="{{ route('stagiaires.destroy', $stagiaire->id) }}" method="POST"
                style="display:inline-block;">
                @csrf
                <!-- Use POST method instead of DELETE -->
                <button type="submit" class="text-danger btn btn-link p-0" style="font-size: 24px;">
                    <i class="ti ti-trash"></i>
                </button>
            </form> --}}
        </div>
    </div>
</div>
