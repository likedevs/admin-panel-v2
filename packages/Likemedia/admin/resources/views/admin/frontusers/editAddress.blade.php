<ul>
  <li>
      <label for="addressname">Addressname</label>
      <input type="text" name="addressname" class="name" id="addressname" value="{{$address->addressname}}">
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
    <input type="text" name="region" class="name" id="region" value="{{$address->region}}">
  </li>
  <li>
    <label for="location">Location</label>
    <input type="text" name="location" class="name" id="location" value="{{$address->location}}">
  </li>
  <li>
      <label for="address">Address</label>
      <input type="text" name="address" class="name" id="address" value="{{$address->address}}">
  </li>
  <li>
      <label for="code">Code</label>
      <input type="text" name="code" class="name" id="code" value="{{$address->code}}">
  </li>
  <li>
      <label for="apartment">Apartment</label>
      <input type="text" name="apartment" class="name" id="apartment" value="{{$address->apartment}}">
  </li>
  <li>
      <label for="homenumber">Homenumber</label>
      <input type="text" name="homenumber" class="name" id="homenumber" value="{{$address->homenumber}}">
  </li>
  <li>
      <label for="entrance">Entrance</label>
      <input type="text" name="entrance" class="name" id="entrance" value="{{$address->entrance}}">
  </li>
  <li>
      <label for="floor">Floor</label>
      <input type="text" name="floor" class="name" id="floor" value="{{$address->floor}}">
  </li>
  <li>
      <label for="comment">Comment</label>
      <input type="text" name="comment" class="name" id="comment" value="{{$address->comment}}">
  </li>
</ul>
