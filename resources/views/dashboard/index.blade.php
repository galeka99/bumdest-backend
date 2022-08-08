@extends('template.dashboard')
@section('title', 'Dashboard')
@section('content')
  @if (auth()->user()->role_id === 1)
  <div class="flex flex-col p-4"></div>
  @elseif (auth()->user()->role_id === 2)
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Dashboard</span>
    <div class="flex flex-row w-full gap-x-4">
      <div class="flex flex-col w-1/4 gap-y-4">
        <div class="flex flex-row bg-white rounded-lg shadow p-3 gap-x-3">
          <div class="flex flex-col w-3/5">
            <span class="text-sm text-gray-500 font-medium uppercase">Collected</span>
            <span class="text-2xl text-green-500 font-bold">{{ Helper::formatNumber($current_invest) }}</span>
            <span class="text-sm text-gray-500 font-medium uppercase">From Total</span>
            <span class="text-2xl text-blue-500 font-bold">{{ Helper::formatNumber($invest_target) }}</span>
          </div>
          <div class="flex flex-col justify-center items-center w-2/5">
            <img src="{{ asset('images/chart.svg') }}" alt="chart" class="text-blue-600">
          </div>
        </div>
        <div class="flex flex-row items-center bg-white rounded-lg shadow p-3 gap-x-3">
          <span class="text-8xl text-blue-600 font-bold">{{ $total_product }}</span>
          <div class="flex flex-col">
            <span class="text-xl text-gray-600 mb-1">Product</span>
            <span class="text-justify text-sm text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
          </div>
        </div>
        <div class="flex flex-row items-center bg-white rounded-lg shadow p-3 gap-x-3">
          <span class="text-8xl text-blue-600 font-bold">{{ $total_investor }}</span>
          <div class="flex flex-col">
            <span class="text-xl text-gray-600 mb-1">Investor</span>
            <span class="text-justify text-sm text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-3/4 gap-y-4">
        <div class="flex flex-col bg-white rounded-lg shadow p-3">
          <span class="text-lg text-blue-600 font-bold uppercase mb-3">Current Running Product</span>
          <table class="table table-striped mb-3">
            <thead class="table-info">
              <tr>
                <td>#</td>
                <td>Product Name</td>
                <td>Offer End Date</td>
                <td>Collected</td>
                <td>Target</td>
              </tr>
            </thead>
            @foreach ($products as $product)
            <tbody>
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ date('m/d/Y', strtotime($product->offer_end_date)) }}</td>
                <td>{{ Helper::toRupiah($product->current_invest) }}</td>
                <td>{{ Helper::toRupiah($product->invest_target) }}</td>
              </tr>
            </tbody>
            @endforeach
          </table>
          <a href="{{ url('/products') }}" class="btn btn-sm btn-outline-primary px-4 self-end">More Products</a>
        </div>
        <div class="flex flex-col bg-white rounded-lg shadow p-3">
          <span class="text-lg text-blue-600 font-bold uppercase mb-3">Newest Investment</span>
          <table class="table table-striped mb-3">
            <thead class="table-info">
              <tr>
                <td>#</td>
                <td>Investor Name</td>
                <td>Product Name</td>
                <td>Date</td>
                <td>Amount</td>
              </tr>
            </thead>
            @foreach ($investments as $investment)
            <tbody>
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $investment->user->name }}</td>
                <td>{{ $investment->project->title }}</td>
                <td>{{ date('m/d/Y H:i:s', strtotime($investment->created_at)) }}</td>
                <td>{{ Helper::toRupiah($investment->amount) }}</td>
              </tr>
            </tbody>
            @endforeach
          </table>
          <a href="{{ url('/investments') }}" class="btn btn-sm btn-outline-primary px-4 self-end">More Investments</a>
        </div>
        <div class="flex flex-row bg-white rounded-lg shadow gap-x-3 p-3">
          <div class="flex flex-col justify-between flex-grow-1">
            <div class="flex flex-col uppercase mb-3">
              <span class="text-lg text-blue-600 font-semibold">Do you wan't to push your BUMDes to a higher level?</span>
              <span class="text-gray-600 text-xs">Make sure people give their 5 stars to your BUMDes</span>
            </div>
            <div class="flex flex-col">
              <div class="input-group mb-2">
                <i class="input-group-text mdi mdi-link"></i>
                <input type="url" id="review_link" name="review_link" class="form-control form-control-sm" value="{{ url('/review/'.auth()->user()->bumdes->code) }}" readonly>
              </div>
              <div class="flex flex-row gap-x-2">
                <button id="copy_review_link" class="btn btn-sm btn-outline-primary">Copy Link</button>
                <a href="{{ url('/download/qr-review') }}" target="_blank" class="btn btn-sm btn-outline-success" download="bumdest-review-qr.svg">Download QR</a>
              </div>
            </div>
          </div>
          <div class="flex flex-col">
            <div>{{ QrCode::size(150)->generate(url('/review/'.auth()->user()->bumdes->code)) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.querySelector('button#copy_review_link').addEventListener('click', async e => {
      const url = "{{ url('/review/'.auth()->user()->bumdes->code) }}";
      await navigator.clipboard.writeText(url);
      Swal.fire({
        icon: 'success',
        text: 'Review link copied to clipboard',
        showConfirmButton: false,
        timer: 1500,
      });
    });
  </script>
  @endif
@endsection