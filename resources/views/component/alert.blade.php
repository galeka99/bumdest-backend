@if (session('success'))
<div class="bg-green-200 border-2 border-green-600 text-green-800 rounded py-2 px-3 mb-3">{{ session('success') }}</div>
@endif
@if (session('error'))
<div class="bg-red-200 border-2 border-red-600 text-red-800 rounded py-2 px-3 mb-3">{{ session('error') }}</div>
@endif
@if ($errors->any())
@foreach ($errors->all() as $error)
    <div class="bg-red-200 border-2 border-red-600 text-red-800 rounded py-2 px-3 mb-2">{{ $error }}</div>
  @endforeach
@endif