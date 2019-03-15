@if (!is_null($subproduct))
<div class="modal" id="modalToCart{{ $subproduct->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Adăugat în coș</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 modal-image">
                        @if (!is_null($subproduct) && $subproduct->image)
                            @if (!is_null($subproduct->image()->first()))
                                <img src="{{ asset('images/subproducts/og/'.$subproduct->image()->first()->src) }}">
                            @else
                                <img src="{{ asset('upfiles/no-image.png') }}" alt="" class="itemImg">
                            @endif
                        @else
                        @if ($product->mainImage()->first())
                        <img src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
                        @endif
                        @endif
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12">
                                {{ $product->translationByLanguage($lang->id)->first()->name }}
                            </div>
                            <div class="col-8">
                                {{-- <div class="plusminus">
                                    <input type="text" id="niti" name="number" value="{{ $subproduct->cart ? $subproduct->cart->qty : '1' }}">
                                    <div class="minus" data-subprod="{{ $subproduct->id }}" data-prod="{{ $product->id }}"></div>
                                    <div class="plus" data-subprod="{{ $subproduct->id }}" data-prod="{{ $product->id }}"></div>
                                </div> --}}
                                @if ($subproduct->stock > 0)
                                    <select class="changeQtyProduct" data-subprod="{{ $subproduct->id }}" data-prod="{{ $product->id }}">
                                        @for ($i = 1; $i <= $subproduct->stock; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="price">
                                    <span>{{ $subproduct->price - ($subproduct->price * $subproduct->discount / 100) }} lei</span>
                                    <span>{{ $subproduct->price }} lei</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6" style="margin-top: 20px;">
                        <div class="btnDark" data-dismiss="modal">
                            Continue shopping
                        </div>
                    </div>
                    <div class="col-6" style="margin-top: 20px;">
                        <div class="btnLight">
                            <a href="{{ url($lang->lang.'/cart') }}">View Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="modalClick{{ $subproduct->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cumpara in one click</h4>
                <button type="button" class="close" data-dismiss="modal"><img src="{{ asset('fronts/img/icons/closeModalMenu.png') }}" alt=""></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3 modal-image">
                        @if (!is_null($subproduct) && $subproduct->image)
                        <img src="{{ asset('/images/subproducts/'.$subproduct->image ) }}">
                        @else
                        @if ($product->mainImage()->first())
                        <img src="{{ asset('images/products/og/'.$product->mainImage()->first()->src ) }}">
                        @endif
                        @endif
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-12">
                                {{ $product->translationByLanguage($lang->id)->first()->name }}
                            </div>
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <div class="plusminus">
                                    <input type="text" id="niti" name="number" value="1">
                                    <div class="minus"></div>
                                    <div class="plus"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="price">
                                    <span>{{ $subproduct->price - ($subproduct->price * $subproduct->discount / 100) }} lei</span>
                                    <span>{{ $subproduct->price }} lei</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" style="margin: 15px 0;">
                        <div class="oneClickDropOpen">
                          <form id="orderInOneClick">
                              @if(Auth::guard('persons')->check())
                                  <h6>Detalii livrare comanda</h6>
                                  @if (count($userfields) > 0)
                                    <div class="row">
                                      <div class="col-12">
                                        @foreach ($userfields as $key => $userfield)
                                           @if ($userfield->field_group == 'personaldata' && $userfield->type != 'checkbox')
                                            <?php $field = $userfield->field; ?>
                                              <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                              <input type="text" name="{{$field}}" class="form-control" id="usr" value="{{$userdata ? $userdata->$field : old($field)}}">
                                            @endif
                                        @endforeach
                                      </div>
                                    </div>
                                  @endif
                                  @if(count($userdata->addresses()->get()) > 0)
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>{{trans('front.cabinet.myaddresses.address')}}: </label>
                                          <select class="form-control" name="addressMain">
                                              @foreach ($userdata->addresses()->get() as $address)
                                                  <option value="{{$address->id}}">{{$address->addressname}}</option>
                                              @endforeach
                                          </select>
                                        </div>
                                      </div>
                                      @foreach ($userdata->addresses()->get() as $address)
                                          <div class="addressInfo" data-id="{{$address->id}}">
                                              @if (count($userfields) > 0)
                                                <div class="row locationCart">
                                                  @foreach ($userfields as $key => $userfield)
                                                      @if ($userfield->field_group == 'address')
                                                        <?php $field = $userfield->field; ?>
                                                          @if ($userfield->type == 'text')
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                                  <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                                  <input type="{{$userfield->type}}" name="{{$field}}[]" class="name" id="{{$field}}" value="{{!empty($address) ? $address->$field : old($field)}}">
                                                                </div>
                                                              </div>
                                                          @else
                                                              <div class="col-md-4">
                                                                <div class="form-group">
                                                                  <label for="{{$field}}">{{trans('front.cabinet.myaddresses.'.$field)}}: {!!$userfield->required_field == 1 ? '<b>*</b>' : ''!!}</label>
                                                                  <input type="hidden" name="userfield_id[]" value="{{$userfield->id}}">
                                                                  @if ($userfield->field == 'country')
                                                                      <select name="{{$field}}[]" class="name filterCountriesCart" data-id="{{$address->id}}" id="{{$field}}">
                                                                          <option disabled selected>{{trans('front.cabinet.myaddresses.chooseCountry')}}</option>
                                                                          @foreach ($countries as $onecountry)
                                                                              <option {{!empty($address) && $address->country == $onecountry->id ? 'selected' : '' }} value="{{$onecountry->id}}">{{$onecountry->name}}</option>
                                                                          @endforeach
                                                                      </select>
                                                                  @endif

                                                                  @if ($userfield->field == 'region')
                                                                      <select name="{{$field}}[]" class="name filterRegionsCart" data-id="{{$address->id}}" id="{{$field}}">
                                                                          <option disabled selected>{{trans('front.cabinet.myaddresses.chooseRegion')}}</option>
                                                                          @if (!empty($regions))
                                                                              @foreach ($regions as $region)
                                                                                  @foreach ($region as $oneregion)
                                                                                      <option {{!empty($address) && $address->region == $oneregion->id ? 'selected' : '' }} value="{{$oneregion->id}}">{{$oneregion->name}}</option>
                                                                                  @endforeach
                                                                              @endforeach
                                                                          @endif
                                                                      </select>
                                                                  @endif

                                                                  @if ($userfield->field == 'location')
                                                                      <select name="{{$field}}[]" class="name filterCitiesCart" data-id="{{$address->id}}" id="{{$field}}">
                                                                          <option disabled selected>{{trans('front.cabinet.myaddresses.chooseLocation')}}</option>
                                                                          @if (!empty($cities))
                                                                              @foreach ($cities as $city)
                                                                                  @foreach ($city as $onecity)
                                                                                      <option {{!empty($address) && $address->location == $onecity->id ? 'selected' : '' }} value="{{$onecity->id}}">{{$onecity->name}}</option>
                                                                                  @endforeach
                                                                              @endforeach
                                                                          @endif
                                                                      </select>
                                                                  @endif
                                                                </div>
                                                              </div>
                                                          @endif
                                                      @endif
                                                  @endforeach
                                                </div>
                                              @endif
                                          </div>
                                      @endforeach
                                  @endif
                                @endif
                                <h6>{{trans('front.cart.delivery')}}</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="delivery" value="courier" checked>
                                                <div class="lab">{{trans('front.cart.typeDeliveryFirst')}}</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="delivery" value="pickup">
                                                <div class="lab">{{trans('front.cart.typeDeliverySecond')}}</div>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('delivery'))
                                       <div class="invalid-feedback" style="display: block">
                                         {!!$errors->first('delivery')!!}
                                       </div>
                                    @endif
                                </div>
                                <h6>{{trans('front.cart.payment')}}</h6>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="payment" value="card">
                                                <div class="lab">{{trans('front.cart.paymentcard')}}</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="payment" value="paypal">
                                                <div class="lab">{{trans('front.cart.paymentpaypal')}}</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="payment" value="invoice">
                                                <div class="lab">{{trans('front.cart.paymentenumeration')}}</div>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="payment" value="cash" checked>
                                                <div class="lab">{{trans('front.cart.paymentmoney')}}</div>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('payment'))
                                       <div class="invalid-feedback" style="display: block">
                                         {!!$errors->first('payment')!!}
                                       </div>
                                    @endif
                                </div>
                                @if (count($userfields) > 0)
                                    @foreach ($userfields as $key => $userfield)
                                        @if ($userfield->type == 'checkbox')
                                          <h6>{{trans('front.register.'.$userfield->field.'_question')}}</h6>
                                          <p>{{trans('front.register.'.$userfield->field.'_p')}}</p>
                                          <div class="row">
                                              <div class="col-12">
                                                  <div class="form-check">
                                                      <label class="form-check-label">
                                                          <input type="hidden" name="{{$userfield->field}}"  value="">
                                                          <input type="checkbox" class="form-check-input" name="{{$userfield->field}}" value="1">
                                                          <div class="lab">{{trans('front.register.'.$userfield->field.'_checkbox')}}</div>
                                                          @if ($errors->has($userfield->field))
                                                             <div class="invalid-feedback" style="display: block">
                                                               {!!$errors->first($userfield->field)!!}
                                                             </div>
                                                          @endif
                                                      </label>
                                                  </div>
                                              </div>
                                          </div>
                                        @endif
                                    @endforeach
                                @endif
                                <div class="row justify-content-center">
                                    <div class="col-8">
                                        <div class="btnDark">
                                            <input type="submit" value="Trimite Comanda">
                                        </div>
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
@endif
