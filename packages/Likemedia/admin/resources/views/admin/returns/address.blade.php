<input type="hidden" name="addressCourier" value="{{!empty($address) ? $address->id : 0}}">
<ul>
  <li>
      <label for="addressname">Addressname</label>
      <input type="text" name="addressname" class="name" id="addressname" value="{{!empty($address) ? $address->addressname : old('addressname')}}">
  </li>
  <li>
    <label for="country">Country</label>
    <select name="country" class="name filterCountries" data-id="0" id="country">
        <option disabled selected>Выберите страну</option>
        @foreach ($countries as $onecountry)
            <option {{!empty($address) && $address->country == $onecountry->id ? 'selected' : '' }} value="{{$onecountry->id}}">{{$onecountry->name}}</option>
        @endforeach
    </select>
  </li>
  <li>
    <label for="region">Region</label>
    <input type="text" name="region" class="name" id="region" value="{{!empty($address) ? $address->region : old('region')}}">
  </li>
  <li>
    <label for="location">Location</label>
    <input type="text" name="location" class="name" id="location" value="{{!empty($address) ? $address->location : old('location')}}">
  </li>
  <li>
      <label for="address">Address</label>
      <input type="text" name="address" class="name" id="address" value="{{!empty($address) ? $address->address : old('address')}}">
  </li>
  <li>
      <label for="code">Code</label>
      <input type="text" name="code" class="name" id="code" value="{{!empty($address) ? $address->code : old('code')}}">
  </li>
  <li>
      <label for="apartment">Apartment</label>
      <input type="text" name="apartment" class="name" id="apartment" value="{{!empty($address) ? $address->apartment : old('apartment')}}">
  </li>
  <li>
      <label for="homenumber">Homenumber</label>
      <input type="text" name="homenumber" class="name" id="homenumber" value="{{!empty($address) ? $address->homenumber : old('homenumber')}}">
  </li>
  <li>
      <label for="entrance">Entrance</label>
      <input type="text" name="entrance" class="name" id="entrance" value="{{!empty($address) ? $address->entrance : old('entrance')}}">
  </li>
  <li>
      <label for="floor">Floor</label>
      <input type="text" name="floor" class="name" id="floor" value="{{!empty($address) ? $address->floor : old('floor')}}">
  </li>
  <li>
      <label for="comment">Comment</label>
      <input type="text" name="comment" class="name" id="comment" value="{{!empty($address) ? $address->comment : old('comment')}}">
  </li>
</ul>
