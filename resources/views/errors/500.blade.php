
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Hbanking - Page 500</title>
    <link rel="stylesheet" href="/assets/css/main/app.css" />
    <link rel="stylesheet" href="/assets/css/pages/error.css" />
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
    <div id="error">
      <div class="error-page container">
        <div class="col-md-8 col-12 offset-md-2">
          <div class="text-center">
            <img
              class="img-error"
              src="/assets/images/samples/error-500.svg"
              alt="Not Found"
            />
            <h1 class="error-title"> Erreur Systeme</h1>
            <p class="fs-5 text-gray-600">
              Le site web est actuellement indisponible. Essayez à nouveau plus tard ou contactez le développeur.
            </p>
            <a href="{{ route('dashboard') }}" class="btn btn-lg btn-outline-primary mt-3"
              >Allez au tableau de bord</a
            >
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
