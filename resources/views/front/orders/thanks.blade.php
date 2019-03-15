@extends('front.app')
@section('content')
@include('front.partials.header', ['className' => 'oneHeader'])



<div class="registration comm">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-8 col-sm-10 col-12">
        <div class="row justify-content-center">
          <div class="col-12 comandSucces">
            Thank you {{Auth::guard('persons')->user()->name}}!
          </div>
        </div>
        <div class="row bim">
          <div class="col-12">
            <div class="row justify-content-center blocComm">
              <div class="col-12">
                <h3>A Gift for you!</h3>
              </div>
              <div class="col-md-9 col-12">
                <p>
                    Enter coupon code {{$promocode->name}}
                    when you make your next purchase of {{$promocode->treshold}} euro
                    or more before {{date("j F Y", strtotime($promocode->valid_to))}}, and enjoy {{$promocode->discount}}% off.
                </p>
              </div>
              <div class="col-md-6 col-8">
                <div class="btnComm">
                  <a href="{{url($lang->lang.'/promocode/'.$promocode->id)}}">take {{$promocode->discount}}% off you</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row plscheck justify-content-center">
          <div class="col-12">
            <h5 class="text-center">Please check our new arrivals and promotions</h5>
          </div>
          <div class="col-md-4 col-6">
            <div class="btnComm">
              <a href="{{url($lang->lang.'/catalog/arrival')}}">new arrivals</a>
            </div>
          </div>
          <div class="col-md-4 col-6">
            <div class="btnTransparent">
              <a href="{{url($lang->lang.'/catalog/outlet')}}">go to outlet</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row margeTop2">
      @if (count($collections) > 0)
    <div class="col-12">
      <h3>most popular lifestyle sets</h3>
    </div>
    <div class="col-12">
      <div class="slideMob">


          @foreach ($collections as $collection)
            @foreach ($collection->sets as $set)
            <div class="searchItem">

              <div class="reduceBloc">
                -30%
              </div>
              <div class="searchImg">
                <a href="{{ url('/'.$lang->lang.'/collection/'.$set->collection->first()->alias.'/'.$set->alias) }}">
                    @if ($set->mainPhoto()->first())
                        <img src="{{ asset('/images/sets/og/'.$set->mainPhoto()->first()->src  ) }}">
                    @else
                        <img src="{{ asset('images/default.jpg') }}" alt="img-advice">
                    @endif
                </a>
                <div class="wishBloc">
                  <div class="row justify-content-center">
                    <div class="col-4">
                      <div class="iconWish modalButton4"></div>
                    </div>
                    <div class="col-4">
                      <div class="iconWishCart modalButton3"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="searchFt">
                <div>{{$set->translation($lang->id)->first()->name}}</div>
                <div>
                  <div class="price">
                      @if ($set->discount > 0)
                          <span> {{$set->price_lei - ($set->price_lei * $set->discount / 100)}} euro</span>
                      @endif
                    <span></span>
                  </div>
                </div>
              </div>

            </div>
        @endforeach
        @endforeach

      </div>
    </div>

    @endif
  </div>
</div>

@include('front.partials.footer')
@stop
