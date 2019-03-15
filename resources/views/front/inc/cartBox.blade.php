@php
    $amount = 0;
    $promocodeDiscount = 0;
@endphp
@if (!empty($cartProducts))
    @foreach ($cartProducts as $key => $cartProduct)
        @if ($cartProduct->subproduct_id > 0)
            @if ($cartProduct->subproduct)
                @php $price = $cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100); @endphp
                    @if ($price && ($cartProduct->subproduct->stock > 0))
                        @php $amount +=  $price * $cartProduct->qty; @endphp
                    @endif
            @endif
        @else
            @if ($cartProduct->product)
                @php $price = $cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100); @endphp
                @if ($price && ($cartProduct->product->stock > 0))
                    @php
                        $amount +=  $price * $cartProduct->qty;
                    @endphp
                @endif
            @endif
        @endif
    @endforeach
@endif


@if ($promocode != null)
   @if ($promocode->user_id !== 0)
      @if ($promocode->treshold <= $amount)
            <?php $promocodeDiscount = $promocode->discount?>
      @endif
    @elseif ($promocode->treshold <= $amount)
      <?php $promocodeDiscount = $promocode->discount?>
    @endif
@endif


<div class="row justify-content-end">
    <div class="col-auto">
        <div class="closeModalMenu3"></div>
    </div>
</div>

<div class="row justify-content-center">
<div class="col-12">
    <h6>{{trans('front.ja.cart')}}</h6>
</div>

@if ((count($cartProducts) > 0) || (count($cartSets) > 0))
    <div class="col-12 buttonsScroll">
     <div id="btnTopCart">
     </div>
    </div>
@endif

<div class="col-12">
    <div class="row">
      {{-- Products --}}
      <div class="col-12">
          <div class="row wrappCart">
              <div class="wishScrollBlock col-12">
              @if (count($cartProducts) > 0)
              @foreach ($cartProducts as $key => $cartProduct)
              <div class="cartMenu borderBottom">
                  <div class="row">
                      <div class="col-lg-4 col-md-2 col-4">
                          @if (!is_null($cartProduct->product->mainImage()->first()))
                          {{-- @php $image = getMainProductImage($cartProduct->product_id, $lang->id) @endphp --}}
                          <img src="{{ asset('images/products/sm/'.$cartProduct->product->mainImage()->first()->src) }}">
                          @else
                          <img src="{{ asset('/images/no-image.png') }}" alt="">
                          @endif
                      </div>
                      <div class="col-lg-8 col-md-10 col-8 text-right">
                          <p>
                          <div>
                              {{ $cartProduct->product->translationByLanguage($lang->id)->first()->name }}
                              @if ($cartProduct->subproduct()->first())
                                 - {{ propByCombination($cartProduct->subproduct()->first()->id)[1    ] }}
                              @endif
                          </div>

                          </p>
                          <div>{{ $cartProduct->qty }} x {{ ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100)) }}</div>
                      </div>
                  </div>
              </div>
              @endforeach
              @endif
              {{--  Sets --}}
              @php
              $setAmount = 0;
              @endphp
              @if (count($cartSets) > 0)
              @foreach ($cartSets as $key => $cartSet)
              <div class="cartMenu borderBottom">
                  <div class="row">
                      <div class="col-lg-4 col-md-2 col-4">
                          @if ($cartSet->set()->first())
                          <img src="/images/sets/og/{{ $cartSet->set()->first()->mainPhoto()->first()->src }}" alt="">
                          @else
                          <img src="{{ asset('/images/no-image.png') }}" alt="">
                          @endif
                      </div>
                      <div class="col-lg-8 col-md-10 col-8 text-right">
                          <p>{{ $cartSet->set()->first()->translation($lang->id)->first()->name }}</p>
                          <div>{{ $cartSet->qty }} X {{ $cartSet->price }}</div>
                      </div>
                  </div>
              </div>
              @php
              $setAmount += $cartSet->price * $cartSet->qty;
              @endphp
              @endforeach
              @endif
              @php
              $amount = $amount + $setAmount;
              @endphp
              @if ((count($cartProducts) == 0) && (count($cartSets) == 0))
                  <p class="text-center">{{ trans('front.ja.cartEmpty') }}</p>
              @endif
              </div>
          </div>
      </div>

      @php
         if (!is_null($promocode)){
               if ($promocode->treshold <= $amount){
                   $amount = $amount - ($amount * $promocodeDiscount / 100);
               }
           }
      @endphp
    </div>
</div>




@if ((count($cartProducts) > 0) || (count($cartSets) > 0))
<div class="col-12 buttonsScroll">
 <div id="btnBottomCart">
 </div>
</div>
<div class="col-12">
    <h6 class="text-center totCart">{{trans('front.ja.ammount')}}:
        <span>
            {{ $amount }} Lei
        </span>
    </h6>
</div>
@endif


<div class="col-xl-10 col-lg-10 col-md-12">
<a href="{{ url('/'.$lang->lang.'/cart') }}" class="btnGrey">{{trans('front.ja.gotoCart')}}</a>
</div>
</div>
