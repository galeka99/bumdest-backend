@extends('template.dashboard')
@section('title', 'Profile')
@section('content')
  <form method="POST" action="{{ url('/profile') }}" class="flex flex-col p-4">
    @csrf
    @method('PUT')
    <span class="text-xl text-blue-600 font-bold uppercase mb-3">Update Profile</span>
    @include('component.alert')
    <div class="flex flex-col bg-white w-full rounded-lg shadow p-3 mb-3">
      <div class="flex flex-row gap-x-5">
        <div class="flex flex-col w-full">
          <span class="text-blue-500 font-bold uppercase mb-3">User Profile</span>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_name" class="w-2/5">Name<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-account"></i>
              <input type="text" id="user_name" name="user_name" class="form-control w-full" value="{{ auth()->user()->name }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_email" class="w-2/5">Email Address<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-at"></i>
              <input type="email" id="user_email" name="user_email" class="form-control w-full" value="{{ auth()->user()->email }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_password" class="w-2/5">New Password</label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-lock"></i>
              <input type="password" id="user_password" name="user_password" class="form-control w-full" placeholder="Leave it empty if no password change">
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_phone" class="w-2/5">Phone<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-phone"></i>
              <input type="text" id="user_phone" name="user_phone" class="form-control w-full" value="{{ auth()->user()->phone }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_gender" class="w-2/5">Gender<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-gender-male-female"></i>
              <select name="user_gender" id="user_gender" class="form-select" required>
                @foreach ($genders as $gender)
                  <option value="{{ $gender->id }}" @if($gender->id == auth()->user()->gender_id) selected @endif>{{ $gender->label }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group flex flex-row items-start mb-3">
            <label for="user_address" class="w-2/5">Address<span class="text-red-600">*</span></label>
            <textarea name="user_address" id="user_address" rows="5" class="form-control">{{ auth()->user()->address }}</textarea>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_postal_code" class="w-2/5">Postal Code<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-mailbox"></i>
              <input type="text" id="user_postal_code" name="user_postal_code" class="form-control w-full" value="{{ auth()->user()->postal_code }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_province" class="w-2/5">Province<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-map-marker"></i>
              <select name="user_province" id="user_province" class="form-select" required>
                @foreach ($provinces as $province)
                  <option value="{{ $province->id }}" @if($province->id == auth()->user()->location['province_id']) selected @endif>{{ $province->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_city" class="w-2/5">City<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-map-marker"></i>
              <select name="user_city" id="user_city" class="form-select" required>
                @foreach ($user_cities as $city)
                  <option value="{{ $city->id }}" @if($city->id == auth()->user()->location['city_id']) selected @endif>{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="user_district" class="w-2/5">District<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-map-marker"></i>
              <select name="user_district" id="user_district" class="form-select" required>
                @foreach ($user_districts as $district)
                  <option value="{{ $district->id }}" @if($district->id == auth()->user()->location['district_id']) selected @endif>{{ strtoupper($district->name) }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <hr class="mb-3">
          <div class="form-group flex flex-row items-center mb-3">
            <label for="old_password" class="w-2/5">Password<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-lock"></i>
              <input type="password" id="password" name="password" class="form-control w-full" placeholder="Type your password to save changes" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="confirm_old_password" class="w-2/5">Confirm Password<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-lock"></i>
              <input type="password" id="confirm_password" name="confirm_password" class="form-control w-full" placeholder="Confirm your password" required>
            </div>
          </div>
        </div>
        <div class="flex flex-col w-full">
          <span class="text-blue-500 font-bold uppercase mb-3">BUMDes Profile</span>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="bumdes_name" class="w-2/5">Name<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-account"></i>
              <input type="text" id="bumdes_name" name="bumdes_name" class="form-control w-full" value="{{ auth()->user()->bumdes->name }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="bumdes_phone" class="w-2/5">Phone<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-phone"></i>
              <input type="text" id="bumdes_phone" name="bumdes_phone" class="form-control w-full" value="{{ auth()->user()->bumdes->phone }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-start mb-3">
            <label for="bumdes_description" class="w-2/5">Description<span class="text-red-600">*</span></label>
            <textarea name="bumdes_description" id="bumdes_description" rows="10" class="form-control">{{ auth()->user()->bumdes->description }}</textarea>
          </div>
          <div class="form-group flex flex-row items-start mb-3">
            <label for="bumdes_address" class="w-2/5">Address<span class="text-red-600">*</span></label>
            <textarea name="bumdes_address" id="bumdes_address" rows="5" class="form-control">{{ auth()->user()->bumdes->address }}</textarea>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="bumdes_postal_code" class="w-2/5">Postal Code<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-mailbox"></i>
              <input type="text" id="bumdes_postal_code" name="bumdes_postal_code" class="form-control w-full" value="{{ auth()->user()->bumdes->postal_code }}" required>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="bumdes_province" class="w-2/5">Province<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-map-marker"></i>
              <select name="bumdes_province" id="bumdes_province" class="form-select" required>
                @foreach ($provinces as $province)
                  <option value="{{ $province->id }}" @if($province->id == auth()->user()->bumdes->location['province_id']) selected @endif>{{ $province->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="bumdes_city" class="w-2/5">City<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-map-marker"></i>
              <select name="bumdes_city" id="bumdes_city" class="form-select" required>
                @foreach ($bumdes_cities as $city)
                  <option value="{{ $city->id }}" @if($city->id == auth()->user()->bumdes->location['city_id']) selected @endif>{{ $city->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group flex flex-row items-center mb-3">
            <label for="bumdes_district" class="w-2/5">District<span class="text-red-600">*</span></label>
            <div class="input-group">
              <i class="input-group-text mdi mdi-map-marker"></i>
              <select name="bumdes_district" id="bumdes_district" class="form-select" required>
                @foreach ($bumdes_districts as $district)
                  <option value="{{ $district->id }}" @if($district->id == auth()->user()->bumdes->location['district_id']) selected @endif>{{ strtoupper($district->name) }}</option>
                @endforeach
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-row justify-end gap-x-3">
      <button type="submit" class="btn btn-sm btn-success"><i class="mdi mdi-content-save mr-1"></i> Save</button>
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

    const userProvince = document.querySelector('select#user_province');
    const userCity = document.querySelector('select#user_city');
    const userDistrict = document.querySelector('select#user_district');
    const bumdesProvince = document.querySelector('select#bumdes_province');
    const bumdesCity = document.querySelector('select#bumdes_city');
    const bumdesDistrict = document.querySelector('select#bumdes_district');

    userProvince.addEventListener('change', async (event) => {
      const provinceId = event.target.value;
      const cities = await getCity(provinceId);
      userCity.innerHTML = '<option disabled selected>-- SELECT CITY --</option>\n';
      cities.forEach(city => {
        userCity.innerHTML += `<option value="${city.id}">${city.name}</option>`;
      });
    });

    userCity.addEventListener('change', async (event) => {
      const cityId = event.target.value;
      const districts = await getDistrict(cityId);
      userDistrict.innerHTML = '<option disabled selected>-- SELECT DISTRICT --</option>\n';
      districts.forEach(district => {
        userDistrict.innerHTML += `<option value="${district.id}">${district.name.toUpperCase()}</option>`;
      });
    });

    bumdesProvince.addEventListener('change', async (event) => {
      const provinceId = event.target.value;
      const cities = await getCity(provinceId);
      bumdesCity.innerHTML = '<option disabled selected>-- SELECT CITY --</option>\n';
      cities.forEach(city => {
        bumdesCity.innerHTML += `<option value="${city.id}">${city.name}</option>`;
      });
    });

    bumdesCity.addEventListener('change', async (event) => {
      const cityId = event.target.value;
      const districts = await getDistrict(cityId);
      bumdesDistrict.innerHTML = '<option disabled selected>-- SELECT DISTRICT --</option>\n';
      districts.forEach(district => {
        bumdesDistrict.innerHTML += `<option value="${district.id}">${district.name.toUpperCase()}</option>`;
      });
    });
  </script>
@endsection