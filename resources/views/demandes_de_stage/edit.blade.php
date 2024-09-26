<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Éditer Demande de stage</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <script src="{{ asset('assets/js/scripts.js') }}" defer></script>
</head>

<body class="demande-body">
    @if ($errors->any())
        {{-- Dump and die the errors --}}
        {{ dd($errors) }}
    @endif
    <div class="container" style="width: 800px">
        <div class="image-container">
            <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO" />
        </div>
        <div class="title">Éditer Demande de stage</div>
        <div class="content">
            <form action="{{ route('demande-de-stage.update', $demande->id_stagiaire) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="request-details">
                    <div class="input-box">
                        <span class="details">Nom</span>
                        <input type="text" value="{{ auth()->user()->nom }}" disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Prénom</span>
                        <input type="text" value="{{ auth()->user()->prenom }}" disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Email</span>
                        <input type="email" value="{{ auth()->user()->email }}" disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Numéro de téléphone</span>
                        <input type="text" value="{{ auth()->user()->phone }}" disabled />
                    </div>
                    <div class="input-box">
                        <span class="details">Établissement</span>
                        <select id="etablissement" required name="etablissement">
                            <option disabled>Choisissez votre établissement</option>
                            <option value="FST" {{ $demande->etablissement == 'FST' ? 'selected' : '' }}>FST</option>
                            <option value="ENSA" {{ $demande->etablissement == 'ENSA' ? 'selected' : '' }}>ENSA</option>
                            <option value="FSSM" {{ $demande->etablissement == 'FSSM' ? 'selected' : '' }}>FSSM</option>
                            <option value="CIM" {{ $demande->etablissement == 'CIM' ? 'selected' : '' }}>Cité d'innovation</option>
                            <option value="Autre" {{ $demande->etablissement == 'Autre' ? 'selected' : '' }}>Autre</option>
                        </select>
                        <input type="text" id="autre-etablissement" name="autre_etablissement" style="display:none; margin-top: 10px;" placeholder="Précisez votre établissement" value="{{ old('autre_etablissement', $demande->autre_etablissement) }}" />
                        @error('etablissement')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Type de stage</span>
                        <select id="type-de-stage" name="type_de_stage" required>
                            <option disabled>Choisissez le type de stage</option>
                            <option value="Fin d'études" {{ $demande->type_de_stage == "Fin d'études" ? 'selected' : '' }}>Fin d'études</option>
                            <option value="Fin d'année" {{ $demande->type_de_stage == "Fin d'année" ? 'selected' : '' }}>Fin d'année</option>
                            <option value="Observation" {{ $demande->type_de_stage == 'Observation' ? 'selected' : '' }}>Observation</option>
                            <option value="Techniques d'analyse" {{ $demande->type_de_stage == "Techniques d'analyse" ? 'selected' : '' }}>Techniques d'analyse</option>
                            <option value="Autres" {{ $demande->type_de_stage == 'Autres' ? 'selected' : '' }}>Autre</option>
                        </select>
                        <input type="text" id="autre-type-de-stage" name="autre_type_de_stage" style="display:none; margin-top: 10px;" placeholder="Précisez le type de stage" value="{{ old('autre_type_de_stage', $demande->autre_type_de_stage) }}" />
                        @error('type_de_stage')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="stage-details" style="grid-column: span 2">
                        <input type="radio" name="modalite_de_stage" value="mi-temps" id="dot-6" required {{ $demande->modalite_de_stage == 'mi-temps' ? 'checked' : '' }} />
                        <input type="radio" name="modalite_de_stage" value="plein-temps" id="dot-7" {{ $demande->modalite_de_stage == 'plein-temps' ? 'checked' : '' }} />
                        <input type="radio" name="modalite_de_stage" value="alternance" id="dot-8" {{ $demande->modalite_de_stage == 'alternance' ? 'checked' : '' }} />
                        <span class="stage-title">Modalité de stage :</span>
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
                        <input type="text" id="planning-mi-temps" name="planning_mi_temps" style="margin-top: 10px;" placeholder="Précisez les détails si vous choisissez mi-temps" value="{{ old('mi_temps', $demande->mi_temps) }}" />
                    </div>
                    <div class="stage-details" style="grid-column: span 2">
                        <input type="radio" name="obligation" value="obligatoire" id="dot-1" required {{ $demande->obligation == 'obligatoire' ? 'checked' : '' }} />
                        <input type="radio" name="obligation" value="libre" id="dot-2" {{ $demande->obligation == 'libre' ? 'checked' : '' }} />
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
                        <span class="details">Pôle d'intégration dans la CIM</span>
                        <select id="pole" name="pole" required>
                            <option disabled>Choisissez le pôle</option>
                            <option value="Services transverses" {{ $demande->pole == 'Services transverses' ? 'selected' : '' }}>Services transverses</option>
                            <option value="Incubation" {{ $demande->pole == 'Incubation' ? 'selected' : '' }}>Incubation</option>
                            <option value="Valorisation" {{ $demande->pole == 'Valorisation' ? 'selected' : '' }}>Valorisation</option>
                        </select>
                        @error('pole')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Date de début</span>
                        <input type="date" name="date_de_debut" id="date_de_debut" required value="{{ $demande->date_de_debut }}" />
                        @error('date_de_debut')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Date de fin</span>
                        <input type="date" name="date_de_fin" id="date_de_fin" required value="{{ $demande->date_de_fin }}" />
                        @error('date_de_fin')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">CV</span>
                        <input type="file" name="cv" id="cv" />
                        <a href="{{ asset($demande->cv) }}" {{-- download --}}></a>
                        @error('cv')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Lettre de motivation</span>
                        <input type="file" name="lettre_de_motivation" id="lettre_de_motivation" />
                        <a href="{{ asset($demande->lettre_de_motivation) }}" ></a>
                        @error('lettre_de_motivation')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="input-box">
                        <span class="details">Attestation assurance</span>
                        <input type="file" name="attestation_assurance" id="attestation_assurance" />
                        <a href="{{ asset($demande->attestation_assurance) }}" ></a>
                        @error('attestation_assurance')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div> --}}
                    {{-- <div class="input-box" style="grid-column: span 2">
                        <span class="details">Objectif de stage</span>
                        <textarea style="height: 130px" name="objectif_de_stage" id="objectif_de_stage">{{ $demande->objectif_de_stage }}</textarea>
                        @error('objectif_de_stage')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div> --}}
                </div>
                <div class="button">
                    <input type="submit" value="Éditer" />
                </div>
            </form>
        </div>
    </div>
</body>

</html>
