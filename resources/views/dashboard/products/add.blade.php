@extends('template.dashboard')
@section('title', 'Add Product')
@section('content')
<form id="add" action="{{ url('/products/add') }}" method="POST" enctype="multipart/form-data">
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Add Product</span>
      @include('component.alert')
      <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
        @csrf
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="title">Product Name</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="text" id="title" name="title" class="form-control form-control-sm" required autofocus>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="description">Description</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <textarea name="description" id="description" rows="5" class="form-control form-control-sm" required></textarea>
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
              <input type="number" id="target" name="target" class="form-control form-control-sm" required>
            </div>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="start_offer">Offer Start Date</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="date" id="start_offer" name="start_offer" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
          </div>
        </div>
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="end_offer">Offer End Date</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="date" id="end_offer" name="end_offer" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
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
        <div class="flex flex-row mb-3">
          <div class="w-1/4">
            <label for="images">Product Images</label>
            <span class="text-red-600">*</span>
          </div>
          <div class="w-3/4">
            <input type="file" id="images" name="images[]" class="form-control form-control-sm" accept="image/*" multiple required>
          </div>
        </div>
      </div>
      <div class="flex flex-row justify-between">
        <a href="{{ url('products') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-chevron-double-left mr-1"></i> Back</a>
        <button type="submit" class="btn btn-sm btn-success"><i class="mdi mdi-content-save mr-1"></i> Save</button>
      </div>
    </div>
  </form>
@endsection