@extends('layouts.app')
@section('title', 'Presentations')
@section('content')
    <div class="container">
        <h1>Presentations</h1>
        @if ($presentations->isEmpty())
            <div class="alert alert-info">
                Aucun présentation n'a encore été déposée.
            </div>
        @else
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Stagiaire</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Presentation</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presentations as $presentation)
                        <tr>
                            <td>
                                @if ($presentation->stagiaire)
                                    {{ $presentation->stagiaire->nom }} {{ $presentation->stagiaire->prenom }}
                                @else
                                    No stagiaire assigned
                                @endif
                            </td>
                            <td>{{ $presentation->title }}</td>
                            <td>
                                <!-- Display Current Status -->
                                @if ($presentation->status == 'validé')
                                    <span class="alert alert-success p-2">{{ $presentation->status }}</span>
                                @elseif($presentation->status == 'non validé')
                                    <span class="alert alert-danger p-2">{{ $presenentation->status }}</span>
                                @else
                                    <span class="alert alert-secondary p-2">{{ $presentation->status }}</span>
                                @endif
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#presentationModal"
                                    data-lien="{{ asset('storage/' . $presentation->lien) }}">
                                    Voir Presentation
                                </button>
                            </td>
                            <td>
                                <a href="{{ route('presentations.edit', $presentation->id) }}"
                                    class="text-warning btn btn-link p-0" style="font-size: 24px; margin-right: 5px;">
                                    <i class="ti ti-edit"></i></a>
                                <a href="{{ route('presentations.show', $presentation->id) }}"
                                    class="text-primary btn btn-link p-0" style="font-size: 24px; margin-right: 5px;">
                                    <i class="ti ti-info-circle"></i></a>
                                <form action="{{ route('presentations.destroy', $presentation->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-danger btn btn-link p-0"
                                        style="font-size: 24px; margin-right: 5px;"><i class="ti ti-trash"></i></button>
                                </form>
                                <!-- Status Change Buttons -->
                                @if (Auth::user()->type == 'encadrant')
                                    <form action="{{ route('presentations.approuver', $presentation->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-success btn btn-link p-0"
                                            style="font-size: 24px; margin-right: 5px;" title="valider presentation">
                                            <i class="ti ti-circle-check"></i></button>
                                    </form>
                                    <form action="{{ route('presentations.refuser', $presentation->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-danger btn btn-link p-0"
                                            style="font-size: 24px; margin-right: 5px;" title="refuser presentation">
                                            <i class="ti ti-playstation-x"></i></button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $presentations->links('pagination::bootstrap-4') }} <!-- Use Bootstrap 4 pagination -->
            </div>
        @endif
        @if (Auth::user()->type == 'stagiaire')
            <a href="{{ route('presentations.create') }}" class="btn btn-primary">Ajouter Presentation</a>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="presentationModal" tabindex="-1" aria-labelledby="presentationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="presentationModalLabel">Presentation File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="presentationFrame" src="" frameborder="0"
                        style="width: 100%; height: 600px;"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var presentationModal = document.getElementById('presentationModal');
            presentationModal.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var lien = button.getAttribute('data-lien');
                var modalBodyIframe = presentationModal.querySelector('#presentationFrame');
                modalBodyIframe.src = lien;
            });
            presentationModal.addEventListener('hidden.bs.modal', function(event) {
                var modalBodyIframe = presentationModal.querySelector('#presentationFrame');
                modalBodyIframe.src = ''; // Reset src attribute when modal is closed
            });
        });
    </script>
@endsection
