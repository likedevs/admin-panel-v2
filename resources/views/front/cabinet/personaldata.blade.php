@extends('front.app')
@section('content')
    <div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cabDate">
      <div class="container">

        <div class="row">
          <div class="col-12">
            <h3>{{trans('front.ja.personalData')}}</h3>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="cabCat">
              <div class="sal">
                {{trans('front.ja.hello')}}, {{$userdata->name}}
              </div>
              <ul>
                <li class="pageActiveCab"><a href="{{route('cabinet')}}">{{trans('front.cabinet.userdata')}}</a></li>
                <li><a href="{{route('cart')}}">{{trans('front.cabinet.cart')}}</a></li>
                <li><a href="{{route('cabinet.wishList')}}">{{trans('front.cabinet.wishList')}}</a></li>
                <li><a href="{{route('cabinet.history')}}">{{trans('front.cabinet.history')}}</a></li>
                <li><a href="{{route('cabinet.return')}}">{{trans('front.cabinet.return')}}</a></li>
                <li><a href="{{url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-9 col-md-12 cabFormNew">
            <div class="row">

             @if ($errors->any())
                 @foreach ($errors->all() as $error)
                     <div class="invalid-feedback text-center" style="display: block">
                       {!!$error!!}
                     </div>
                 @endforeach
             @endif

             @if (Session::has('success'))
                 <div class="valid-feedback text-center" style="display: block">
                     {{ Session::get('success') }}
                 </div>
             @endif

            </div>
            <div class="row" style="border-bottom: 1px solid #979797; padding-bottom: 10px;">
              <div class="col-md-9 col-12">
                <div class="block">
                  <div>
                    {{trans('front.cabinet.name')}} {{trans('front.cabinet.surname')}}
                  </div>
                  <div>
                    {{$userdata->name}} {{$userdata->surname}}
                  </div>
                </div>
                <div class="block">
                  <div>
                    {{trans('front.cabinet.phone')}}
                  </div>
                  <div>
                    {{$userdata->phone}}
                  </div>
                </div>
                <div class="block">
                  <div>
                    {{trans('front.cabinet.company')}}
                  </div>
                  <div>
                    {{$userdata->company}}
                  </div>
                </div>
                <div class="block">
                  <div>
                    {{trans('front.cabinet.email')}}
                  </div>
                  <div>
                    {{$userdata->email}}
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="btnBrun" style="margin-top: 20px;" data-toggle="modal" data-target="#changePersonalData">
                  {{trans('front.cabinet.myaddresses.modifyBtn')}}
                </div>
                <div class="modal" id="changePersonalData">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">{{trans('front.cabinet.userdata')}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        <div class="row justify-content-center">
                          <div class="col-9">
                            <form action="{{route('cabinet.savePersonalData')}}" method="post">
                              {{ csrf_field() }}

                              @if (count($userfields) > 0)
                                  @foreach ($userfields as $key => $userfield)
                                      @if ($userfield->field_group == 'personaldata' && $userfield->type != 'checkbox')
                                          <?php $field = $userfield->field;?>
                                          <div class="form-group">
                                            <label for="{{$field}}">{{trans('front.register.'.$field)}}</label>
                                            <input type="{{$userfield->type}}" name="{{$field}}" class="form-control" id="{{$field}}" value="{{$userdata->$field}}">
                                          </div>
                                      @endif
                                  @endforeach
                              @endif
                              <div class="row justify-content-center">
                                <div class="col-md-6 col-sm-12">
                                  <input type="submit" name="saveChangesCabPers" class="form-control btnBrun" value="{{trans('front.cabinet.saveBtn')}}" class="saveChangesCab">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h5 style="padding-bottom: 0;padding-top: 10px;">{{trans('front.ja.password')}}</h5>
            <div class="row align-items-center" style="border-bottom: 1px solid #979797;">
              <div class="col-9">
                <div class="block">
                  <div>
                    ***********
                  </div>
                </div>
              </div>
              <div class="col-md-3 col-6">
                <div class="btnBrun" data-toggle="modal" data-target="#changePwdModal" style="margin-bottom: 10px;">
                  {{trans('front.cabinet.myaddresses.modifyBtn')}}
                </div>
                <div class="modal" id="changePwdModal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title">{{trans('front.cabinet.pass')}}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        <div class="row justify-content-center">
                          <div class="col-9">
                            <form action="{{route('cabinet.savePass')}}" method="post">
                              {{ csrf_field() }}
                              <div class="row">
                                <div class="col-12">
                                  <label for="pwdCab">{{trans('front.cabinet.changePass.oldpass')}}:</label>
                                </div>
                                <div class="col-12">
                                  <input type="password" name="oldpass" id="pwdCab" value="">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <label for="newPwdCab">{{trans('front.cabinet.changePass.newpass')}}: </label>
                                </div>
                                <div class="col-12">
                                  <input type="password" name="newpass" id="newPwdCab" value="">
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-12">
                                  <label for="repeatPwdCab">{{trans('front.cabinet.changePass.repeatpass')}}: </label>
                                </div>
                                <div class="col-12">
                                  <input type="password" name="repeatnewpass" id="repeatPwdCab" value="">
                                </div>
                              </div>
                              <div class="row justify-content-center">
                                <div class="col-md-6 col-8">
                                  <input type="submit" name="saveChangesCabPers" value="{{trans('front.cabinet.saveBtn')}}" class="btnBrun">
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <h5 style="margin-top: 10px;">Adrese de livrare</h5>
            <div class="infAdress">

              @if (count($userdata->addresses()->get()) > 0)
                  @foreach ($userdata->addresses()->get() as $address)
                      <div class="row align-items-center adressItem1">
                        <div class="col-7 block">
                          <div>{{trans('front.cabinet.myaddresses.addressname')}}: {{$address->addressname}}</div>
                          <div> {{$address->getCountryById()->first() ? $address->getCountryById()->first()->name.',' : ''}}
                                {{$address->getRegionById()->first() ? $address->getRegionById()->first()->name.',' : ''}}
                                {{$address->getCityById()->first() ? $address->getCityById()->first()->name.',' : ''}}
                                {{$address->address}}</div>
                        </div>
                        <div class="col-md-5 col-12 d-flex justify-content-between">
                          <div class="btnBrun" data-toggle="modal" data-target="#changeAdressModal{{$address->id}}" style="margin-right: 10px;">
                            {{trans('front.cabinet.myaddresses.modifyBtn')}}
                          </div>
                          <div class="btnGrey">
                            <form action="{{route('cabinet.deleteAddress', $address->id)}}" method="post">
                              {{ csrf_field() }}
                              {{ method_field('DELETE') }}
                              <div onclick="this.parentNode.submit()">
                                {{trans('front.cabinet.myaddresses.deleteBtn')}}
                              </div>
                            </form>

                          </div>
                        </div>
                      </div>

                      <div class="modal" id="changeAdressModal{{$address->id}}">
                        <div class="modal-dialog">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">{{trans('front.cabinet.myaddresses.modifyBtnAddress')}}</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                              <div class="row justify-content-center">
                                <div class="col-9">
                                  <form action="{{route('cabinet.saveAddress', $address->id)}}" method="post">
                                    {{ csrf_field() }}
                                      @if (count($userfields) > 0)
                                          @foreach ($userfields as $key => $userfield)
                                            <?php $field = $userfield->field;?>
                                              @if ($userfield->field_group == 'address' && $userfield->type == 'text')

                                                <div class="row">
                                                  <div class="col-12">
                                                    <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                                  </div>
                                                  <div class="col-12">
                                                    <input type="text" name="{{$field}}" value="{{$address->$field}}">
                                                  </div>
                                                </div>
                                              @endif

                                              @if ($userfield->field == 'country')
                                                  <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                                  <select name="{{$field}}" class="name filterCountries" id="{{$field}}">
                                                      <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseCountry')}}</option>
                                                      @foreach ($countries as $onecountry)
                                                          <option {{!empty($address) && $address->country == $onecountry->id ? 'selected' : '' }} value="{{$onecountry->id}}">{{$onecountry->name}}</option>
                                                      @endforeach
                                                  </select>
                                              @endif

                                              @if ($userfield->field == 'region')
                                                  <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                                  <select name="{{$field}}" class="name filterRegions" id="{{$field}}">
                                                      <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseRegion')}}</option>
                                                      @foreach ($regions as $region)
                                                          @foreach ($region as $oneregion)
                                                              <option {{!empty($address) && $address->region == $oneregion->id ? 'selected' : '' }} value="{{$oneregion->id}}">{{$oneregion->name}}</option>
                                                          @endforeach
                                                      @endforeach
                                                  </select>
                                              @endif

                                              @if ($userfield->field == 'location')
                                                <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                                  <select name="{{$field}}" class="name filterCities" id="{{$field}}">
                                                      <option disabled selected value="">{{trans('front.cabinet.myaddresses.chooseLocation')}}</option>
                                                      @foreach ($cities as $city)
                                                          @foreach ($city as $onecity)
                                                              <option {{!empty($address) && $address->location == $onecity->id ? 'selected' : '' }} value="{{$onecity->id}}">{{$onecity->name}}</option>
                                                          @endforeach
                                                      @endforeach
                                                  </select>
                                              @endif

                                          @endforeach
                                      @endif
                                      <div class="row justify-content-center">
                                      <div class="col-md-6 col-sm-8">
                                        <input type="submit" name="saveChangesCabPers" value="{{trans('front.cabinet.saveBtn')}}" class="btnBrun">
                                      </div>
                                    </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                  @endforeach
              @endif
            </div>
              <div class="row justify-content-end" style="margin-top: 20px; padding-bottom: 20px;border-bottom: 1px solid #979797;">
                <div class="col-lg-3 col-md-5 col-6">
                  <div class="btnBrun" data-toggle="modal" data-target="#addAdressModal">
                    {{trans('front.cart.addAddressBtn')}}
                  </div>
                  <div class="modal" id="addAdressModal">
                    <div class="modal-dialog">
                      <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                          <h4 class="modal-title">{{trans('front.cart.addAddressBtn')}}</h4>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">
                          <div class="row justify-content-center">
                            <div class="col-9">
                              <form action="{{route('cabinet.addAddress')}}" method="post">
                                {{ csrf_field() }}
                                @if (count($userfields) > 0)
                                    @foreach ($userfields as $key => $userfield)
                                      <?php $field = $userfield->field;?>
                                        @if ($userfield->field_group == 'address' && $userfield->type == 'text')

                                          <div class="row">
                                            <div class="col-12">
                                              <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                            </div>
                                            <div class="col-12">
                                              <input type="text" name="{{$field}}" value="{{old($field)}}">
                                            </div>
                                          </div>
                                        @endif

                                        @if ($userfield->field == 'country')
                                            <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                            <select name="{{$field}}" class="name filterCountries" id="{{$field}}">
                                                <option disabled selected>{{trans('front.cabinet.myaddresses.chooseCountry')}}</option>
                                                @foreach ($countries as $onecountry)
                                                    <option value="{{$onecountry->id}}">{{$onecountry->name}}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                        @if ($userfield->field == 'region')
                                            <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                            <select name="{{$field}}" class="name filterRegions" id="{{$field}}">
                                                <option disabled selected>{{trans('front.cabinet.myaddresses.chooseRegion')}}</option>
                                            </select>
                                        @endif

                                        @if ($userfield->field == 'location')
                                          <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}:</label>
                                            <select name="{{$field}}" class="name filterCities" id="{{$field}}">
                                                <option disabled selected>{{trans('front.cabinet.myaddresses.chooseLocation')}}</option>
                                            </select>
                                        @endif

                                    @endforeach
                                @endif
                                <div class="row justify-content-center">
                                  <div class="col-md-6 col-sm-8">
                                    <input type="submit" name="saveChangesCabPers" value="{{trans('front.cabinet.saveBtn')}}" class="btnBrun">
                                  </div>
                              </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @if (count($userfields) > 0 && count($userdata->addresses()->get()) > 0)
                  @foreach ($userfields as $userfield)
                      @if ($userfield->field == 'priorityaddress')
                          <div class="row">
                            <div class="col-12">
                              <h5>{{trans('front.cabinet.myaddresses.priorityAddress')}}</h5>
                            </div>
                            <div class="col-7 block">
                              @if (count($userdata->priorityAddress()->first()) > 0)
                                <?php $priorityAddress = $userdata->priorityAddress()->first(); ?>
                                <div>{{trans('front.cabinet.myaddresses.addressname')}}: {{$priorityAddress->addressname}}</div>
                                <div> {{$priorityAddress->getCountryById()->first() ? $priorityAddress->getCountryById()->first()->name.',' : ''}}
                                      {{$priorityAddress->getRegionById()->first() ? $priorityAddress->getRegionById()->first()->name.',' : ''}}
                                      {{$priorityAddress->getCityById()->first() ? $priorityAddress->getCityById()->first()->name.',' : ''}}
                                      {{$priorityAddress->address}}</div>
                              @else
                                <div>{{trans('front.cabinet.myaddresses.noPriorityAddress')}}</div>
                              @endif
                            </div>
                            <div class="col-md-5 col-12 d-flex justify-content-between">
                              <div class="btnBrun" data-toggle="modal" data-target="#changeFacturModal" style="margin-right: 10px; height: 35px;">
                                {{trans('front.cabinet.myaddresses.modifyBtn')}}
                              </div>
                              <div class="modal" id="changeFacturModal">
                                <div class="modal-dialog">
                                  <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                      <h4 class="modal-title">{{trans('front.cabinet.myaddresses.priorityAddress')}}</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                      <div class="row justify-content-center">
                                        <div class="col-9">
                                          <form action="{{route('cabinet.priorityAddress')}}" method="post">
                                            {{ csrf_field() }}
                                            <div class="row">
                                              <div class="col-12">
                                                <label for="adresFact">{{trans('front.cabinet.myaddresses.addressname')}}:</label>
                                              </div>
                                              <div class="col-12">
                                                <select class="" name="priorityAddress">
                                                    @foreach ($userdata->addresses()->get() as $address)
                                                        <option {{$userdata->priorityaddress == $address->id ? 'selected' : '' }} value="{{$address->id}}">{{$address->addressname}}</option>
                                                    @endforeach
                                                </select>
                                              </div>
                                            </div>
                                            <div class="row justify-content-center">
                                              <div class="col-md-6 col-sm-12">
                                                <input type="submit" name="saveChangesCabPers" value="{{trans('front.cabinet.saveBtn')}}" class="btnBrun">
                                              </div>
                                            </div>
                                          </form>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                      @endif
                  @endforeach
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
