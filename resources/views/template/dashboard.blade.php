@php
  $menus = [
    [
      'title' => 'Halaman Utama',
      'icon' => 'view-dashboard',
      'url' => 'dashboard',
    ],
    [
      'title' => 'Produk',
      'icon' => 'basket',
      'url' => 'products',
    ],
    [
      'title' => 'Investor',
      'icon' => 'account-group',
      'url' => 'investors',
    ],
    [
      'title' => 'Profil',
      'icon' => 'account-circle',
      'url' => 'profile',
    ],
    [
      'title' => 'Keluar',
      'icon' => 'exit-to-app',
      'url' => 'logout',
    ],
  ];
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') - Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="flex flex-row w-screen h-screen overflow-hidden">
  <nav class="flex flex-col items-center w-96 h-screen overflow-auto bg-white drop-shadow-lg">
    <div class="flex flex-col w-full p-3 mb-2">
      <span class="text-2xl font-bold text-blue-600 uppercase">Bumdest</span>
      <span class="text-sm text-gray-500">{{ auth()->user()->bumdes_id == null ? auth()->user()->name : auth()->user()->bumdes->name }}</span>
    </div>
    <div id="menus" class="flex flex-col w-full h-full px-3 gap-y-2">
      @foreach ($menus as $menu)
        <a href="{{ url($menu['url']) }}" class="w-full py-2 px-3 no-underline hover:text-white hover:bg-blue-600 rounded-lg @if(Str::startsWith(Request::path(), $menu['url'])) bg-blue-700 text-white @else text-blue-600 @endif">
          <i class="mdi mdi-{{ $menu['icon'] }} mr-3"></i>
          <span>{{ $menu['title'] }}</span>
        </a>
      @endforeach
    </div>
    <span id="current-date" class="text-sm text-gray-500 mb-3"></span>
  </nav>
  <main class="w-full overflow-x-hidden overflow-y-auto bg-blue-50">
    @yield('content')
  </main>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      document.querySelector('span#current-date').innerText = moment().locale('id').format('dddd, DD MMMM yyyy');
    });
  </script>
</body>
</html>