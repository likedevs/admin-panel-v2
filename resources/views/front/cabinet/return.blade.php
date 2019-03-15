@extends('front.app')
@section('content')
    <div class="wrapp">

    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cabDate">
      <div class="container">

        <div class="row">
          <div class="col-12">
            <h3>Retur</h3>
          </div>
          <div class="col-lg-3 col-md-12">
            <div class="cabCat">
              <div class="sal">
                {{trans('front.ja.hello')}}, {{$userdata->name}}
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
            <div class="row" style="border-bottom: 1px solid #979797;">
              <div class="col-12">
                <h5>{{trans('front.cabinet.returnOrder.return')}} {{$return_amount_days}} {{trans('front.cabinet.returnOrder.days')}}</h5>
              </div>
            </div>
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
                      <div class="offset-2 col-sm-3 col-6">
                        <div class="btnGrey">
                          <a href="{{route('cabinet.returnOrder', $order->id)}}">{{trans('front.cabinet.historyOrder.details')}}</a>
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
