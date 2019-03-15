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
            @if (count($orders) > 0)
                @foreach ($orders as $order)
                  <div class="row align-items-center historyItem">
                    <div class="col-sm-7 col-12">
                      <div class="row align-items-center">
                        <div class="col-5 textGrey">
                          {{trans('front.cabinet.historyOrder.id')}} {{$order->id}}
                        </div>
                        <div class="col-7 {{$order->status}}">
                          {{trans('front.cabinet.historyOrder.'.$order->status)}}
                        </div>
                        <div class="col-12">
                          {{trans('front.cabinet.historyOrder.date')}}: {{date('d m Y H:i:s', strtotime($order->datetime))}},
                          <br>
                          {{trans('front.cabinet.historyOrder.total')}}: <strong>{{$order->amount}} lei </strong>
                        </div>
                      </div>
                    </div>
                    <div class="offset-1 col-sm-1 col-3">
                      <div class="historyCartImg" data-toggle="modal" data-target="#addAgainToCart{{$order->id}}">
                        <img src="{{asset('fronts/img/icons/cart.png')}}" alt="">
                      </div>
                      <div class="modal" id="addAgainToCart{{$order->id}}">
                        <div class="modal-dialog">
                          <div class="modal-content">

                            <!-- Modal Header -->
                            <div class="modal-header">
                              <h4 class="modal-title">Add this order again to cart</h4>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>

                            <!-- Modal body -->
                            <div class="modal-body">
                              <div class="row justify-content-center">
                                <div class="col-9">
                                  <form action="{{route('cabinet.historyCart', $order->id)}}" method="post">
                                    {{ csrf_field() }}
                                    <div class="row justify-content-center">
                                      <div class="col-6">
                                        <div class="btnGrey">
                                          <input type="submit" name="saveChangesCabPers" value="Yes">
                                        </div>
                                      </div>
                                      <div class="col-6">
                                        <div class="btnBrun" data-dismiss="modal">
                                          No
                                        </div>
                                      </div>
                                      <div class="col-12">
                                        <div class="btnTransparent">
                                          Yes and Go to Cart
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
                    <div class="col-sm-3 col-6">
                      <div class="btnGrey">
                        <a href="{{route('cabinet.historyOrder', $order->id)}}">{{trans('front.cabinet.historyOrder.details')}}</a>
                      </div>
                    </div>
                  </div>
                @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
