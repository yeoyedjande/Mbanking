<!DOCTYPE html>
<html lang="fr">
  
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Authenticate - Hbanking</title>
    <link rel="stylesheet" href="/assets/css/main/app.css" />
    <link rel="stylesheet" href="/assets/css/main/app-dark.css" />
    <link rel="stylesheet" href="/assets/css/pages/auth.css" />
    <link
      rel="shortcut icon"
      href="/assets/images/logo/favicon.svg"
      type="image/x-icon"
    />
    <link
      rel="shortcut icon"
      href="/assets/images/logo/favicon.png"
      type="image/png"
    />
  </head>

  <body>
    <script src="/assets/js/initTheme.js"></script>
    <div id="auth">
      <div class="row h-100">
        <div class="col-lg-5 col-12">
          <div id="auth-left">
            <div class="auth-logo">
              <h4 href="#">
                <!--<img src="/assets/images/logo/logo.svg" alt="Logo"/>-->
                Hbanking
              </h4>
            </div>
            <h1 class="auth-title">Se connecter</h1>
            <p class="auth-subtitle mb-5">
              Ouvrez votre session en vous connectant
            </p>

            <form action="{{ route('client.login') }}" method="POST">

              @csrf
              <div class="form-group position-relative has-icon-left mb-4">
                <input type="text" class="form-control form-control-xl @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Nom d'utilisateur" required autocomplete="0" autofocus/>
                <div class="form-control-icon">
                  <i class="bi bi-person"></i>
                </div>
              </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

              <div class="form-group position-relative has-icon-left mb-4">
                <input type="password" name="password" class="form-control form-control-xl @error('password') is-invalid @enderror" placeholder="Mot de passe" required autocomplete="current-password"/>

                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

              <div class="form-check form-check-lg d-flex align-items-end">
                <input class="form-check-input me-2" name="remember" type="checkbox"value="" id="flexCheckDefault remember" {{ old('remember') ? 'checked' : '' }}/>
                <label class="form-check-label text-gray-600" for="flexCheckDefault">
                  Se souvenir
                </label>
              </div>

              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                Entrer
              </button>
            </form>

          </div>
        </div>
        <div class="col-lg-7 d-none d-lg-block">
          <div id="auth-right"></div>
        </div>
      </div>
    </div>
  </body>
</html>
