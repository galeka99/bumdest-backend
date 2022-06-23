@extends('template.common')
@section('title', 'Masuk')
@section('content')
<div class="w-screen min-h-screen flex justify-center items-center bg-gray-800 p-3">
  <form method="POST" action="{{ url('/login') }}" class="flex flex-col w-full md:w-1/2 lg:w-1/3 xl:w-1/4 bg-white border border-gray-200 rounded-lg shadow-lg p-3">
    @csrf
    <span class="text-xl font-bold text-center text-blue-600">BUMDEST</span>
    <hr class="my-3">
    @include('component.alert')
    <div class="input-group mb-2">
      <span class="input-group-text mdi mdi-at"></span>
      <input type="text" class="form-control" name="email" placeholder="Alamat Email" required autofocus>
    </div>
    <div class="input-group mb-3">
      <span class="input-group-text mdi mdi-lock"></span>
      <input type="password" class="form-control" name="password" placeholder="Kata Sandi" required>
    </div>
    <button type="submit" class="btn btn-sm btn-primary">Masuk</button>
  </form>
</div>
@endsection