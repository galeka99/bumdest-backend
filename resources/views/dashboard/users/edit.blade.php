@extends('template.dashboard')
@section('title', 'Edit User')
@section('content')
<form id="add" action="{{ url('/user/'.$user->id) }}" method="POST">
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Edit User</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      @csrf
      @method('PUT')
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="name">Full Name</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="name" name="name" class="form-control form-control-sm" value="{{ $user->name }}" required autofocus>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="gender">Gender</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <select name="gender" id="gender" class="form-select form-select-sm" required>
            @foreach ($genders as $gender)
              <option value="{{ $gender->id }}" @if ($user->gender_id === $gender->id) selected @endif>{{ $gender->label }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="role">Role</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <select name="role" id="role" class="form-select form-select-sm" required>
            @foreach ($roles as $role)
              <option value="{{ $role->id }}" @if ($user->role_id === $role->id) selected @endif>{{ $role->label }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="status">Status</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <select name="status" id="status" class="form-select form-select-sm" required>
            @foreach ($statuses as $status)
              <option value="{{ $status->id }}" @if ($user->user_status_id === $status->id) selected @endif>{{ $status->label }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="email">Email</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="email" id="email" name="email" class="form-control form-control-sm" value="{{ $user->email }}" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="password">Password</label>
        </div>
        <div class="w-3/4">
          <input type="password" id="password" name="password" class="form-control form-control-sm">
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="confirm_password">Confirm Password</label>
        </div>
        <div class="w-3/4">
          <input type="password" id="confirm_password" name="confirm_password" class="form-control form-control-sm">
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="phone">Phone</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="phone" name="phone" class="form-control form-control-sm" value="{{ $user->phone }}" required>
        </div>
      </div>
      @if ($user->user_status_id === 3)
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="balance">Balance</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <div class="input-group">
            <span class="input-group-text">Rp </span>
            <input type="number" id="balance" name="balance" class="form-control form-control-sm" value="{{ $user->balance }}" required>
          </div>
        </div>
      </div>
      @endif
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="address">Address</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <textarea name="address" id="address" rows="4" class="form-control form-control-sm" required>{{ $user->address }}</textarea>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="postal_code">Postal Code</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="postal_code" name="postal_code" class="form-control form-control-sm" value="{{ $user->postal_code }}" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4"></div>
        <div class="w-3/4 flex flex-row gap-x-2">
          <div class="w-1/3">
            <select name="province" id="province" class="form-select form-select-sm" required>
              @foreach ($provinces as $province)
                <option value="{{ $province->id }}" @if ($user->location['province_id'] == $province->id) selected @endif>{{ $province->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="w-1/3">
            <select name="city" id="city" class="form-select form-select-sm" required>
              @foreach ($cities as $city)
                <option value="{{ $city->id }}" @if ($user->location['city_id'] == $city->id) selected @endif>{{ $city->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="w-1/3">
            <select name="district" id="district" class="form-select form-select-sm" required>
              @foreach ($districts as $district)
                <option value="{{ $district->id }}" @if ($user->location['district_id'] == $district->id) selected @endif>{{ $district->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-row justify-between">
      <a href="{{ url('user') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-chevron-double-left mr-1"></i> Back</a>
      <div class="flex flex-row gap-x-3">
        <button type="button" class="btn btn-sm btn-danger" onclick="deleteUser()"><i class="mdi mdi-delete mr-1"></i> Delete</button>
        <button type="submit" class="btn btn-sm btn-success"><i class="mdi mdi-content-save mr-1"></i> Save</button>
      </div>
    </div>
  </div>
</form>
<form id="delete-form" action="{{ url('/user/'.$user->id) }}" method="POST">
@csrf
@method('DELETE')
</form>
<script>
  async function getCity(id) {
    const res = await fetch(`{{ url('/api/v1/location/province') }}/${id}`);
    const json = await res.json();
    return json.data;
  }

  async function getDistrict(id) {
    const res = await fetch(`{{ url('/api/v1/location/city') }}/${id}`);
    const json = await res.json();
    return json.data;
  }

  const provinceSelector = document.querySelector('select#province');
  const citySelector = document.querySelector('select#city');
  const districtSelector = document.querySelector('select#district');

  provinceSelector.addEventListener('change', async e => {
    const id = e.target.value;
    const cities = await getCity(id);
    citySelector.innerHTML = '<option disabled selected>-- SELECT CITY --</option>\n';
    cities.forEach(city => {
      citySelector.innerHTML += `<option value="${city.id}">${city.name}</option>`;
    });
  });

  citySelector.addEventListener('change', async e => {
    const id = e.target.value;
    const districts = await getDistrict(id);
    districtSelector.innerHTML = '<option disabled selected>-- SELECT DISTRICT --</option>\n';
    districts.forEach(district => {
      districtSelector.innerHTML += `<option value="${district.id}">${district.name}</option>`;
    });
  });

  async function deleteUser() {
    const result = await Swal.fire({
      text: 'Are you sure want to delete this user?',
      showConfirmButton: true,
      showCancelButton: true,
      confirmButtonText: 'Delete',
      cancelButtonText: 'Cancel',
      confirmButtonColor: 'rgb(190 18 60)',
      cancelButtonColor: 'rgb(55 65 81)'
    });

    if (result.isConfirmed) {
      document.querySelector('form#delete-form').submit();
    }
  }
</script>
@endsection