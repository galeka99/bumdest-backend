@extends('template.dashboard')
@section('title', 'Selamat Datang')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Halaman Utama</span>
    <div class="flex flex-row w-full gap-x-4">
      <div class="flex flex-col w-1/4 gap-y-4">
        <div class="flex flex-row bg-white rounded-lg shadow p-3 gap-x-3">
          <div class="flex flex-col w-3/5">
            <span class="text-sm text-gray-500 font-medium uppercase">Terkumpul</span>
            <span class="text-2xl text-green-500 font-bold">1.760.000</span>
            <span class="text-sm text-gray-500 font-medium uppercase">Dari</span>
            <span class="text-2xl text-blue-500 font-bold">3.350.000</span>
          </div>
          <div class="flex flex-col justify-center items-center w-2/5">
            <img src="{{ asset('images/chart.svg') }}" alt="chart" class="text-blue-600">
          </div>
        </div>
        <div class="flex flex-row items-center bg-white rounded-lg shadow p-3 gap-x-3">
          <span class="text-8xl text-blue-600 font-bold">6</span>
          <div class="flex flex-col">
            <span class="text-xl text-gray-600 mb-1">Produk</span>
            <span class="text-justify text-sm text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
          </div>
        </div>
        <div class="flex flex-row items-center bg-white rounded-lg shadow p-3 gap-x-3">
          <span class="text-8xl text-blue-600 font-bold">22</span>
          <div class="flex flex-col">
            <span class="text-xl text-gray-600 mb-1">Investor</span>
            <span class="text-justify text-sm text-gray-400">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</span>
          </div>
        </div>
      </div>
      <div class="flex flex-col w-3/4 gap-y-4">
        <div class="flex flex-col bg-white rounded-lg shadow p-3">
          <span class="text-lg text-blue-600 font-bold uppercase mb-3">Produk yang Sedang Berjalan</span>
          <table class="table table-striped mb-3">
            <thead class="table-info">
              <tr>
                <td>#</td>
                <td>Nama Produk</td>
                <td>Tgl Selesai</td>
                <td>Terkumpul</td>
                <td>Target</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Pasar Engrang</td>
                <td>21 Aug 2022</td>
                <td>Rp 875.000</td>
                <td>Rp 7.500.000</td>
              </tr>
            </tbody>
          </table>
          <a href="{{ url('/products') }}" class="btn btn-sm btn-primary px-4 self-end">Produk Lainnya</a>
        </div>
        <div class="flex flex-col bg-white rounded-lg shadow p-3">
          <span class="text-lg text-blue-600 font-bold uppercase mb-3">Investor Terbaru</span>
          <table class="table table-striped mb-3">
            <thead class="table-info">
              <tr>
                <td>#</td>
                <td>Nama Investor</td>
                <td>Produk</td>
                <td>Jumlah Investasi</td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>Barry Allen</td>
                <td>Pasar Engrang</td>
                <td>Rp 875.000</td>
              </tr>
            </tbody>
          </table>
          <a href="{{ url('/products') }}" class="btn btn-sm btn-primary px-4 self-end">Investor Lainnya</a>
        </div>
      </div>
    </div>
  </div>
@endsection