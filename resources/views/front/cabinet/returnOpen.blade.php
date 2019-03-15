@extends('front.app')
@section('content')
<div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cabDate">
      <div class="container">
        <div class="row">
          <div class="col-12" style="border-bottom: 1px solid #979797;">
            <h3>{{trans('front.cabinet.cabinet')}}</h3>
          </div>
          <div class="col-lg-3 col-md-12" style="margin-top: 10px;">
            <div class="cabCat">
              <div class="sal">
                {{trans('front.cabinet.welcome')}}, {{$userdata->name}}
              </div>
              <ul>
                <li><a href="{{route('cabinet')}}">{{trans('front.cabinet.userdata')}}</a></li>
                <li><a href="{{route('cart')}}">{{trans('front.cabinet.cart')}}</a></li>
                <li><a href="{{route('cabinet.wishList')}}">{{trans('front.cabinet.wishList')}}</a></li>
                <li><a href="{{route('cabinet.history')}}">{{trans('front.cabinet.history')}}</a></li>
                <li class="pageActiveCab"><a href="{{route('cabinet.return')}}">{{trans('front.cabinet.return')}}</a></li>
                <li><a href="{{url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-9 col-md-12 cabFormNew" style="margin-top: 10px;">
            <div class="row borders">
              <div class="col-12">
                <h5>{{trans('front.cabinet.historyOrder.id')}} {{$order->id}}</h5>
              </div>

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
            <div class="row borders">
              <div class="col-12 textGrey">
                {{trans('front.cabinet.historyOrder.id')}} {{$order->id}}: {{trans('front.cabinet.historyOrder.'.$order->secondarystatus)}}
              </div>
            </div>
            <div class="row borders">
              <div class="col-sm-4 col-12">
                <div class="textGreyUp">
                  {{trans('front.cabinet.historyOrder.userdata')}}:
                </div>
                <ul>
                  <li>{{$userdata->name}} {{$userdata->surname}}</li>
                  <li>{{$userdata->phone.','}} {{$userdata->email}}</li>
                </ul>
              </div>
              <div class="col-sm-4 col-12">
                <div class="textGreyUp">
                  {{trans('front.cabinet.historyOrder.addressdata')}}:
                </div>
                <ul>
                    @if (count($order->addressById()->first()) > 0)
                        <?php $address = $order->addressById()->first(); ?>
                        <li>  {{$address->getCountryById()->first() ? $address->getCountryById()->first()->name.',' : ''}}
                              {{$address->getRegionById()->first() ? $address->getRegionById()->first()->name.',' : ''}}
                              {{$address->getCityById()->first() ? $address->getCityById()->first()->name.',' : ''}}
                              {{$address->address}}</li>
                    @else
                        <?php $address = $order->addressPickupById()->first(); ?>
                        <li>{{$address->value}}</li>
                    @endif
                </ul>
              </div>
              <div class="col-sm-4 col-12">
                <div class="textGreyUp">
                  {{trans('front.cabinet.historyOrder.payment')}}:
                </div>
                <ul>
                  <li>{{trans('front.cabinet.historyOrder.'.$order->payment)}}</li>
                  <li>{{trans('front.cabinet.historyOrder.total')}} {{$order->amount}} euro</li>
                </ul>
              </div>
            </div>
            <div class="row borders">
              <div class="col-12">
                <h5>{{trans('front.cabinet.historyOrder.status')}}</h5>
              </div>
            </div>
            <div class="row borders">
              <div class="col-12 emptyBox">
                <div class="fillBox{{$order->status}}">
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-8 comands">
                <div class="{{$order->status == 'pending' ? 'comandaPlasataActive' : 'comandaPlasata'}}">
                  25% <br><strong>{{trans('front.cabinet.historyOrder.pending')}}</strong>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-8 comands">
                <div class="{{$order->status == 'processing' ? 'comandaInProcesareActive' : 'comandaInProcesare'}}">
                  50% <br><strong>{{trans('front.cabinet.historyOrder.processing')}}</strong>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-8 comands">
                <div class="{{$order->status == 'inway' ? 'comandaInLivrareActive' : 'comandaInLivrare'}}">
                  75% <br><strong>{{trans('front.cabinet.historyOrder.inway')}}</strong>
                </div>
              </div>
              <div class="col-md-3 col-sm-6 col-8 comands">
                <div class="{{$order->status == 'completed' ? 'comandaLivrataActive' : 'comandaLivrata'}}">
                  100% <br><strong>{{trans('front.cabinet.historyOrder.completed')}}</strong>
                </div>
              </div>
            </div>
            <div class="row borders">
              <div class="col-12">
                <h5>{{trans('front.cabinet.historyOrder.products')}}</h5>
              </div>
            </div>

            @if (count($order->orderSets) > 0)
                @foreach ($order->orderSets as $orderSet)
                  <div class="row borders justify-content-center">
                    <div class="historyImgItem col-sm-2 col-3">
                      @if ($orderSet->set()->first())
                      <img src="/images/sets/og/{{ $orderSet->set()->first()->mainPhoto()->first()->src }}" alt="">
                      @else
                      <img src="{{ asset('/images/no-image.png') }}" alt="">
                      @endif
                    </div>
                    <div class="col-sm-5 col-8 band">
                      <div class="namSetRetur">
                        {{ $orderSet->set->translation($lang->id)->first()->name }}  (<span>One set</span>)
                      </div>
                      <div>
                        Cod produs: <span class="stoc">{{ $orderSet->set->id}}</span>
                      </div>
                    </div>
                    <div class=" col-sm-2 col-6 text-right">
                      <div>
                        {{ $orderSet->set->price }} euro
                      </div>
                      <div class="textGrey">
                        {{ $orderSet->qty }} buc
                      </div>
                    </div>
                    <div class="col-sm-3 col-6 margMobile text-right">
                      <form action="{{route('cabinet.addSetsToReturn', $orderSet->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="return_id" value="{{count($return) > 0 ? $return->id : '0'}}">
                        <input type="hidden" name="returnOrder" value="0">
                        <div>
                          <form action="{{route('cabinet.addSetsToReturn', $orderSet->id)}}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" name="return_id" value="{{count($return) > 0 ? $return->id : '0'}}">
                            <input type="hidden" name="returnOrder" value="0">
                            <div>
                              <label class="containerCheck">Retur
                                @if (count($return) > 0)
                                    <input {{count($return->returnSets) > 0 && $return->returnSets->contains('return_id', $return->id) ? 'checked' : ''}} type="checkbox" onclick="addReturn(this)" name="returnOrder" value="1">
                                @else
                                    <input type="checkbox" onclick="addReturn(this)" name="returnOrder" value="1">
                                @endif
                                <span class="checkmarkCheck"></span>
                              </label>
                            </div>
                          </form>
                        </div>
                      </form>
                    </div>
                    <div class="returSetOpen col-10">

                      @if (count($orderSet->orderProduct) > 0)
                        @foreach ($orderSet->orderProduct as $orderProduct)
                          <div class="row returItemSet">
                            <div class="historyImgItem col-sm-2 col-3">
                              @if (getMainProductImage($orderProduct->product_id, $lang->id))
                               @php $image = getMainProductImage($orderProduct->product_id, $lang->id) @endphp
                               <img src="{{ asset('images/products/sm/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="itemImg">
                              @else
                               <img src="{{ asset('images/no-image.png') }}" alt="">
                              @endif
                            </div>
                            <div class="col-sm-5 col-8">
                              <div>
                                {{$orderProduct->product->translationByLanguage($lang->id)->first()->name}} (<span>One product</span>)
                              </div>
                              <div>
                                Cod produs: <span class="stoc">{{$orderProduct->subproduct->code}}</span>
                              </div>
                            </div>
                            <div class=" col-sm-2 col-6 text-right">
                              <div>
                                {{$orderProduct->subproduct->price}} euro
                              </div>
                              <div class="textGrey">
                                {{$orderProduct->qty}} buc
                              </div>
                            </div>
                            <div class="col-sm-3 col-6 margMobile text-right">
                              <form action="{{route('cabinet.addProductsToReturn', $orderProduct->id)}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="return_id" value="{{count($return) > 0 ? $return->id : '0'}}">
                                <input type="hidden" name="returnOrder" value="0">
                                <div>
                                  <label class="containerCheck">Retur
                                    @if (count($return) > 0)
                                        <input {{count($return->returnProducts()->get()) > 0 && $return->returnProducts()->get()->contains('orderProduct_id', $orderProduct->id) ? 'checked' : ''}} type="checkbox" onclick="addReturn(this)" name="returnOrder" value="1">
                                    @else
                                        <input type="checkbox" onclick="addReturn(this)" name="returnOrder" value="1">
                                    @endif
                                    <span class="checkmarkCheck"></span>
                                  </label>
                                </div>
                              </form>
                            </div>
                          </div>
                        @endforeach
                      @endif
                    </div>
                  </div>
                @endforeach
            @endif

            @if (count($order->orderProductsNoSet) > 0)
                @foreach ($order->orderProductsNoSet as $orderProduct)
                  <div class="row borders">
                    <div class="historyImgItem col-sm-2 col-3">
                      @if (getMainProductImage($orderProduct->product_id, $lang->id))
                       @php $image = getMainProductImage($orderProduct->product_id, $lang->id) @endphp
                       <img src="{{ asset('images/products/sm/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="itemImg">
                      @else
                       <img src="{{ asset('images/no-image.png') }}" alt="">
                      @endif
                    </div>
                    <div class="col-sm-5 col-8">
                      <div>
                        {{$orderProduct->product->translationByLanguage($lang->id)->first()->name}} (<span>One product</span>)
                      </div>
                      <div>
                        Cod produs: <span class="stoc">{{$orderProduct->subproduct->code}}</span>
                      </div>
                    </div>
                    <div class=" col-sm-2 col-6 text-right">
                      <div>
                        {{$orderProduct->subproduct->price}} euro
                      </div>
                      <div class="textGrey">
                        {{$orderProduct->qty}} buc
                      </div>
                    </div>
                    <div class="col-sm-3 col-6 margMobile text-right">
                      <form action="{{route('cabinet.addProductsToReturn', $orderProduct->id)}}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="return_id" value="{{count($return) > 0 ? $return->id : '0'}}">
                        <input type="hidden" name="returnOrder" value="0">
                        <div>
                          <label class="containerCheck">Retur
                            @if (count($return) > 0)
                                <input {{count($return->returnProducts()->get()) > 0 && $return->returnProducts()->get()->contains('orderProduct_id', $orderProduct->id) ? 'checked' : ''}} type="checkbox" onclick="addReturn(this)" name="returnOrder" value="1">
                            @else
                                <input type="checkbox" onclick="addReturn(this)" name="returnOrder" value="1">
                            @endif
                            <span class="checkmarkCheck" ></span>
                          </label>
                        </div>
                      </form>
                    </div>
                  </div>
                @endforeach
            @endif

            <div class="row totalHistoryOpen">
              <div class="col-12">
                {{trans('front.cabinet.historyOrder.delivery')}} ({{trans('front.cabinet.historyOrder.'.$order->delivery)}}): {{trans('front.cabinet.historyOrder.free')}}
              </div>
              <div class="col-12">
                {{trans('front.cabinet.historyOrder.payment')}} ({{trans('front.cabinet.historyOrder.'.$order->payment)}}): {{trans('front.cabinet.historyOrder.free')}}
              </div>
              <div class="col-12">
                {{trans('front.cabinet.historyOrder.total')}}: {{$order->amount}} euro
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <h4>{{trans('front.cabinet.returnOrder.returnData')}}:</h4>
                <form action="{{route('cabinet.saveReturn', count($return) > 0 ? $return->id : '0')}}" method="post">
                  {{ csrf_field() }}
                  <div class="row">
                    <div class="col-12">
                      <textarea rows="4" cols="50" name="motive" placeholder="{{trans('front.cabinet.returnOrder.motive')}}:">{{count($return) > 0 ? $return->motive: ''}}</textarea>
                    </div>
                    <div class="col-12 margeTop2">
                      <h4>Metoda returnarii</h4></div>
                    <div class="col-sm-6 col-12 selRetur">
                      <select>
                        <option {{!empty($return) && $return->payment == 'card' ? 'selected' : ''}} value="card">{{trans('front.cabinet.returnOrder.card')}}</option>
                        <option {{!empty($return) && $return->payment == 'paypal' ? 'selected' : ''}} value="paypal">{{trans('front.cabinet.returnOrder.paypal')}}</option>
                        <option {{!empty($return) && $return->payment == 'invoice' ? 'selected' : ''}} value="invoice">{{trans('front.cabinet.returnOrder.invoice')}}</option>
                        <option {{!empty($return) && $return->payment == 'cash' ? 'selected' : ''}} value="cash">{{trans('front.cabinet.returnOrder.cash')}}</option>
                        <option {{!empty($return) && $return->payment == 'goods' ? 'selected' : ''}} value="goods">{{trans('front.cabinet.returnOrder.goods')}}</option>
                      </select>
                    </div>
                    <div class="col-12">
                      <div class="row justify-content-end">
                        <div class="col-lg-4 col-md-5 col-sm-6 col-7">
                          <div class="btnGrey">
                            <input type="submit" value="{{trans('front.cabinet.returnOrder.returnBtn')}}">
                          </div>
                        </div>
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
    @include('front.partials.footer')
</div>
@stop
