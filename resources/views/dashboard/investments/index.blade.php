@extends('template.dashboard')
@section('title', 'Investment')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Investment</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table table-striped">
        <thead class="font-bold">
          <tr>
            <td>#</td>
            <td>Product Name</td>
            <td>Investor Name</td>
            <td>Investor Phone</td>
            <td>Investor Mail</td>
            <td>Amount</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($investments as $inv)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $inv->project->title }}</td>
              <td>{{ $inv->user->name }}</td>
              <td>{{ $inv->user->phone }}</td>
              <td>{{ $inv->user->email }}</td>
              <td>{{ Helper::toRupiah($inv->amount) }}</td>
              <td>
                @if ($inv->status->id === 1)
                  <span class="text-blue-500 text-sm font-bold uppercase">{{ $inv->status->label }}</span>
                @elseif ($inv->status->id === 2)
                  <span class="text-green-500 text-sm font-bold uppercase">{{ $inv->status->label }}</span>
                @elseif ($inv->status->id === 3)
                  <span class="text-red-500 text-sm font-bold uppercase">{{ $inv->status->label }}</span>
                @elseif ($inv->status->id === 4)
                  <span class="text-purple-500 text-sm font-bold uppercase">{{ $inv->status->label }}</span>
                @elseif ($inv->status->id === 5)
                  <span class="text-gray-600 text-sm font-bold uppercase">{{ $inv->status->label }}</span>
                @endif
              </td>
              @if ($inv->status->id === 1)
                <td class="grid grid-cols-2 gap-2">
                  <form action="{{ url('investments/'.$inv->id.'/accept') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-white bg-green-600 no-underline hover:bg-green-700 rounded py-1 px-3 w-full"><i class="mdi mdi-check-bold mr-1"></i>Accept</button>
                  </form>
                  <form action="{{ url('investments/'.$inv->id.'/reject') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-white bg-red-600 no-underline hover:bg-red-700 rounded py-1 px-3 w-full"><i class="mdi mdi-close-thick mr-1"></i>Reject</button>
                  </form>
                </td>
              @else
                <td></td>
              @endif
            </tr>
          @endforeach
          @if ($investments->total() == 0)
            <tr>
              <td colspan="8" class="text-center text-sm text-secondary uppercase">No Investment Yet</td>
            </tr>
          @endif
          <caption>
            <span class="text-sm text-gray-400">Showing <strong>{{ $investments->firstItem() ?: 0 }}</strong> - <strong>{{ $investments->lastItem() ?: 0 }}</strong> from total <strong>{{ $investments->total() }}</strong></span>
          </caption>
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-end">
      <div class="flex flex-row">@include('component.paginator', ['data' => $investments])</div>
    </div>
  </div>
@endsection