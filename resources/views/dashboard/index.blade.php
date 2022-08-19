@extends('template.dashboard')
@section('title', 'Dashboard')
@section('content')
  @if (auth()->user()->role_id === 1)
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Dashboard</span>
    <div class="flex flex-row w-full gap-x-4 mb-3">
      <div class="flex flex-col w-1/4 gap-y-4 bg-white rounded shadow p-3">
        <span class="text-4xl font-bold text-blue-600 text-right">{{ Helper::formatNumber($bumdes_count) }}</span>
        <span class="text-xs text-gray-600 uppercase">Total BUMDes</span>
      </div>
      <div class="flex flex-col w-1/4 gap-y-4 bg-white rounded shadow p-3">
        <span class="text-4xl font-bold text-green-600 text-right">{{ Helper::formatNumber($project_count) }}</span>
        <span class="text-xs text-gray-600 uppercase">Total Project</span>
      </div>
      <div class="flex flex-col w-1/4 gap-y-4 bg-white rounded shadow p-3">
        <span class="text-4xl font-bold text-purple-600 text-right">{{ Helper::formatNumber($investor_count) }}</span>
        <span class="text-xs text-gray-600 uppercase">Total Investor</span>
      </div>
      <div class="flex flex-col w-1/4 gap-y-4 bg-white rounded shadow p-3">
        <span class="text-4xl font-bold text-pink-600 text-right">{{ Helper::formatNumber($invest_count) }}</span>
        <span class="text-xs text-gray-600 uppercase">Total Investment</span>
      </div>
    </div>
    <div class="flex flex-col w-full bg-white rounded shadow p-3 mb-3">
      <span class="text-sm font-bold text-blue-400 mb-3">BUMDes</span>
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
          @if (count($bumdes) == 0)
          <tr>
            <td colspan="8" class="text-center text-sm text-secondary uppercase">No BUMDes Yet</td>
          </tr>
          @endif
        </tbody>
      </table>
      <div class="flex flex-row justify-end">
        <a href="{{ url('/bumdes') }}" class="btn btn-sm btn-outline-primary">Show More <i class="mdi mdi-chevron-double-right"></i></a>
      </div>
    </div>
    <div class="flex flex-col w-full bg-white rounded shadow p-3 mb-3">
      <span class="text-sm font-bold text-blue-400 uppercase mb-3">Users</span>
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
          @if (count($users) == 0)
          <tr>
            <td colspan="8" class="text-center text-sm text-secondary uppercase">No Users Yet</td>
          </tr>
          @endif
        </tbody>
      </table>
      <div class="flex flex-row justify-end">
        <a href="{{ url('/bumdes') }}" class="btn btn-sm btn-outline-primary">Show More <i class="mdi mdi-chevron-double-right"></i></a>
      </div>
    </div>
    <div class="flex flex-col w-full bg-white rounded shadow p-3 mb-3">
      <span class="text-sm font-bold text-blue-400 uppercase mb-3">Administrator</span>
      <table class="table table-striped mb-3">
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
          @if (count($admins) == 0)
          <tr>
            <td colspan="8" class="text-center text-sm text-secondary uppercase">No Admin Yet</td>
          </tr>
          @endif
        </tbody>
      </table>
      <div class="flex flex-row justify-end">
        <a href="{{ url('/admin') }}" class="btn btn-sm btn-outline-primary">Show More <i class="mdi mdi-chevron-double-right"></i></a>
      </div>
    </div>
  </div>
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