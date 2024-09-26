<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Demande postulé</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
<body>
    <div id="welcome-page" class="form-body">
        <div class="container">
            <div class="title">{{ __('Merci') }}</div>
            <div class="content">
                <div class="image-container">
                    <img src="{{ asset('assets/images/logos/cim-uca.jpg') }}" alt="CIM LOGO" />
                </div>
                <div class="thank-you-details">
                    <p>{{ __('Merci pour votre demande de stage.') }}</p>
                    <p>{{ __('Votre demande est en cours de révision.') }}</p>
                    <p>{{ __('Nous vous contacterons bientôt.') }}</p>
                </div>
            </div>
            <div class="home-link">
                <a href="{{ route('demande-de-stage.edit', auth()->id()) }}">{{ __('Modifiez votre demande?') }}</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-link">{{ __('Logout') }}</a>
            </div>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    <script>
        window.onload = function() {
            // Check if navigation type is 'back_forward' (back or forward button press)
            if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
                // Trigger logout by submitting the logout form
                document.getElementById('logout-form').submit();
            }
        };
    </script>
    <script src="{{ asset('/assets/js/scripts.js') }}"></script>
</body>
</html>
