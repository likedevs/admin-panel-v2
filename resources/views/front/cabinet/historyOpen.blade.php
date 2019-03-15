@extends('front.app')
@section('content')
    <div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cabDate fullHeight">
      <div class="cabCat bagDate">
        <div class="sal">
          {{trans('front.ja.hello')}}, {{$userdata->name}}
        </div>
        <ul>
          <li><a href="{{route('cabinet')}}">{{trans('front.cabinet.userdata')}}</a></li>
          <li><a href="{{route('cart')}}">{{trans('front.cabinet.cart')}}</a></li>
          <li><a href="{{route('cabinet.wishList')}}">{{trans('front.cabinet.wishList')}}</a></li>
          <li class="pageActiveCab"><a href="{{route('cabinet.history')}}">{{trans('front.cabinet.history')}}</a></li>
          <li><a href="{{route('cabinet.return')}}">{{trans('front.cabinet.return')}}</a></li>
          <li><a href="{{url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a></li>
        </ul>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-12 borderBottom">
            <h3>History</h3>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="cabCat bcg2">
              <div class="sal">
                {{trans('front.ja.hello')}}, {{$userdata->name}}
              </div>
              <ul>
                <li><a href="{{route('cabinet')}}">{{trans('front.cabinet.userdata')}}</a></li>
                <li><a href="{{route('cart')}}">{{trans('front.cabinet.cart')}}</a></li>
                <li><a href="{{route('cabinet.wishList')}}">{{trans('front.cabinet.wishList')}}</a></li>
                <li class="pageActiveCab"><a href="{{route('cabinet.history')}}">{{trans('front.cabinet.history')}}</a></li>
                <li><a href="{{route('cabinet.return')}}">{{trans('front.cabinet.return')}}</a></li>
                <li><a href="{{url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a></li>
              </ul>
            </div>
          </div>
          <div class="col-lg-9 col-md-12 cabFormNew">
            <div class="row borders">
              <div class="col-12">
                <h5>{{trans('front.cabinet.historyOrder.id')}} {{$order->id}}</h5>
              </div>
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
                      @if (!is_null($address))
                          <li>{{$address->value}}</li>
                      @endif
                  @endif
                </ul>
              </div>
              <div class="col-sm-4 col-12">
                <div class="textGreyUp">
                  {{trans('front.cabinet.historyOrder.payment')}}:
                </div>
                <ul>
                  <li>{{trans('front.cabinet.historyOrder.'.$order->payment)}}</li>
                  <li>{{trans('front.cabinet.historyOrder.total')}} {{$order->amount}} lei</li>
                </ul>
              </div>
            </div>
            <div class="row borders">
              <div class="col-12">
                <h5>{{trans('front.cabinet.historyOrder.status')}}</h5>
              </div>
            </div>
            <div class="row borders">
                <div class="col-12">
                  <div class="row padLit">
                    <div class="col-12 emptyBox">
                      <div class="fillBox{{$order->status}}">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3 col-sm-6 col-8 comands">
                  <div class="comandaPlasata {{$order->status == 'pending' ? 'comandaPlasataActive' : 'comandaPlasata'}}">
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
                      <div class="row borders">
                        <div class="col-12">
                          <div class="row oneSetHistory">
                            <div class="historyImgItem col-sm-2 col-3">
                              @if ($orderSet->set()->first())
                              <img src="/images/sets/og/{{ $orderSet->set()->first()->mainPhoto()->first()->src }}" alt="">
                              @else
                              <img src="{{ asset('/images/no-image.png') }}" alt="">
                              @endif
                            </div>
                            <div class="col-lg-7 col-md-5 col-sm-5 col-8 band">
                              <div class="namSetRetur">
                                {{ $orderSet->set->translation($lang->id)->first()->name }}  (<span>One set</span>)
                              </div>
                              <div>
                                Cod produs: <span class="stoc">{{ $orderSet->set->id}}</span>
                              </div>
                            </div>
                            <div class="offset-lg-0 offset-md-2 col-sm-2 col-6 text-right margMobile">
                              <div>
                                {{ $orderSet->set->price }} lei
                              </div>
                              <div class="textGrey">
                                {{ $orderSet->qty }} buc
                              </div>
                            </div>
                            <div class="col-sm-1 col-3 margMobile">
                              <div class="historyCartImg" data-toggle="modal" data-target="#addSetAgainToCart{{$orderSet->id}}">
                                <img src="{{asset('fronts/img/icons/cart.png')}}" alt="">
                              </div>
                            </div>

                            <div class="modal" id="addSetAgainToCart{{$orderSet->id}}">
                              <div class="modal-dialog">
                                <div class="modal-content">

                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">{{trans('front.cabinet.historyOrder.returnCart')}}</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>

                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <div class="row justify-content-center">
                                      <div class="col-9">
                                        <form action="{{route('cabinet.historyCartSet', $orderSet->id)}}" method="post">
                                          {{ csrf_field() }}
                                          <div class="row justify-content-center">
                                            <div class="col-6">
                                              <input type="submit" name="saveChangesCabPers" class="form-control btnDark" value="{{trans('front.cabinet.historyOrder.yes')}}" class="saveChangesCab">
                                            </div>
                                            <div class="col-6">
                                              <div class="btnLight" data-dismiss="modal">
                                                {{trans('front.cabinet.historyOrder.no')}}
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
                            @if (count($orderSet->orderProduct) > 0)
                              @foreach ($orderSet->orderProduct as $orderProduct)
                                <div class="returSetOpen col-12">
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
                                    <div class="offset-md-2 col-sm-2 col-6 text-right margMobile">
                                      <div>
                                        {{$orderProduct->subproduct->price}} lei
                                      </div>
                                      <div class="textGrey">
                                        {{$orderProduct->qty}} buc
                                      </div>
                                    </div>
                                    <div class="col-sm-1 col-3 margMobile">
                                      <div class="historyCartImg" data-toggle="modal" data-target="#addAgainToCart{{$orderProduct->id}}">
                                        <img src="{{asset('fronts/img/icons/cart.png')}}" alt="">
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="modal" id="addAgainToCart{{$orderProduct->id}}">
                                  <div class="modal-dialog">
                                    <div class="modal-content">

                                      <!-- Modal Header -->
                                      <div class="modal-header">
                                        <h4 class="modal-title">{{trans('front.cabinet.historyOrder.returnCart')}}</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>

                                      <!-- Modal body -->
                                      <div class="modal-body">
                                        <div class="row justify-content-center">
                                          <div class="col-9">
                                            <form action="{{route('cabinet.historyCartProduct', $orderProduct->id)}}" method="post">
                                              {{ csrf_field() }}
                                              <div class="row justify-content-center">
                                                <div class="col-6">
                                                  <input type="submit" name="saveChangesCabPers" class="form-control btnDark" value="{{trans('front.cabinet.historyOrder.yes')}}" class="saveChangesCab">
                                                </div>
                                                <div class="col-6">
                                                  <div class="btnLight" data-dismiss="modal">
                                                    {{trans('front.cabinet.historyOrder.no')}}
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
                              @endforeach
                            @endif

                          </div>
                        </div>
                      </div>
                @endforeach
            @endif

            @if (count($order->orderProductsNoSet) > 0)
                @foreach ($order->orderProductsNoSet as $orderProduct)
                    <div class="row borders">
                      <div class="col-12">
                        <div class="row oneItemHistory">
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
                          <div class="offset-md-2 col-sm-2 col-6 text-right margMobile">
                            <div>
                              {{$orderProduct->subproduct->price}} lei
                            </div>
                            <div class="textGrey">
                              {{$orderProduct->qty}} buc
                            </div>
                          </div>
                          <div class="col-sm-1 col-3 margMobile">
                            <div class="historyCartImg" data-toggle="modal" data-target="#addAgainToCart{{$orderProduct->id}}">
                              <img src="{{asset('fronts/img/icons/cart.png')}}" alt="">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal" id="addAgainToCart{{$orderProduct->id}}">
                      <div class="modal-dialog">
                        <div class="modal-content">

                          <!-- Modal Header -->
                          <div class="modal-header">
                            <h4 class="modal-title">{{trans('front.cabinet.historyOrder.returnCart')}}</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>

                          <!-- Modal body -->
                          <div class="modal-body">
                            <div class="row justify-content-center">
                              <div class="col-9">
                                <form action="{{route('cabinet.historyCartProduct', $orderProduct->id)}}" method="post">
                                  {{ csrf_field() }}
                                  <div class="row justify-content-center">
                                    <div class="col-6">
                                      <input type="submit" name="saveChangesCabPers" class="form-control btnDark" value="{{trans('front.cabinet.historyOrder.yes')}}" class="saveChangesCab">
                                    </div>
                                    <div class="col-6">
                                      <div class="btnLight" data-dismiss="modal">
                                        {{trans('front.cabinet.historyOrder.no')}}
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
                {{trans('front.cabinet.historyOrder.total')}}: {{$order->amount}} lei
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
