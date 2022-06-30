@extends('template.dashboard')
@section('title', 'Investor')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Investor</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table table-striped">
        <thead class="font-bold">
          <tr>
            <td>#</td>
            <td>Investor Name</td>
            <td>Investor Phone</td>
            <td>Investor Mail</td>
            <td>Total Invest</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($investors as $inv)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $inv->user->name }}</td>
              <td>{{ $inv->user->phone }}</td>
              <td>{{ $inv->user->email }}</td>
              <td>{{ Helper::toRupiah($inv->total) }}</td>
              <td>
                <a href="{{ url('investors/'.$inv->user->id) }}" class="text-sm text-white bg-blue-600 no-underline hover:bg-blue-700 rounded py-1 px-3 w-full"><i class="mdi mdi-magnify-plus-outline mr-1"></i>Detail</button>
              </td>
            </tr>
          @endforeach
          @if ($investors->total() == 0)
            <tr>
              <td colspan="8" class="text-center text-sm text-secondary uppercase">No Investor Yet</td>
            </tr>
          @endif
          <caption>
            <span class="text-sm text-gray-400">Showing <strong>{{ $investors->firstItem() ?: 0 }}</strong> - <strong>{{ $investors->lastItem() ?: 0 }}</strong> from total <strong>{{ $investors->total() }}</strong></span>
          </caption>
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-end">
      <div class="flex flex-row">@include('component.paginator', ['data' => $investors])</div>
    </div>
  </div>
@endsection