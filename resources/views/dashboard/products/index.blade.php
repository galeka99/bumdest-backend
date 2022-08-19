@extends('template.dashboard')
@section('title', 'Produk')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Product</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table table-striped">
        <thead class="font-bold">
          <tr>
            <td>#</td>
            <td>Product Name</td>
            <td>Start Date</td>
            <td>End Date</td>
            <td>Collected</td>
            <td>Target</td>
            <td>Status</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $product->title }}</td>
              <td>{{ date('m/d/Y', strtotime($product->offer_start_date)) }}</td>
              <td>{{ date('m/d/Y', strtotime($product->offer_end_date)) }}</td>
              <td>{{ Helper::toRupiah($product->current_invest) }}</td>
              <td>{{ Helper::toRupiah($product->invest_target) }}</td>
              <td>
                @if ($product->status->id === 1)
                  <span class="text-blue-500 text-sm font-bold uppercase">{{ $product->status->label }}</span>
                @elseif ($product->status->id === 2)
                  <span class="text-green-500 text-sm font-bold uppercase">{{ $product->status->label }}</span>
                @elseif ($product->status->id === 3)
                  <span class="text-red-500 text-sm font-bold uppercase">{{ $product->status->label }}</span>
                @elseif ($product->status->id === 4)
                  <span class="text-yellow-500 text-sm font-bold uppercase">{{ $product->status->label }}</span>
                @endif
              </td>
              <td><a href="{{ url('products/'.$product->id) }}" class="text-sm text-white bg-blue-500 no-underline hover:bg-blue-600 rounded py-1 px-3"><i class="mdi mdi-magnify-plus-outline"></i> Detail</a></td>
            </tr>
          @endforeach
          @if ($projects->total() == 0)
            <tr>
              <td colspan="8" class="text-center text-sm text-secondary uppercase">No Products Yet</td>
            </tr>
          @endif
          <caption>
            <span class="text-sm text-gray-400">Showing <strong>{{ $projects->firstItem() ?: 0 }}</strong> - <strong>{{ $projects->lastItem() ?: 0 }}</strong> from total <strong>{{ $projects->total() }}</strong></span>
          </caption>
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-between">
      <a href="{{ url('/products/add') }}" class="btn btn-sm btn-success"><i class="mdi mdi-plus-circle mr-1"></i> Add New Product</a>
      <div class="flex flex-row">@include('component.paginator', ['data' => $projects])</div>
    </div>
  </div>
@endsection