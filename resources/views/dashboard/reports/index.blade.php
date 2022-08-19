@extends('template.dashboard')
@section('title', 'Monthly Reports')
@section('content')
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Monthly Reports</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <table class="table table-striped">
        <thead class="font-bold">
          <tr>
            <td>#</td>
            <td>Year</td>
            <td>Month</td>
            <td>Total Profit</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          @foreach ($reports as $report)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $report->year }}</td>
              <td>{{ $report->month }}</td>
              <td>{{ Helper::toRupiah($report->profit) }}</td>
              <td>
                <a href="{{ url('reports/'.$report->id) }}" class="text-sm text-white bg-blue-600 no-underline hover:bg-blue-700 rounded py-1 px-3 w-full"><i class="mdi mdi-magnify-plus-outline mr-1"></i>Detail</button>
              </td>
            </tr>
          @endforeach
          @if ($reports->total() == 0)
            <tr>
              <td colspan="8" class="text-center text-sm text-secondary uppercase">No Reports Yet</td>
            </tr>
          @endif
          <caption>
            <span class="text-sm text-gray-400">Showing <strong>{{ $reports->firstItem() ?: 0 }}</strong> - <strong>{{ $reports->lastItem() ?: 0 }}</strong> from total <strong>{{ $reports->total() }}</strong></span>
          </caption>
        </tbody>
      </table>
    </div>
    <div class="flex flex-row justify-between">
      <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#insert-modal"><i class="mdi mdi-plus-circle mr-1"></i> Add New Report</button>
      <div class="flex flex-row">@include('component.paginator', ['data' => $reports])</div>
    </div>
  </div>
  <div id="insert-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
      <form id="report-form" method="POST" action="{{ url('/reports') }}" enctype="multipart/form-data" class="modal-content">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Add Monthly Report</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-blue-50">
          <div class="form-group mb-3">
            <label for="product" class="text-gray-600 mb-1">Product</label>
            <span class="text-red-600">*</span>
            <select id="product" name="product" class="form-select" required>
              <option disabled selected>-- SELECT PRODUCT --</option>
              @foreach ($projects as $product)
                <option value="{{ $product->id }}">{{ $product->title }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="periode" class="text-gray-600 mb-1">Month Periode</label>
            <span class="text-red-600">*</span>
            <div class="input-group">
              <i class="input-group-text mdi mdi-calendar"></i>
              <input id="periode" type="month" name="periode" class="form-control" value="{{ date('Y-m') }}" required>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="income" class="text-gray-600 mb-1">Total Income</label>
            <span class="text-red-600">*</span>
            <div class="input-group">
              <span class="input-group-text">Rp </span>
              <input id="income" type="number" name="income" class="form-control" value="0" required>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="report_file" class="text-gray-600 mb-1">Report File</label>
            <input id="report_file" type="file" name="report_file" class="form-control" accept="application/pdf">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Cancel</button>
          <button id="submit-report-form" type="button" class="btn btn-sm btn-success"><i class="mdi mdi-content-save mr-1"></i> Submit Report</button>
        </div>
      </form>
    </div>
  </div>
  <script>
    document.querySelector('button#submit-report-form').addEventListener('click', async () => {
      const result = await Swal.fire({
        text: 'This action is irreversible. After you click submit, your balance will be transferred to each investor that participated in selected product based on their invest percentage. Are you sure want to continue?',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Proceed',
        cancelButtonText: 'Cancel',
        confirmButtonColor: 'rgb(22 163 74)',
        cancelButtonColor: 'rgb(220 38 38)',
      });

      if (!result.isConfirmed) return;
      const form = document.querySelector('form#report-form');
      const product = document.querySelector('select#product').value;
      const periode = document.querySelector('input#periode').value;
      const income = document.querySelector('input#income').value;

      if (product == '' || periode == '' || income == '')
        return Swal.fire({
          icon: 'error',
          text: 'Field cannot be empty',
          showConfirmButton: false,
          timer: 2500,
        });

      form.submit();
    });
  </script>
@endsection