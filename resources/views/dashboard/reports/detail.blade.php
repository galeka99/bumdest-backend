@extends('template.dashboard')
@section('title', 'Monthly Report Detail')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Monthly Report Detail</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table-fixed text-center mb-3">
        <thead class="uppercase">
          <tr>
            <th>Product</th>
            <th>Periode</th>
            <th>Total Income</th>
          </tr>
        </thead>
        <tbody class="font-bold text-blue-600 text-2xl">
          <tr>
            <td>{{ $report->project->title }}</td>
            <td id="periode">{{ $report->year.$report->month }}</td>
            <td>{{ Helper::toRupiah($report->profit) }}</td>
          </tr>
        </tbody>
      </table>
      <table class="table table-sm table-bordered table-striped text-center">
        <thead class="bg-blue-600 text-white uppercase">
          <tr>
            <th>#</th>
            <th>Investor Name</th>
            <th>Percentage</th>
            <th>Income</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($report->details as $detail)
            <td>{{ $loop->iteration }}</td>
            <td>{{ $detail->user->name }}</td>
            <td>{{ $detail->percentage.'%' }}</td>
            <td>{{ Helper::toRupiah($detail->amount) }}</td>
          @endforeach
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-between">
      <a href="{{ url('reports') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-chevron-double-left mr-1"></i>Back</a>
    </div>
  </div>
  <script>
    window.addEventListener('DOMContentLoaded', () => {
      const periodeElement = document.querySelector('td#periode');
      periodeElement.innerHTML = moment(periodeElement.innerHTML, 'YYYYM').format('MMMM YYYY');
    });
  </script>
@endsection