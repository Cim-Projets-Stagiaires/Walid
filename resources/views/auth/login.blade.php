<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="form-body">
        <div class="container">
            <div class="title">{{ __('Login') }}</div>
            <div class="content">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="image-container">
                        <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO" />
                    </div>
                    <div class="login-details">
                        <div class="input-box">
                            <span class="details">{{ __('Email') }}</span>
                            <input id="email" type="email"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required placeholder="Entrez votre email" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="input-box">
                            <span class="details">{{ __('Mot de passe') }}</span>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                placeholder="Entrez votre mot de passe" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if ($errors->has('error'))
                        <div class="alert alert-danger">
                            {{ $errors->first('error') }}
                        </div>
                    @endif
                    <div class="button">
                        <input type="submit" value="{{ __('Login') }}" />
                    </div>
                </form>
            </div>
            <div class="login-link">
                <span>{{ __('Vous êtes nouveau ?') }}
                    <a href="{{ route('register') }}">{{ __('Veuillez vous inscrire') }}</a>
                </span>
            </div>
        </div>
    </div>
    <script src="{{ asset('/assets/js/scripts.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
