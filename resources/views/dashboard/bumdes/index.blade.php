@extends('template.dashboard')
@section('title', 'BUMDes')
@section('content')
<div class="flex flex-col p-4">
  <div class="flex flex-row justify-between items-center mb-3">
    <span class="text-xl text-blue-600 font-bold uppercase">BUMDes</span>
    <form action="{{ request()->url() }}" method="GET">
      <div class="form-group">
        <div class="input-group">
          <i class="input-group-text mdi mdi-magnify"></i>
          <input type="text" id="search" name="q" placeholder="Search for BUMDes.." class="form-control form-control-sm" value="{{ request()->input('q') }}">
        </div>
      </div>
    </form>
  </div>
  @include('component.alert')
  <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
    <table class="table table-striped">
      <thead class="font-bold">
        <tr>
          <td>#</td>
          <td>BUMDes Name</td>
          <td>Balance</td>
          <td>State</td>
          <td>City</td>
          <td>Phone Number</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($bumdes as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ Helper::toRupiah($item->balance) }}</td>
            <td>{{ $item->district->city->province->name }}</td>
            <td>{{ $item->district->city->name }}</td>
            <td>{{ $item->phone }}</td>
            <td>
              <a href="{{ url('bumdes/'.$item->id) }}" class="text-sm text-white bg-blue-600 no-underline hover:bg-blue-700 rounded py-1 px-3 w-full"><i class="mdi mdi-magnify-plus-outline mr-1"></i>Detail</button>
            </td>
          </tr>
        @endforeach
        @if ($bumdes->total() == 0)
        <tr>
          <td colspan="8" class="text-center text-sm text-secondary uppercase">No BUMDes Yet</td>
        </tr>
        @endif
        <caption>
          <span class="text-sm text-gray-400">Showing <strong>{{ $bumdes->firstItem() ?: 0 }}</strong> - <strong>{{ $bumdes->lastItem() ?: 0 }}</strong> from total <strong>{{ $bumdes->total() }}</strong></span>
        </caption>
      </tbody>
    </table>
  </div>
  <div class="flex flex-row justify-between">
    <a href="{{ url('/bumdes/add') }}" class="btn btn-sm btn-success"><i class="mdi mdi-plus-circle mr-1"></i> Add New BUMDes</a>
    <div class="flex flex-row">@include('component.paginator', ['data' => $bumdes])</div>
  </div>
</div>
@endsection