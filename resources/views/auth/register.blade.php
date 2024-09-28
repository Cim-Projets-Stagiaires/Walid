<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon-cim.png') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body>
    <div class="container">
        <div class="image-container">
            <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO" />
        </div>
        <div class="title">{{ __('Register') }}</div>
        <div class="content">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="register-details">
                    <div class="input-box">
                        <span class="details">{{ __('Nom') }}</span>
                        <input id="nom" type="text" class="form-control @error('nom') is-invalid @enderror" name="nom" required placeholder="Entrez votre nom" />
                        @error('nom')
                            <span class="invalid-feedback" role="alert alert-danger">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">{{ __('Prenom') }}</span>
                        <input id="prenom" type="text" class="form-control @error('prenom') is-invalid @enderror" name="prenom"  required placeholder="Entrez votre prenom" />
                        @error('prenom')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">{{ __('Email') }}</span>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required placeholder="Entrez votre email" />
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">Numéro de téléphone</span>
                        <input
                          type="text"
                          class="form-control @error('phone') is-invalid @enderror" name="phone"
                          pattern="^0[67]\d{8}$"
                          title="Entrez un numéro de téléphone valide."
                          placeholder="Entrez votre numéro de téléphone"
                          required
                        />
                      </div>
                    <div class="input-box">
                        <span class="details">{{ __('Mot de passe') }}</span>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Entrez votre mot de passe" />
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-box">
                        <span class="details">{{ __('Confirmer Mot de passe') }}</span>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmez votre mot de passe" />
                    </div>
                </div>
                <div class="button">
                    <input type="submit" value="{{ __('Register') }}" />
                </div>
            </form>
            <div class="login-link">
                <span>{{ __('Vous êtes déjà inscrit ?') }}
                    <a href="{{ route('login') }}">{{ __('Veuillez vous connecter') }}</a>
                </span>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
