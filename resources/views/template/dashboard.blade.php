@php
  $menus = [];

  if (auth()->user()->role_id === 1) {
    $menus = [
      [
        'title' => 'Dashboard',
        'icon' => 'view-dashboard',
        'url' => 'dashboard'
      ],
      [
        'title' => 'BUMDes',
        'icon' => 'office-building',
        'url' => 'bumdes'
      ],
      [
        'title' => 'Administrators',
        'icon' => 'account-group',
        'url' => 'admin'
      ],
      [
        'title' => 'Users',
        'icon' => 'account-group',
        'url' => 'user'
      ],
      [
        'title' => 'Logout',
        'icon' => 'exit-to-app',
        'url' => 'logout',
      ],
    ];
  } else {
    $menus = [
      [
        'title' => 'Dashboard',
        'icon' => 'view-dashboard',
        'url' => 'dashboard',
      ],
      [
        'title' => 'Product',
        'icon' => 'basket',
        'url' => 'products',
      ],
      [
        'title' => 'Investment',
        'icon' => 'chart-bar',
        'url' => 'investments',
      ],
      [
        'title' => 'Investor',
        'icon' => 'account-group',
        'url' => 'investors',
      ],
      [
        'title' => 'Monthly Reports',
        'icon' => 'chart-areaspline',
        'url' => 'reports',
      ],
      [
        'title' => 'Profile',
        'icon' => 'account-circle',
        'url' => 'profile',
      ],
      [
        'title' => 'Logout',
        'icon' => 'exit-to-app',
        'url' => 'logout',
      ],
    ];
  }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title') - BUMDest</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <script src="{{ asset('js/app.js') }}"></script>
</head>
<body class="flex flex-row w-screen h-screen overflow-hidden">
  <nav class="flex flex-col items-center w-96 h-screen overflow-auto bg-white drop-shadow-lg">
    <div class="flex flex-col items-center w-full p-3 mb-2">
      <span class="text-2xl font-bold text-blue-600 uppercase">Bumdest</span>
      <span class="text-sm text-gray-500">{{ auth()->user()->bumdes_id == null ? auth()->user()->name : auth()->user()->bumdes->name }}</span>
    </div>
    @if (auth()->user()->role_id === 2)
    <div class="flex flex-row justify-between items-center bg-blue-600 text-white w-full px-3 py-2 mb-3">
      <div class="flex flex-col">
        <span class="text-xs uppercase">Balance</span>
        <span class="text-lg font-bold">{{ Helper::toRupiah(auth()->user()->bumdes->balance) }}</span>
      </div>
      <div class="flex flex-row gap-x-2">
        <a href="{{ url('/topup') }}" title="TopUp Balance" class="bg-sky-400 hover:bg-sky-500 text-white rounded px-2 py-1"><i class="mdi mdi-wallet-plus"></i></a>
        <a href="{{ url('/withdraw') }}" title="Withdraw Balance" class="bg-sky-400 hover:bg-sky-500 text-white rounded px-2 py-1"><i class="mdi mdi-bank-check"></i></a>
      </div>
    </div>
    @endif
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
      document.querySelector('span#current-date').innerText = moment().locale('en').format('dddd, MMMM Do yyyy');
    });
  </script>
</body>
</html>