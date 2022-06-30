@extends('template.dashboard')
@section('title', 'Top Up')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Top Up History</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table table-striped">
        <thead class="font-bold">
          <tr>
            <td>#</td>
            <td>Amount</td>
            <td>Method</td>
            <td>Payment Code</td>
            <td>User</td>
            <td>Status</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($deposits as $dep)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ Helper::toRupiah($dep->amount) }}</td>
              <td>{{ $dep->method->label }}</td>
              <td>{{ $dep->payment_code }}</td>
              <td>{{ $dep->user->name }}</td>
              <td>
                @if ($dep->status->id === 1)
                  <span class="text-amber-500 text-sm font-bold uppercase">{{ $dep->status->label }}</span>
                @elseif ($dep->status->id === 2)
                  <span class="text-green-500 text-sm font-bold uppercase">{{ $dep->status->label }}</span>
                @elseif ($dep->status->id === 3)
                  <span class="text-red-500 text-sm font-bold uppercase">{{ $dep->status->label }}</span>
                @endif
              </td>
            </tr>
          @endforeach
          @if ($deposits->total() == 0)
            <tr>
              <td colspan="8" class="text-center text-sm text-secondary uppercase">No Top Up Data Yet</td>
            </tr>
          @endif
          <caption>
            <span class="text-sm text-gray-400">Showing <strong>{{ $deposits->firstItem() ?: 0 }}</strong> - <strong>{{ $deposits->lastItem() ?: 0 }}</strong> from total <strong>{{ $deposits->total() }}</strong></span>
          </caption>
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-between justify-end">
      <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#topup-modal"><i class="mdi mdi-wallet-plus mr-1"></i> Request Top Up</button>
      <div class="flex flex-row">@include('component.paginator', ['data' => $deposits])</div>
    </div>
  </div>
  <div id="topup-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <form method="POST" action="{{ url('/topup') }}" class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Request Top Up</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-blue-50">
          <div class="form-group mb-3">
            <label for="method" class="text-gray-600 mb-1">Payment Method</label>
            <select id="method" name="method" class="form-select" required>
              <option disabled selected>-- SELECT PAYMENT METHOD --</option>
              @foreach ($methods as $method)
                <option value="{{ $method->id }}">{{ $method->label }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="amount" class="text-gray-600 mb-1">Top Up Amount</label>
            <div class="input-group">
              <span class="input-group-text">Rp </span>
              <input type="number" name="amount" class="form-control" value="0" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-sm btn-success"><i class="mdi mdi-wallet-plus mr-1"></i> Make Request</button>
        </div>
      </form>
    </div>
  </div>
@endsection