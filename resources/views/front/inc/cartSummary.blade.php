@php
      $setAmount = 0;
      $amount = 0;
      $promocodeDicount = @$_COOKIE['promocode'];
      $promocodeDiscount = 0;
      $deliveryPriceEuro = !is_null(getContactInfo('deliveryPriceMdl')) ? getContactInfo('deliveryPriceMdl')->translationByLanguage()->first()->value : 0;
      $thresholdEURO = !is_null(getContactInfo('ThresholdMDl')) ? getContactInfo('ThresholdMDl')->translationByLanguage()->first()->value : 0;
      $phone = !is_null(getContactInfo('phone')->translation($lang->id)) ? getContactInfo('phone')->translation($lang->id)->value : '';

@endphp

@if (!empty($cartProducts))
    @foreach ($cartProducts as $key => $cartProduct)

        @if ($cartProduct->subproduct_id > 0)
            @if ($cartProduct->subproduct)
                @php $price = $cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100); @endphp
                @if ($price && ($cartProduct->subproduct->stock > 0))
                    @php
                        $amount +=  $price * $cartProduct->qty;
                    @endphp
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

@if(count($cartSets) > 0)
@foreach ($cartSets as $cartSet)
    {{-- @if ($cartSet->cart()->get())
        @foreach ($cartSet->cart()->get() as $key => $cartProduct) --}}
            @php
                $setAmount += $cartSet->price * $cartSet->qty
            @endphp
        {{-- @endforeach
    @endif --}}
@endforeach
@endif

    {{-- {{ dd($setAmount) }} --}}
@php
    $amount = $amount + $setAmount;
@endphp

@if ($promocode != null)
   @if ($promocode->user_id !== 0)
      @if ($promocode->treshold <= $amount)
            <?php $promocodeDiscount = $promocode->discount?>
      @endif
    @elseif ($promocode->treshold <= $amount)
      <?php $promocodeDiscount = $promocode->discount?>
    @endif
@endif

@php

      if ($thresholdEURO < $amount) {
          $deliveryPriceEuro = 0;
      }

@endphp

<div class="bcgFixed">
  <h6>{{ trans('front.ja.summarOrder') }}</h6>
  <ul>
      @if (!is_null($promocode))
          @if ($promocode->treshold <= $amount)
              <li>{{trans('front.cart.product')}}: <b>{{ ($amount - ($amount * $promocode->discount / 100)) }} Lei</b></li>
              <li>{{trans('front.cart.delivery')}}: <b>{{ $deliveryPriceEuro }} Lei</b></li>
              <li><b>{{trans('front.cart.total')}}: {{ ($amount - ($amount * $promocode->discount / 100) + $deliveryPriceEuro) }} Lei</b></li>
          @else
              <li>{{trans('front.cart.product')}}: <b>{{ $amount }} Lei</b></li>
              <li>{{trans('front.cart.delivery')}}: <b>{{ $deliveryPriceEuro }} Lei</b></li>
              <li><b>{{trans('front.cart.total')}}: {{ $amount + $deliveryPriceEuro }} Lei</b></li>
          @endif
      @else
          <li>{{trans('front.cart.product')}}: <b>{{ $amount }} Lei</b></li>
          <li>{{trans('front.cart.delivery')}}: <b>{{ $deliveryPriceEuro }} Lei</b></li>
          <li><b>{{trans('front.cart.total')}}: {{ $amount + $deliveryPriceEuro }} Lei</b></li>
      @endif
  </ul>
</div>
<input type="text" value="{{ $phone }}" style="text-align: center;width: 100%; margin: 10px 0; font-weight: bold;" readonly>
<div class="btnGrey" style="margin: 0;">
  <input type="submit" value="{{trans('front.ja.order')}}">
</div>
