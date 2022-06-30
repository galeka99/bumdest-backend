@extends('template.dashboard')
@section('title', 'Update Product')
@section('content')
<form id="add" action="{{ url('products/'.$product->id) }}" method="POST" enctype="multipart/form-data">
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Update Product</span>
      @include('component.alert')
      <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
        @csrf
        @method('PUT')
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="title">Product Title</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="text" id="title" name="title" class="form-control form-control-sm" value="{{ $product->title }}" required>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="description">Description</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <textarea name="description" id="description" rows="5" class="form-control form-control-sm" required>{{ $product->description }}</textarea>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="end_offer">Product Status</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <select name="status" id="status" class="form-select">
              @foreach ($statuses as $status)
                <option value="{{ $status->id }}" @if ($status->id === $product->status_id) selected @endif>{{ $status->label }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="current">Current Invest Amount</label>
          </div>
          <div class="w-3/4">
            <div class="input-group">
              <span class="input-group-text">Rp </span>
              <input type="number" id="current" name="current" class="form-control form-control-sm" value="{{ $product->current_invest }}" disabled>
            </div>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="target">Target Invest Amount</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <div class="input-group">
              <span class="input-group-text">Rp </span>
              <input type="number" id="target" name="target" class="form-control form-control-sm" value="{{ $product->invest_target }}" required>
            </div>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="start_offer">Offer Start Date</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="date" id="start_offer" name="start_offer" class="form-control form-control-sm" value="{{ $product->offer_start_date }}" required>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="end_offer">Offer End Date</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="date" id="end_offer" name="end_offer" class="form-control form-control-sm" value="{{ $product->offer_end_date }}" required>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="proposal">Proposal Attachment</label>
          </div>
          <div class="w-3/4">
            <input type="file" id="proposal" name="proposal" class="form-control form-control-sm" accept="application/pdf">
          </div>
        </div>
        @if ($product->proposal)
          <div class="flex flex-row mb-3">
            <div class="w-1/4"></div>
            <div class="flex flex-row items-start w-3/4 gap-x-2">
              <a href="{{ $product->proposal }}" target="_blank" class="btn btn-sm btn-primary"><i class="mdi mdi-eye mr-1"></i> View Proposal</a>
              <button type="button" class="btn btn-sm btn-danger" onclick="deleteProposal()"><i class="mdi mdi-delete mr-1"></i> Delete Proposal</button>
            </div>
          </div>
        @endif
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="images">Product Images</label>
          </div>
          <div class="w-3/4">
            <input type="file" id="images" name="images[]" class="form-control form-control-sm" accept="image/*" multiple>
          </div>
        </div>
        <div class="grid grid-cols-6 gap-3 mb-3">
          @foreach ($product->images as $image)
            <div class="relative w-full border border-gray-600">
              <img src="{{ $image->url }}" alt="" class="w-full h-auto">
              <div class="absolute bottom-3 left-3 gap-x-3">
                <a href="{{ $image->url }}" target="_blank" class="btn btn-sm btn-primary"><i class="mdi mdi-eye mr-1"></i>View</a>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteImage({{ $image->id }})"><i class="mdi mdi-delete mr-1"></i>Delete</button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="flex flex-row justify-between">
        <a href="{{ url('products') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-chevron-double-left mr-1"></i> Back</a>
        <button type="submit" class="btn btn-sm btn-success"><i class="mdi mdi-content-save mr-1"></i> Save</button>
      </div>
    </div>
  </form>
  <form id="delete-proposal" action="{{ url('products/'.$product->id.'/proposal') }}" method="POST">
    @csrf
    @method('DELETE')
  </form>
  <form id="delete-image" action="{{ url('products/'.$product->id.'/image') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="image_id">
  </form>
  <script>
    async function deleteProposal() {
      const result = await Swal.fire({
        text: 'Are you sure want to delete this proposal?',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: 'rgb(220 38 38)',
      });

      if (!result.isConfirmed) return;
      document.querySelector('form#delete-proposal').submit();
    }

    async function deleteImage(id) {
      const result = await Swal.fire({
        text: 'Are you sure want to delete this image?',
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        confirmButtonColor: 'rgb(220 38 38)',
      });

      if (!result.isConfirmed) return;
      const form = document.querySelector('form#delete-image');
      const imageId = document.querySelector('form#delete-image input[name="image_id"]');
      imageId.value = id;
      form.submit();
    }
  </script>
@endsection