@extends('template.common')
@section('title', 'Masuk')
@section('content')
<div class="w-screen min-h-screen flex justify-center items-center bg-gray-800 p-3">
  <form method="POST" action="{{ url('/login') }}" class="flex flex-col w-full md:w-1/2 lg:w-1/3 xl:w-1/4 bg-white border border-gray-200 rounded-lg shadow-lg p-3">
    @csrf
    <label for="username" class="mb-1">Username</label>
    <input type="text" id="username" name="username" class="bg-blue-50 border border-blue-400 hover:border-blue-500 focus:bg-blue-100 rounded outline-none px-3 py-2 mb-3" required>
    <label for="password" class="mb-1">Kata Sandi</label>
    <input type="password" id="password" name="password" class="bg-blue-50 border border-blue-400 hover:border-blue-500 focus:bg-blue-100 rounded outline-none px-3 py-2 mb-6" required>
    <button type="submit" class="bg-green-600 hover:bg-green-700 border border-green-700 px-5 py-2 rounded-lg text-white uppercase font-bold">Masuk</button>
  </form>
</div>
@endsection