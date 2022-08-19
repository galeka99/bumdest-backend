@extends('template.common')
@section('title', 'Review BUMDes')
@section('content')
<div class="flex flex-row justify-center w-screen min-h-screen bg-gray-800">
  <div class="flex flex-col items-center bg-white w-full md:w-10/12 lg:w-8/12 xl:w-6/12 p-4">
    <span class="text-xl font-bold uppercase mb-1">Review Us</span>
    <hr class="w-full">
    <iframe class="w-full aspect-video border border-gray-400 rounded-lg shadow-lg mb-5" src="{{ $bumdes->maps_url }}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
    <span class="text-2xl text-blue-600 font-bold uppercase mb-2">{{ $bumdes->name }}</span>
    <span class="text-gray-600 mb-1">{{ $bumdes->address }}</span>
    <span class="text-sm text-gray-600 font-bold uppercase"><i class="mdi mdi-map-marker text-blue-600 mr-1"></i>{{ $bumdes->location['district_name'].", ".$bumdes->location['city_name'].", ".$bumdes->location['province_name'] }}</span>
    <hr class="w-full mb-3">
    @include('component.alert')
    <form id="submit-review" action="{{ url('review/'.$bumdes->code) }}" method="POST" class="flex flex-col w-full">
      @csrf
      <input type="hidden" name="google_id">
      <input type="hidden" name="image_url">
      <input type="hidden" name="name">
      <input type="hidden" name="email">
      <input type="hidden" name="rating" value="0">
      <div class="flex flex-row mb-3">
        <div class="flex flex-col w-full mr-5">
          <div class="input-group input-group-sm mb-2">
            <i class="input-group-text mdi mdi-account"></i>
            <input type="text" id="name" class="form-control" placeholder="Full Name" disabled>
          </div>
          <div class="input-group input-group-sm">
            <i class="input-group-text mdi mdi-at"></i>
            <input type="email" id="email" class="form-control form-control-sm" placeholder="Email Address" disabled>
          </div>
        </div>
        <div id="avatar" class="flex w-16 h-16 justify-center items-center aspect-square bg-gray-100 border border-gray-200 rounded-full">
          <i class="mdi mdi-account text-3xl text-gray-500"></i>
        </div>
        <img id="avatar" src="" alt="user avatar" class="w-16 h-16 aspect-square rounded-full hidden">
      </div>
      <div id="stars" class="flex flex-row justify-center mb-3">
      </div>
      <textarea name="review" id="review" rows="5" class="form-control form-control-sm w-full resize-none mb-3" placeholder="Write your review here..."></textarea>
      <button id="signin-first" type="button" class="btn btn-sm btn-primary uppercase font-bold" disabled>Please Sign In First</button>
    </form>
    <hr class="w-full mt-5 mb-3">
    <span class="text-center text-gray-800 font-bold uppercase mb-3">Latest Reviews</span>
    <div class="flex flex-col w-full gap-y-3">
      @foreach ($reviews as $review)
        <div class="flex flex-col w-full bg-white border border-gray-200 rounded p-3">
          <div class="flex flex-row items-center w-full">
            <img src="{{ $review->visitor->image_url }}" alt="reviewer's avatar" class="w-10 h-10 rounded-full mr-5">
            <div class="flex flex-col w-full">
              <span class="font-semibold">{{ $review->visitor->name }}</span>
              <div class="gap-x-1">
                @for ($i = 0; $i < 5; $i++)
                  <i class="mdi mdi-star {{ $i < $review->rating ? 'text-amber-600' : 'text-gray-400' }}"></i>
                @endfor
              </div>
            </div>
            <div class="flex flex-col items-end">
              <span class="text-xs text-gray-300">{{ date('m/d/Y', strtotime($review->updated_at)) }}</span>
              <span class="text-xs text-gray-300">{{ date('H:i:s', strtotime($review->updated_at)) }}</span>
            </div>
          </div>
          <span class="text-justify mt-3">{{ $review->description }}</span>
        </div>
      @endforeach
    </div>
    <hr class="w-full mt-5 mb-4">
    <div class="flex flex-col justify-center items-center">
      <span class="text-xs text-gray-500">Copyright &copy; {{ date('Y') }}. Bumdest. All Rights Reserved.</span>
    </div>
  </div>
</div>
<div id="g_id_onload"
  data-client_id="741909550840-0bkcpsvsbkchu5lod068aqsjj8nkqtva"
  data-callback="handleSignIn"
  data-context="signin"
  data-cancel_on_tap_outside="false">
</div>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script>
  let ratingValue = 0;

  function updateStar(value) {
    document.querySelector('input[name="rating"]').value = parseInt(value);
    ratingValue = parseInt(value);
    renderStars();
  }

  function renderStars() {
    const parent = document.querySelector('div#stars');
    parent.innerHTML = '';
    for (let i = 0; i < 5; i++) {
      if (ratingValue <= i) {
        parent.innerHTML += `<i class="mdi mdi-star text-3xl text-gray-400 mx-3" onclick="updateStar(${i + 1})"></i>`;
      } else {
        parent.innerHTML += `<i class="mdi mdi-star text-3xl text-amber-600 mx-3" onclick="updateStar(${i + 1})"></i>`;
      }
    }
  }

  window.addEventListener('DOMContentLoaded', () => renderStars());

  function decodeJwt(payload) {
    const arr = payload.split('.');
    const data = atob(arr[1]);
    return JSON.parse(data);
  }

  function handleSignIn(response) {
    const data = decodeJwt(response.credential);
    console.log(data);

    const form = document.querySelector('form#submit-review');
    const disabledSubmitButton = document.querySelector('button#signin-first');
    disabledSubmitButton.remove();
    form.innerHTML += `\n<button id="submit" type="submit" class="btn btn-sm btn-primary uppercase font-bold">Submit Review</button>`;

    const googleId = document.querySelector('input[name="google_id"]');
    const name = document.querySelector('input[name="name"]');
    const email = document.querySelector('input[name="email"]');
    const namePlaceholder = document.querySelector('input#name');
    const emailPlaceholder = document.querySelector('input#email');
    const imageUrl = document.querySelector('input[name="image_url"]');
    const avatarPlaceholder = document.querySelector('div#avatar');
    const avatar = document.querySelector('img#avatar');

    googleId.value = data.sub;
    name.value = data.name;
    email.value = data.email;
    namePlaceholder.value = data.name;
    emailPlaceholder.value = data.email;
    imageUrl.value = data.picture;
    avatar.src = data.picture;
    avatarPlaceholder.classList.toggle('hidden');
    avatar.classList.toggle('hidden');
  }
</script>
@endsection