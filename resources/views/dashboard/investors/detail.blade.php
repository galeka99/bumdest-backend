@extends('template.dashboard')
@section('title', 'Investor Detail')
@section('content')
<div class="flex flex-col p-4">
  <span class="text-xl text-blue-600 font-bold uppercase mb-3">Investor Detail</span>
  <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
    <div class="flex flex-row gap-x-3 mb-3">
      <table class="table table-striped table-hover table-borderless table-fixed text-start">
        <tr>
          <td class="w-2/6">Name</td>
          <td class="w-full font-bold">{{ $investor->name }}</td>
        </tr>
        <tr>
          <td class="w-2/6">Email</td>
          <td class="w-full font-bold">{{ $investor->email }}</td>
        </tr>
        <tr>
          <td class="w-2/6">Phone</td>
          <td class="w-full font-bold">{{ $investor->phone }}</td>
        </tr>
        <tr>
          <td class="w-2/6">Postal Code</td>
          <td class="w-full font-bold">{{ $investor->postal_code }}</td>
        </tr>
      </table>
      <table class="table table-striped table-hover table-borderless table-fixed text-start">
        <tr>
          <td class="w-2/6">State</td>
          <td class="w-full font-bold">{{ $investor->location['province_name'] }}</td>
        </tr>
        <tr>
          <td class="w-2/6">City</td>
          <td class="w-full font-bold">{{ $investor->location['city_name'] }}</td>
        </tr>
        <tr>
          <td class="w-2/6">District</td>
          <td class="w-full font-bold">{{ $investor->location['district_name'] }}</td>
        </tr>
        <tr>
          <td class="w-2/6">Address</td>
          <td class="w-full font-bold">{{ $investor->address }}</td>
        </tr>
      </table>
    </div>
    <table class="table table-fixed table-striped table-bordered table-hover text-center">
      <thead class="font-bold uppercase table-primary">
        <tr>
          <td class="w-1/12">#</td>
          <td class="w-7/12">Product Name</td>
          <td class="w-4/12">Invest Amount</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($investments as $inv)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $inv->project->title }}</td>
            <td>{{ Helper::toRupiah($inv->total) }}</td>
          </tr>
        @endforeach
        @if (count($investments) === 0)
          <tr>
            <td colspan="3" class="text-center text-sm text-secondary uppercase">This investor doesn't invested yet</td>
          </tr>
        @else
          <tr class="table-primary">
            @php
              $total_invest = array_reduce($investments->toArray(), function ($carry, $item) {
                $carry += $item['total'];
                return $carry;
              });
            @endphp
            <td colspan="2" class="text-end uppercase">Total</td>
            <td class="font-bold text-primary">{{ Helper::toRupiah($total_invest) }}</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
  <div class="flex flex-row justify-between">
    <a href="{{ url('investors') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-chevron-double-left mr-1"></i>Back</a>
  </div>
</div>
@endsection