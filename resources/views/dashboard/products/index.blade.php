@extends('template.dashboard')
@section('title', 'Produk')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Produk</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table table-striped">
        <thead class="font-bold">
          <tr>
            <td>#</td>
            <td>Nama Produk</td>
            <td>Tgl Mulai</td>
            <td>Tgl Selesai</td>
            <td>Terkumpul</td>
            <td>Target</td>
            <td>Status</td>
            <td>Aksi</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($projects as $product)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $product->title }}</td>
              <td>{{ date('d/m/Y', strtotime($product->offer_start_date)) }}</td>
              <td>{{ date('d/m/Y', strtotime($product->offer_end_date)) }}</td>
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
          <caption>
            <span class="text-sm text-gray-400">Menampilkan <strong>{{ $projects->firstItem() }}</strong> - <strong>{{ $projects->firstItem() }}</strong> dari total <strong>{{ $projects->total() }}</strong></span>
          </caption>
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-between">
      <a href="{{ url('/products/add') }}" class="btn btn-sm btn-success"><i class="mdi mdi-plus-circle mr-1"></i> Produk Baru</a>
      <div class="flex flex-row">@include('component.paginator', ['data' => $projects])</div>
    </div>
  </div>
@endsection