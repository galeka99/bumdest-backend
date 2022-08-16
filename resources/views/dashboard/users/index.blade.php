@extends('template.dashboard')
@section('title', 'Users')
@section('content')
<div class="flex flex-col p-4">
  <span class="text-xl text-blue-600 font-bold uppercase mb-3">Users</span>
  @include('component.alert')
  <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
    <table class="table table-striped">
      <thead class="font-bold">
        <tr>
          <td>#</td>
          <td>Name</td>
          <td>Email</td>
          <td>Phone</td>
          <td>Role</td>
          <td>Status</td>
          <td>Action</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($users as $item)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->name }}</td>
            <td>{{ $item->email }}</td>
            <td>{{ $item->phone }}</td>
            <td>{{ $item->role->label }}</td>
            <td>
              @if ($item->user_status->id === 1)
              <span class="text-xs bg-green-600 text-white uppercase rounded px-2 py-1">{{ $item->user_status->label }}</span>
              @elseif ($item->user_status->id === 2)
              <span class="text-xs bg-red-600 text-white uppercase rounded px-2 py-1">{{ $item->user_status->label }}</span>
              @endif
            </td>
            <td>
              <a href="{{ url('user/'.$item->id) }}" class="text-sm text-white bg-blue-600 no-underline hover:bg-blue-700 rounded py-1 px-3 w-full"><i class="mdi mdi-magnify-plus-outline mr-1"></i>Detail</button>
            </td>
          </tr>
        @endforeach
        @if ($users->total() == 0)
        <tr>
          <td colspan="8" class="text-center text-sm text-secondary uppercase">No Users Yet</td>
        </tr>
        @endif
        <caption>
          <span class="text-sm text-gray-400">Showing <strong>{{ $users->firstItem() ?: 0 }}</strong> - <strong>{{ $users->lastItem() ?: 0 }}</strong> from total <strong>{{ $users->total() }}</strong></span>
        </caption>
      </tbody>
    </table>
  </div>
  <div class="flex flex-row justify-between">
    <a href="{{ url('/user/add') }}" class="btn btn-sm btn-success"><i class="mdi mdi-plus-circle mr-1"></i> Add New User</a>
    <div class="flex flex-row">@include('component.paginator', ['data' => $users])</div>
  </div>
</div>
@endsection