<ul>
  <li>
      <label for="addressname">Addressname</label>
      <input type="text" name="addressname" class="name" id="addressname" value="{{old('addressname')}}">
  </li>
  <li>
    <label for="country">Country</label>
    <select name="country" class="name filterCountries" data-id="0" id="country">
        <option disabled selected>Выберите страну</option>
        @foreach ($countries as $onecountry)
            <option value="{{$onecountry->id}}">{{$onecountry->name}}</option>
        @endforeach
    </select>
  </li>
  <li>
    <label for="region">Region</label>
    <select name="region" class="name filterRegions" data-id="0" id="region">
        <option disabled selected>Выберите регион</option>
    </select>
  </li>
  <li>
    <label for="location">Location</label>
    <select name="location" class="name filterCities" data-id="0" id="location">
        <option disabled selected>Выберите город</option>
    </select>
  </li>
  <li>
      <label for="address">Address</label>
      <input type="text" name="address" class="name" id="address" value="{{old('address')}}">
  </li>
  <li>
      <label for="code">Code</label>
      <input type="text" name="code" class="name" id="code" value="{{old('code')}}">
  </li>
  <li>
      <label for="apartment">Apartment</label>
      <input type="text" name="apartment" class="name" id="apartment" value="{{old('apartment')}}">
  </li>
  <li>
      <label for="homenumber">Homenumber</label>
      <input type="text" name="homenumber" class="name" id="homenumber" value="{{old('homenumber')}}">
  </li>
  <li>
      <label for="entrance">Entrance</label>
      <input type="text" name="entrance" class="name" id="entrance" value="{{old('entrance')}}">
  </li>
  <li>
      <label for="floor">Floor</label>
      <input type="text" name="floor" class="name" id="floor" value="{{old('floor')}}">
  </li>
  <li>
      <label for="comment">Comment</label>
      <input type="text" name="comment" class="name" id="comment" value="{{old('comment')}}">
  </li>
</ul>
