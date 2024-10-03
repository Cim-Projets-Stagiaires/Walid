<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attestation de Stage</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/attestation-style.css') }}">   
</head>
<body>
    <div class="container">
        <header>
            <img src="{{ public_path('assets/images/logos/cim-uca.png') }}" class="logo" alt="cim-logo">
            <h1>ATTESTATION DE STAGE</h1>
            @if ($stagiaire->demande->pole == 'Services transverses')
                <p class="reference">{{ $year }}/ATS/ST/{{ $code }}</p>
            @elseif($stagiaire->demande->pole == 'Valorisation')
                <p class="reference">{{ $year }}/ATS/Val/{{ $code }}</p>
            @elseif($stagiaire->demande->pole == 'Incubation')
                <p class="reference">{{ $year }}/ATS/Inc/{{ $code }}</p>
            @endif
        </header>
        <section class="content">
            <p>
                Je soussigné M. <strong>BELKHAYAT Driss</strong>, Directeur de la Cité de l’Innovation Marrakech,
                atteste que M. <strong>{{ $stagiaire->nom }} {{ $stagiaire->prenom }}</strong> portant la carte
                d’identité nationale N°<strong>XX</strong> étudiant
                à
                <strong>{{ $stagiaire->demande->etablissement }}</strong> a effectué un stage dans notre établissement
                au Pôle <strong>{{ $stagiaire->demande->pole }}</strong> du
                <strong>{{ $stagiaire->demande->date_de_debut }}</strong> au
                <strong>{{ $stagiaire->demande->date_de_fin }}</strong>.
            </p>
            <p>
                Cette attestation est délivrée à l’intéressé(e) pour servir et valoir ce que de droit.
            </p>
            <p class="footer">
                Fait à Marrakech le <strong>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</strong>
            </p>
            <p class="signature">
                <strong>Driss BELKHAYAT</strong><br>
                Directeur de la Cité de l’Innovation Marrakech
            </p>
        </section>
        <footer>
            <p>Royaume du Maroc<br>Université Cadi Ayyad – Marrakech<br>Cité de l‘innovation de Marrakech</p>
            <p>
                Avenue Abdelkrim Khattabi B.P. 511 Marrakech Maroc - Tel.: 05.24.35.12.50<br>
                Email: cite_innovation_marrakech@uca.ac.ma
            </p>
        </footer>
    </div>
</body>
</html>
