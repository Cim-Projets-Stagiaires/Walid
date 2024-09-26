<div class="modal fade" id="createEncadrantModal" tabindex="-1" aria-labelledby="createEncadrantModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEncadrantModalLabel">Créer un Encadrant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('encadrants.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="nom" class="form-label">Nom</label>
                            <input type="text" name="nom" class="form-control" id="nom" required>
                        </div>
                        <div class="mb-3 col">
                            <label for="prenom" class="form-label">Prénom</label>
                            <input type="text" name="prenom" class="form-control" id="prenom" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="mb-3 col">
                            <label for="phone" class="form-label">Téléphone</label>
                            <input type="text" name="phone" class="form-control" id="phone" required>
                        </div>
                        <div class="mb-3 col">
                            <label for="etablissement" class="form-label">Etablissement</label>
                            <select name="etablissement" class="form-control" id="etablissement" required>
                                <option value="FST">FST</option>
                                <option value="ENSA">ENSA</option>
                                <option value="FSSM">FSSM</option>
                                <option value="ENS">ENS</option>
                                <option value="ENSAM">ENSAM</option>
                                <option value="ENSAS">ENSAS</option>
                                <option value="ESTE">ESTE</option>
                                <option value="ESTS">ESTS</option>
                                <option value="ENSAS">FLAM</option>
                                <option value="FLSH">FLSH</option>
                                <option value="FMPM">FMPM</option>
                                <option value="FPS">FPS</option>
                                <option value="FSJES">FSJES</option>
                                <option value="CIM">Cité d'innovation</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3 radio-container">
                        <label for="permanent" class="form-label">Permanent</label>
                        <label>
                            <input type="radio" name="permanent" value="1" required>
                            <span>Oui</span>
                        </label>
                        <label>
                            <input type="radio" name="permanent" value="0" required>
                            <span>Non</span>
                        </label>
                    </div>
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Photo de Profil</label>
                        <input type="file" name="profile_picture" class="form-control" id="profile_picture">
                    </div>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </form>
            </div>
        </div>
    </div>
</div>
