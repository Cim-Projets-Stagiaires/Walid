@extends('layouts.app')

@section('title', 'Rapports')

@section('content')
    <div class="container">
        <h1>Rapports</h1>
        @if ($rapports->isEmpty())
            <div class="alert alert-info">
                Vous n'avez pas encore déposé aucun rapport.
            </div>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Stagiaire</th>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Rapport</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rapports as $rapport)
                        <tr>
                            <td>
                                @if ($rapport->stagiaire)
                                    {{ $rapport->stagiaire->nom }} {{ $rapport->stagiaire->prenom }}
                                @else
                                    No stagiaire assigned
                                @endif
                            </td>
                            <td>{{ $rapport->title }}</td>
                            <td>{{ $rapport->type }}</td>
                            <td>
                                <!-- Display Current Status -->
                                @if ($rapport->status == 'validé')
                                    <span class="alert alert-success p-2">{{ $rapport->status }}</span>
                                @elseif($rapport->status == 'non validé')
                                    <span class="alert alert-danger p-2">{{ $rapport->status }}</span>
                                @else
                                    <span class="alert alert-secondary p-2">{{ $rapport->status }}</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#rapportModal" data-lien="{{ asset('storage/' . $rapport->lien) }}">
                                    Voir Rapport
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('rapports.edit', $rapport->id) }}" class="text-info btn btn-link p-0"
                                    style="font-size: 24px; margin-right: 5px;">
                                    <i class="ti ti-edit"></i></a>
                                <a href="{{ route('rapports.download', $rapport->id) }}"
                                    class="text-success btn btn-link p-0" style="font-size: 24px; margin-right: 5px;"><i
                                        class="ti ti-download"></i></a>
                                <button type="button" class="text-danger btn btn-link p-0"
                                    style="font-size: 24px; margin-right: 5px;" data-bs-toggle="modal"
                                    data-bs-target="#deleteModal{{ $rapport->id }}">
                                    <i class="ti ti-trash"></i>
                                </button>
                                @include('modals.rapports.delete', ['rapport' => $rapport])
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $rapports->links('pagination::bootstrap-4') }} <!-- Use Bootstrap 4 pagination -->
            </div>
        @endif
        @if (Auth::user()->type == 'stagiaire')
            <a href="{{ route('rapports.create') }}" class="btn btn-primary">Ajouter Rapport</a>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="rapportModal" tabindex="-1" aria-labelledby="rapportModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="rapportModalLabel">Rapport File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($rapport)
                        <iframe id="rapportFrame" src="{{ asset('storage/' . $rapport->lien) }}" frameborder="0"
                            style="width: 100%; height: 600px;"></iframe>
                    @else
                        <div class="alert alert-info">
                            Vous n'avez pas encore déposé de rapport.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var rapportModal = document.getElementById('rapportModal');
            rapportModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var lien = button.getAttribute('data-lien');
                var modalBodyIframe = rapportModal.querySelector('#rapportFrame');
                modalBodyIframe.src = lien;
            });
            rapportModal.addEventListener('hidden.bs.modal', function(event) {
                var modalBodyIframe = rapportModal.querySelector('#rapportFrame');
                modalBodyIframe.src = ''; // Reset src attribute when modal is closed
            });
        });
    </script>
@endsection
