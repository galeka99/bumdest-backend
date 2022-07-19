@extends('template.dashboard')
@section('title', 'Add BUMDes')
@section('content')
<form id="add" action="{{ url('/bumdes/add') }}" method="POST">
  <div class="flex flex-col p-4">
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Add BUMDes</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      @csrf
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="bumdes_name">BUMDes Name</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="bumdes_name" name="bumdes_name" class="form-control form-control-sm" required autofocus>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="bumdes_phone">Phone</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="bumdes_phone" name="bumdes_phone" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="bumdes_address">Address</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <textarea name="bumdes_address" id="bumdes_address" rows="4" class="form-control form-control-sm" required></textarea>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="bumdes_postal_code">Postal Code</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="bumdes_postal_code" name="bumdes_postal_code" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4"></div>
        <div class="w-3/4 flex flex-row gap-x-2">
          <div class="w-1/3">
            <select name="bumdes_province" id="bumdes_province" class="form-select form-select-sm" required>
              <option disabled selected>-- SELECT PROVINCE --</option>
              @foreach ($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="w-1/3">
            <select name="bumdes_city" id="bumdes_city" class="form-select form-select-sm" required>
              <option disabled selected>-- SELECT CITY --</option>
            </select>
          </div>
          <div class="w-1/3">
            <select name="bumdes_district" id="bumdes_district" class="form-select form-select-sm" required>
              <option disabled selected>-- SELECT DISTRICT --</option>
            </select>
          </div>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="bumdes_description">BUMDes Description</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <textarea name="bumdes_description" id="bumdes_description" rows="4" class="form-control form-control-sm" required></textarea>
        </div>
      </div>
      <div class="flex flex-row items-center mb-3">
        <hr class="grow">
        <span class="text-gray-400 text-sm uppercase mx-3">BUMDes User</span>
        <hr class="grow">
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="user_name">User Full Name</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="user_name" name="user_name" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="user_email">Email Address</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="email" id="user_email" name="user_email" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="password">Password</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="password" id="password" name="password" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="user_phone">Phone</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="user_phone" name="user_phone" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="user_address">Address</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <textarea name="user_address" id="user_address" rows="4" class="form-control form-control-sm" required></textarea>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="user_postal_code">Postal Code</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <input type="text" id="user_postal_code" name="user_postal_code" class="form-control form-control-sm" required>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4"></div>
        <div class="w-3/4 flex flex-row gap-x-2">
          <div class="w-1/3">
            <select name="user_province" id="user_province" class="form-select form-select-sm" required>
              <option disabled selected>-- SELECT PROVINCE --</option>
              @foreach ($provinces as $province)
                <option value="{{ $province->id }}">{{ $province->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="w-1/3">
            <select name="user_city" id="user_city" class="form-select form-select-sm" required>
              <option disabled selected>-- SELECT CITY --</option>
            </select>
          </div>
          <div class="w-1/3">
            <select name="user_district" id="user_district" class="form-select form-select-sm" required>
              <option disabled selected>-- SELECT DISTRICT --</option>
            </select>
          </div>
        </div>
      </div>
      <div class="flex flex-row mb-3">
        <div class="w-1/4">
          <label for="gender">Gender</label>
          <span class="text-red-600">*</span>
        </div>
        <div class="w-3/4">
          <select name="gender" id="gender" class="form-select form-select-sm" required>
            <option disabled selected>-- SELECT GENDER --</option>
            @foreach ($genders as $gender)
              <option value="{{ $gender->id }}">{{ $gender->label }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
    <div class="flex flex-row justify-between">
      <a href="{{ url('bumdes') }}" class="btn btn-sm btn-primary"><i class="mdi mdi-chevron-double-left mr-1"></i> Back</a>
      <button type="submit" class="btn btn-sm btn-success"><i class="mdi mdi-content-save mr-1"></i> Save</button>
    </div>
  </div>
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

  const bumdesProvince = document.querySelector('select#bumdes_province');
  const bumdesCity = document.querySelector('select#bumdes_city');
  const bumdesDistrict = document.querySelector('select#bumdes_district');
  const userProvince = document.querySelector('select#user_province');
  const userCity = document.querySelector('select#user_city');
  const userDistrict = document.querySelector('select#user_district');

  bumdesProvince.addEventListener('change', async e => {
    const id = e.target.value;
    const cities = await getCity(id);
    bumdesCity.innerHTML = '<option disabled selected>-- SELECT CITY --</option>\n';
    cities.forEach(city => {
      bumdesCity.innerHTML += `<option value="${city.id}">${city.name}</option>`;
    });
  });

  bumdesCity.addEventListener('change', async e => {
    const id = e.target.value;
    const districts = await getDistrict(id);
    bumdesDistrict.innerHTML = '<option disabled selected>-- SELECT DISTRICT --</option>\n';
    districts.forEach(district => {
      bumdesDistrict.innerHTML += `<option value="${district.id}">${district.name}</option>`;
    });
  });

  userProvince.addEventListener('change', async e => {
    const id = e.target.value;
    const cities = await getCity(id);
    userCity.innerHTML = '<option disabled selected>-- SELECT CITY --</option>\n';
    cities.forEach(city => {
      userCity.innerHTML += `<option value="${city.id}">${city.name}</option>`;
    });
  });

  userCity.addEventListener('change', async e => {
    const id = e.target.value;
    const districts = await getDistrict(id);
    userDistrict.innerHTML = '<option disabled selected>-- SELECT DISTRICT --</option>\n';
    districts.forEach(district => {
      userDistrict.innerHTML += `<option value="${district.id}">${district.name}</option>`;
    });
  });
</script>
@endsection