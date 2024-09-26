<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Stage Approuvée</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 600px;
            width: 100%;
        }

        .header {
            text-align: center;
        }

        .header img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin-bottom: 10px;
            font-size: 24px;
            color: #333;
        }

        .content {
            line-height: 1.6;
        }

        .content p {
            margin-bottom: 20px;
        }

        .button {
            display: block;
            width: 100%;
            text-align: center;
            margin: 20px 0;
        }

        .button a {
            background-color: #71b7e6;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .button a:hover {
            background-color: #9b59b6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO">
            <h1>Demande de Stage Approuvée</h1>
        </div>
        <div class="content">
            <p>M/Mme {{ $demande->stagiaire->nom }} {{ $demande->stagiaire->prenom }},</p>
            <p>Nous avons le plaisir de vous informer que votre demande de stage intitulée <strong>{{ $demande->type_de_stage }}</strong> a été approuvée.</p>
            <p>Vous pouvez accéder à votre profil en utilisant le lien ci-dessous :</p>
            <div class="button">
                <a href="{{ url('/login') }}">Se Connecter</a>
            </div>
            <p>Merci de votre engagement et à bientôt!</p>
        </div>
    </div>
</body>
</html>
