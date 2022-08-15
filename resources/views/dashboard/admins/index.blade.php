@extends('template.dashboard')
@section('title', 'Administrator')
@section('content')
<div class="flex flex-col p-4">
  <span class="text-xl text-blue-600 font-bold uppercase mb-3">Administrator</span>
  @include('component.alert')
  <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
    <table class="table table-striped">
      <thead class="font-bold">
        <tr>
          <td>#</td>
          <td>Name</td>
          <td>Email</td>
          <td>Phone</td>
          <td>City</td>
          <td>Province</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($admins as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->location['city_name'] }}</td>
            <td>{{ $item->location['province_name'] }}</td>
            <td>
              <a href="{{ url('admin/'.$item->id) }}" class="text-sm text-white bg-blue-600 no-underline hover:bg-blue-700 rounded py-1 px-3 w-full"><i class="mdi mdi-magnify-plus-outline mr-1"></i>Detail</button>
            </td>
          </tr>
        @endforeach
        @if ($admins->total() == 0)
        <tr>
          <td colspan="8" class="text-center text-sm text-secondary uppercase">No Admin Yet</td>
        </tr>
        @endif
        <caption>
          <span class="text-sm text-gray-400">Showing <strong>{{ $admins->firstItem() ?: 0 }}</strong> - <strong>{{ $admins->lastItem() ?: 0 }}</strong> from total <strong>{{ $admins->total() }}</strong></span>
        </caption>
      </tbody>
    </table>
  </div>
  <div class="flex flex-row justify-between">
    <a href="{{ url('/admin/add') }}" class="btn btn-sm btn-success"><i class="mdi mdi-plus-circle mr-1"></i> Add New Admin</a>
    <div class="flex flex-row">@include('component.paginator', ['data' => $admins])</div>
  </div>
</div>
@endsection