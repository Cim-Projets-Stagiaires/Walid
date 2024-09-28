<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <title>Demande de stage</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon-cim.png') }}" />
</head>
<style>
</style>
<body class="demande-body">
    <div class="container" style="width: 800px">
        <div class="image-container">
            <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO" />
        </div>
        <div class="title">Demande de stage</div>
        <div class="content">
            <form action="{{ route('demande-de-stage.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="request-details">
                    <div class="input-box">
                        <span class="details">Nom</span>
                        <input type="text" placeholder="Entrez votre nom" value="{{ auth()->user()->nom }}"
                            disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Prénom</span>
                        <input type="text" placeholder="Entrez votre prénom" value="{{ auth()->user()->prenom }}"
                            disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" placeholder="Entrez votre email" value="{{ auth()->user()->email }}"
                            disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Numéro de téléphone</span>
                        <input type="text" pattern="^0[67]\d{8}$" title="Entrez un numéro de téléphone valide."
                            placeholder="Entrez votre numéro de téléphone" disabled
                            value="{{ auth()->user()->phone }}" />
                    </div>
                    <div class="input-box">
                        <span class="details">Établissement</span>
                        <select id="etablissement" required name="etablissement">
                            <option selected hidden disabled>
                                Choisissez votre établissement
                            </option>
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
                            <option value="Autre">Autre</option>
                        </select>
                        @error('etablissement')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Type de stage</span>
                        <select id="type-de-stage" name="type_de_stage" required>
                            <option selected hidden disabled>
                                Choisissez le type de stage
                            </option>
                            <option value="Fin d'études">Fin d'études</option>
                            <option value="Fin d'année">Fin d'année</option>
                            <option value="Observation">Observation</option>
                            <option value="Techniques d'analyse">
                                Techniques d'analyse
                            </option>
                            <option value="Autres">Autre</option>
                        </select>
                        @error('type_de_stage')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div style="display: flex; gap: 20px; grid-column: span 2">
                        <div class="input-box" id="autre-etablissement" style="display: none">
                            <input type="text" name="autre_etablissement"
                                placeholder="Veuillez spécifier l'établissement" />
                        </div>
                        <div class="input-box" id="autre-type-de-stage" style="display: none">
                            <input type="text" name="autre_type_de_stage"
                                placeholder="Veuillez spécifier le type de stage" />
                        </div>
                    </div>
                    <div class="stage-details" style="grid-column: span 2">
                        <input type="radio" name="modalite_de_stage" value="mi-temps" id="dot-6" required />
                        <input type="radio" name="modalite_de_stage" value="plein-temps" id="dot-7" />
                        <input type="radio" name="modalite_de_stage" value="alternance" id="dot-8" />
                        <span class="stage-title">Modalite de stage :</span>
                        <div class="condition">
                            <label for="dot-6">
                                <span class="dot six"></span>
                                <span class="type">mi-temps</span>
                            </label>
                            <label for="dot-7">
                                <span class="dot seven"></span>
                                <span class="type">plein temps</span>
                            </label>
                            <label for="dot-8">
                                <span class="dot eight"></span>
                                <span class="type">alternance</span>
                            </label>
                            @error('modalite_de_stage')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="input-box" id="planning-mi-temps" style="display: none; grid-column: span 2">
                        <input type="text" name="planning_mi_temps"
                            placeholder="Planning du stage dans le cas d'un stage à mi-temps" />
                    </div>
                    <div class="stage-details" style="grid-column: span 2">
                        <input type="radio" name="obligation" value="obligatoire" id="dot-1" required />
                        <input type="radio" name="obligation" value="libre" id="dot-2" />
                        <span class="stage-title">Le stage est :</span>
                        <div class="category">
                            <label for="dot-1">
                                <span class="dot one"></span>
                                <span class="type">Obligatoire</span>
                            </label>
                            <label for="dot-2">
                                <span class="dot two"></span>
                                <span class="type">Libre</span>
                            </label>
                            @error('obligation')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="input-box" style="grid-column: span 2">
                        <span class="details">Pole d'integration dans la CIM</span>
                        <select id="pole" name="pole" required>
                            <option selected hidden disabled>
                                Choisissez le Pole
                            </option>
                            <option value="Services transverses">
                                Services transverses (informatique, automates, techniques)
                            </option>
                            <option value="Incubation">Incubation (Entreprenariat)</option>
                            <option value="Valorisation">Valorisation (Chimie, Physique, Biologie)</option>
                        </select>
                        @error('pole')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Date de début</span>
                        <input type="date" name="date_de_debut" required />
                        @error('date_de_debut')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Date de fin</span>
                        <input type="date" name="date_de_fin" required />
                        @error('date_de_fin')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Ajoutez CV</span>
                        <input type="file" id="cv-upload" name="cv" accept="application/pdf" hidden
                            onchange="updateFileName('cv-upload', 'cv-file-name')" />
                        <label for="cv-upload" class="custom-file-upload">
                            Choisir fichier
                        </label>
                        <span id="cv-file-name" class="file-name"></span>
                        @error('cv')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Ajoutez lettre de motivation</span>
                        <input type="file" id="lettre-upload" name="lettre_de_motivation" accept="application/pdf"
                            hidden onchange="updateFileName('lettre-upload', 'lettre-file-name')" />
                        <label for="lettre-upload" class="custom-file-upload">
                            Choisir fichier
                        </label>
                        <span id="lettre-file-name" class="file-name"></span>
                        @error('lettre_de_motivation')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="input-box">
                        <span class="details">Ajoutez attestation d'assurance</span>
                        <input type="file" id="attestation-upload" name="attestation_assurance"
                            accept="application/pdf" hidden
                            onchange="updateFileName('attestation-upload', 'attestation-file-name')" />
                        <label for="attestation-upload" class="custom-file-upload">
                            Choisir fichier
                        </label>
                        <span id="attestation-file-name" class="file-name"></span>
                        @error('attestation_assurance')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    {{-- <div class="input-box" style="grid-column: span 2">
                        <span class="details">Objectifs de stage</span>
                        <textarea name="objectif_de_stage" placeholder="Décrivez vos objectifs de stage ici..."></textarea>
                        @error('objectif_de_stage')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div> --}}
                </div>
                <div class="button">
                    <input type="submit" value="Soumettre" />
                </div>
            </form>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <script>
                window.onpageshow = function(event) {
                    if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
                        document.getElementById('logout-form').submit();
                    }
                };
            </script>
        </div>
    </div>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
