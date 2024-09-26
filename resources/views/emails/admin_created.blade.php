<!-- resources/views/emails/encadrant_created.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de compte Admin</title>
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap");

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }

        .container {
            max-width: 700px;
            width: 100%;
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
        }

        .container .title {
            font-size: 25px;
            font-weight: 500;
            position: relative;
        }

        .container .title::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            height: 3px;
            width: 30px;
            border-radius: 5px;
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
        }

        .image-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .image-container img {
            max-width: 85%;
            height: auto;
            border-radius: 10px;
            padding-right: 20%;
        }

        .thank-you-details {
            /* text-align: center; */
            align-items: center;
            justify-content: center;
        }

        .home-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .home-link a {
            text-decoration: none;
            color: #0066cc;
            font-size: 16px;
            font-weight: 500;
        }

        .home-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="image-container">
            <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO">
        </div>
        <div class="thank-you-details">
            <p>M/Mme {{ $admin->prenom }} {{ $admin->nom }},</p>
            <p>Votre compte admin a été créé avec succès.</p>
            <p>Vous pouvez vous connecter en utilisant les identifiants suivants :</p>
            <p><strong>Email :</strong> {{ $admin->email }}</p>
            <p><strong>Mot de passe :</strong> admin@cim</p>
            <p>Note : veuillez changer votre mot de passe après votre première connexion</p>
            <p><a href="{{ url('/login') }}"
                    style="display: inline-block; padding: 10px 20px; color: #fff; background-color: #007bff; text-decoration: none; border-radius: 5px;">Se
                    connecter</a></p>
            <p>Merci de nous rejoindre !</p>
        </div>
    </div>
</body>

</html>
