<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') - Bumdest</title>
  <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('/css/bootstrap.css') }}">
  <script src="{{ asset('/js/app.js') }}"></script>
</head>
<body>
  @yield('content')
</body>
</html>