<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entretien Refusé</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap');
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
        }
        h1 {
            color: #e74c3c;
        }
        .button a {
            background-color: #e74c3c;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .button a:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <p>Bonjour {{ $entretien->stagiaire->nom }} {{ $entretien->stagiaire->prenom }},</p>
        <p>Nous vous informons que votre entretien programmé le <strong>{{ $entretien->date }}</strong> a été refusé.</p>
        <p>Veuillez vous connecter pour plus d'informations.</p>
        <div class="button">
            <a href="{{ url('/login') }}">Se Connecter</a>
        </div>
    </div>
</body>
</html>
