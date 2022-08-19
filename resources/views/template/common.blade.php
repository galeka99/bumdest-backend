<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="google-signin-client_id" content="741909550840-0bkcpsvsbkchu5lod068aqsjj8nkqtva.apps.googleusercontent.com">
  <title>@yield('title') - Bumdest</title>
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">
  <script src="{{ asset('/js/app.js') }}"></script>
</head>
<body class="overflow-x-hidden overflow-y-auto">
  @yield('content')
</body>
</html>