@php
    $amount = 0;
    $descountTotal = 0;
    $notInStock = false;
    $promocodeDiscount = 0;
    $promocodeEror = true;
    $deliveryPriceEuro = !is_null(getContactInfo('deliveryPriceMdl')) ? getContactInfo('deliveryPriceMdl')->translationByLanguage()->first()->value : 0;
    $thresholdEURO = !is_null(getContactInfo('ThresholdMDl')) ? getContactInfo('ThresholdMDl')->translationByLanguage()->first()->value : 0;
@endphp

@if (!empty($cartProducts))
@foreach ($cartProducts as $key => $cartProduct)

@if ($cartProduct->subproduct_id > 0)
    @if ($cartProduct->subproduct)
        @php $price = $cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100); @endphp
            @if ($price && ($cartProduct->subproduct->stock > 0))
                @php
                $amount +=  $price * $cartProduct->qty;
                $descountTotal += ($cartProduct->subproduct->price_lei -  ($cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100))) * $cartProduct->qty;
                @endphp
            @else
                 @php $notInStock = $cartProduct->subproduct->stock > 0 ? false : true; @endphp
            @endif
        @endif
    @else
        @if ($cartProduct->product)
            @php $price = $cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100); @endphp
            @if ($price  && ($cartProduct->product->stock > 0))
                @php
                $amount +=  $price * $cartProduct->qty;
                $descountTotal += ($cartProduct->product->price_lei -  ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100))) * $cartProduct->qty;
                @endphp
            @else
                 @php $notInStock = $cartProduct->product->stock > 0 ? false : true; @endphp
            @endif
        @endif
    @endif
@endforeach
@endif
@php
    $setAmount = 0;
@endphp

@if ($notInStock == true)
<div class="row justify-content-center">
    <div class="col-sm-11 col-12">
      <div class="alertCos">
        <div class="row justify-content-center">
          <div class="col-sm-11 col-11">
            <h5>{{trans('front.ja.saveInWish')}}</h5>
            <p>
             {{ trans('front.ja.saveInWishText') }}
             <a href="{{ url($lang->lang.'/move/to/favorites') }}" class="btnGrey">Mutați-le la Favoritele</a>
            </p>
          </div>
        </div>
      </div>
    </div>
</div>
@endif

<div class="productsList" style="display: block;">
    <div class="row prodheader">
        <div class="col-md-5">
            {{trans('front.ja.orderProduct')}}
        </div>
        <div class="col-md-2 text-center">
            {{trans('front.ja.pricePerProduct')}}
        </div>
        <div class="col-md-3 text-center">
            {{trans('front.ja.quantity')}}
        </div>
        <div class="col-md-2">
            {{trans('front.ja.amount')}}
        </div>
    </div>
    @if ($errors->has('emptyCart'))
    <div class="invalid-feedback text-center" style="display: block">
        {!!$errors->first('emptyCart')!!}
    </div>
    @endif
    @if (Session::has('success'))
    <div class="valid-feedback text-center" style="display: block">
        {{ Session::get('success') }}
    </div>
    @endif

    {{-- Sets --}}
    @if(count($cartSets) > 0)
    @foreach ($cartSets as $cartSet)
        <div class="row cartUserSet justify-content-center">
         <div class="col-md-5 col-12 nam">
           <div class="row">
             <div class="col-3 cartImg">
                 @if ($cartSet->set()->first())
                 <img src="/images/sets/og/{{ $cartSet->set()->first()->mainPhoto()->first()->src }}" alt="">
                 @else
                 <img src="{{ asset('/images/no-image.png') }}" alt="">
                 @endif
             </div>
             <div class="col-9 namSet">
               <div class="namSetButton" data-toggle="tooltip" data-placement="top" title="{{ trans('front.ja.popupcart') }}" style="padding-right: 30px"><strong>{{ $cartSet->set()->first()->translation($lang->id)->first()->name }}</strong> ({{ trans('front.ja.oneset') }})</div>

             </div>
           </div>
         </div>
         <div class="col-md-7 col-12">
           <div class="row detitemMobile">
             <div class="col-3 dspNoneNikeDesk">

             </div>
             <div class="col-md-3 col-9">
               {{ $cartSet->price }} Lei
             </div>
             <div class="col-3 dspNoneNikeDesk">

             </div>
             <div class="offset-2 col-md-3 col-9">
                 <select class="changeQtySet" data-id="{{ $cartSet->id }}">
                     @for ($i = 1; $i <= $cartSet->qty + 10; $i++)
                         <option value="{{ $i }}" {{ $cartSet->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                     @endfor
                 </select>
             </div>
             <div class="col-3 dspNoneNikeDesk">

             </div>
             <div class="col-md-3 col-9">
               {{ $cartSet->price * $cartSet->qty }} Lei
             </div>
             <div class="col-1">
               <div class="deletItem2 remSetCart" data-id={{ $cartSet->id }}>
                 <img src="{{ asset('fronts/img/icons/closeModal.png') }}" alt="">
               </div>
             </div>
           </div>
         </div>

         <div class="col-11 detSet">
           <div class="row">
             @php
                 $amountProds = 0;
             @endphp
             @if ($cartSet->cart()->get())
                 @foreach ($cartSet->cart()->get() as $key => $cartProduct)
                     @if ($cartProduct->subproduct_id == 0)
                         @php $stock = $cartProduct->product->stock; @endphp
                     @else
                         @php $stock = $cartProduct->subproduct->stock; @endphp
                     @endif
                     <div class="col-12">
                       <div class="row">
                         <div class="col-12">
                           <div class="row">
                             <div class="col-3  cartImg">
                                 @if (!is_null($cartProduct->product->mainImage()->first()))
                                     @php $image = getMainProductImage($cartProduct->product_id, $lang->id) @endphp
                                     <img src="{{ asset('images/products/sm/'.$cartProduct->product->mainImage()->first()->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="cartImg">
                                 @else
                                     <img src="{{ asset('/images/no-image.png') }}" alt="">
                                 @endif
                             </div>
                             <div class="col-9 namSet">
                               <div><strong>{{ $cartProduct->product->translationByLanguage($lang->id)->first()->name }}</strong> ({{ trans('front.ja.oneproduct') }})</div>
                               <div>
                                   @if ($cartProduct->subproduct_id > 0)
                                   <div>{{trans('front.cart.stock')}}: <b class="stoc">{{ $cartProduct->subproduct->stock > 0 ? 'in stoc ' : 'nu e in stoc' }}</b></div>
                                   <div>{{trans('front.cart.cod')}}: <b>{{ $cartProduct->subproduct->code }}</b></div>
                                   @else
                                   <div>{{trans('front.cart.stock')}}: <b class="stoc">{{ $cartProduct->product->stock > 0 ? 'in stoc ' : 'nu e in stoc' }} stoc</b></div>
                                   <div>{{trans('front.cart.cod')}}: <b>{{ $cartProduct->product->code }}</b></div>
                                   @endif
                               </div>
                             </div>
                           </div>
                         </div>
                         <div class="col-12">
                           <div class="row detitemMobile">
                             <div class="col-3 dspNoneNikeDesk">

                             </div>
                             <div class="col-9">
                                 @if ($stock > 0)
                                     @if ($cartProduct->subproduct_id > 0)
                                     {{ ($cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100)) }} Lei
                                     @php $amountProds +=  $cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100) @endphp
                                     @else
                                     {{ ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100)) }} Lei
                                     @php $amountProds +=  $cartProduct->product->actual_price_lei @endphp
                                     @endif
                                 @endif
                             </div>
                             <div class="offset-2 col-md-3 col-8 bd text-center">

                             </div>
                             <div class="col-md-3 col-9 text-right">
                                 {{-- @if ($stock > 0)
                                     @if ($cartProduct->subproduct_id > 0)
                                     {{ ($cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100)) * $cartProduct->qty}} Lei
                                     @else
                                     {{ ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100)) * $cartProduct->qty}} Lei
                                     @endif
                                 @endif --}}
                             </div>
                             <div class="col-1 text-right">
                               <div class="deletItem3">
                                 {{-- <img src="{{ asset('fronts/img/icons/closeModal.png') }}"> --}}
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                 @endforeach
             @endif

             <div class="col-12">
               <div class="row fwb">
                 <div class="col-md-5 col-8">
                  {{trans('front.ja.amoutArticles')}}
                 </div>
                 <div class="col-md-7 col-4">
                   <div class="row">
                     <div class="offset-8 col-md-3 col-12 text-right">
                         {{ $amountProds }} Lei
                     </div>
                   </div>
                 </div>
               </div>
             </div>
             <div class="col-12">
               <div class="row fwb">
                 <div class="col-md-5 col-8">
                   {{trans('front.ja.price')}} {{ $cartSet->set()->first()->translation($lang->id)->first()->name }}
                 </div>
                 <div class="col-md-7 col-4">
                   <div class="row">
                     <div class="offset-8 col-md-3 col-12 text-right">
                       {{ $cartSet->price }} Lei
                       @php
                           $setAmount +=  $cartSet->price * $cartSet->qty;
                       @endphp
                     </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>
       </div>
    @endforeach
    @endif

    {{-- Products --}}
    @if(count($cartProducts) > 0)
    @foreach ($cartProducts as $cartProduct)

        @if ($cartProduct->subproduct_id == 0)
            @php $stock = $cartProduct->product->stock; @endphp
        @else
            @php $stock = $cartProduct->subproduct->stock; @endphp
        @endif

        <div class="row cartUserItem">
            <div class="col-md-5 col-12">
                <div class="row">
                    <div class="col-3 cartImg">
                        {!! $stock == 0 ? '<del>' : '' !!}
                            @if (getMainProductImage($cartProduct->product_id, $lang->id))
                                @php $image = getMainProductImage($cartProduct->product_id, $lang->id) @endphp
                                <img src="{{ asset('images/products/sm/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="cartImg">
                            @else
                                <img src="{{ asset('/images/no-image.png') }}" alt="">
                            @endif
                        {!! $stock == 0 ? '</del>' : '' !!}
                    </div>
                    <div class="col-9 namSet">
                        <div><strong>@if ($stock > 0)
                            {{ $cartProduct->product->translationByLanguage($lang->id)->first()->name }}
                        @else
                            <del>
                                {{ $cartProduct->product->translationByLanguage($lang->id)->first()->name }}
                            </del>
                        @endif</strong> ({{ trans('front.ja.oneproduct') }})</div>
                        <div class="">
                            @if ($cartProduct->subproduct_id > 0)
                            <div>{{trans('front.cart.stock')}}: <b class="stoc">{{ $cartProduct->subproduct->stock > 0 ? 'in stoc' : 'ne e in stoc' }} </b></div>
                            <div>{{trans('front.cart.cod')}}: <b>{{ $cartProduct->subproduct->code }}</b></div>
                            @else
                            <div>{{trans('front.cart.stock')}}: <b class="stoc">{{ $cartProduct->product->stock > 0 ? 'in stoc' : 'ne e in stoc' }} </b></div>
                            <div>{{trans('front.cart.cod')}}: <b>{{ $cartProduct->product->code }}</b></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-12">
                <div class="row detitemMobile">
                    <div class="col-md-3 col-9 text-center">
                        @if ($stock > 0)
                            @if ($cartProduct->subproduct_id > 0)
                            {{ ($cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100)) }} Lei
                            @else
                            {{ ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100)) }} Lei
                            @endif
                        @endif
                    </div>
                    <div class="offset-md-2 offset-0 col-md-3 offset-3 col-6 text-right">
                        @if ($stock > 0)
                            <select class="changeQty" data-id="{{ $cartProduct->id }}">
                                @for ($i = 1; $i <= $stock; $i++)
                                    <option value="{{ $i }}" {{ $cartProduct->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        @endif
                    </div>
                    <div class="col-md-3 col-9 text-center">
                        @if ($stock > 0)
                            @if ($cartProduct->subproduct_id > 0)
                            {{ ($cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100)) * $cartProduct->qty}} Lei
                            @else
                            {{ ($cartProduct->product->price_lei - ($cartProduct->product->price_lei * $cartProduct->product->discount / 100)) * $cartProduct->qty}} Lei
                            @endif
                        @endif
                    </div>
                    <div class="col-md-1 col-sm-2 col-2 posAbsoluteX">
                        <div class="deletItem remItemCart" data-id="{{ $cartProduct->id }}">
                            <img src="{{ asset('fronts/img/icons/closeModal.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endforeach
@endif
</div>

<div class="row promo1CodCart align-items-center justify-content-center">
      <div class="col-md-3 col-6">
        @php
            $amount = $amount + $setAmount;
        @endphp
    </div>

    <div class="col-12" style="display: {{ !is_null($promocode) ? 'none' : 'block' }} ;">
        <div class="row">
            <div class="col-12">
                @if ((count($cartProducts) > 0) || (count($cartSets) > 0))
                    <a href="#" id="remAllItems"><img src="/fronts/img/icons/closeModal.png" alt=""> {{ trans('front.ja.deleteAllCart') }}</a>
                @endif
            </div>
            <div class="col-12 text-right promoCodeInfo">
                 <span class="invalid-feedback text-left" style="display: none; margin-right: 20%;">{{ trans('front.ja.promoCodeNotValid') }}  </span>
                 {{trans('front.ja.havePromocode')}} <span style="margin-left: 22%; text-decoration: underline;">{{ trans('front.ja.addHere') }}:</span></div>
            <div class="col-md-9 col-12">
               <input type="text" id="codPromo" class="codPromo" name="codPromo" placeholder="{{ trans('front.ja.addVoucher') }}"  value="{{ !is_null($promocode) ? $promocode->name : Session::get('promocode') }}">
            </div>
            <div class="col-md-3 col-12">
               <div class="btnGrey promocodeAction">
                  {{trans('front.ja.applyDiscount')}}
               </div>
            </div>
        </div>
    </div>

     <div class="col-12" style="display: {{ !is_null($promocode) ? 'block' : 'none' }} ;">
         <div class="row justify-content-end">
             <div class="col-md-6 col-12 promoBlock" style="display: block;">
                 <h5>Promo code <span>{{ !is_null($promocode) ? $promocode->name : Session::get('promocode') }}</span> </h5>
                 <p>
                     @if ($promocode != null)
                        @if ($promocode->user_id !== 0)
                           @if (is_null($userdata))
                             <div class="invalid-feedback_ text-center"  style="display: block">
                                 {{trans('front.cart.loginUsePromo')}}
                             </div>
                           @elseif( ($promocode->user_id !== $userdata->id))
                             <div class="invalid-feedback_ text-center"  style="display: block">
                                 {{trans('front.cart.anotherPromo')}}
                             </div>
                           @elseif ($promocode->treshold <= $amount)
                               <div class="invalid-feedback_ text-center"  style="display: block">
                                   - {{ $promocode->discount }}% {{trans('front.cart.withPromo')}}, {{ trans('front.ja.atiEconomisit') }} {{ $amount - ($amount - ($amount * $promocode->discount / 100)) }} lei
                                   <?php
                                        $promocodeDiscount = $promocode->discount;
                                        $promocodeEror = false;
                                   ?>
                               </div>
                           @else
                               <div class="invalid-feedback_ text-center"  style="display: block">
                                   {{trans('front.cart.promoCommand')}} > {{ $promocode->treshold }} {{trans('front.cart.currency')}}.
                               </div>
                           @endif
                       @elseif ($promocode->treshold <= $amount)
                           <div class="invalid-feedback_ text-center"  style="display: block">
                               - {{ $promocode->discount }}% {{trans('front.cart.withPromo')}},{{ trans('front.ja.atiEconomisit') }} {{ $amount - ($amount - ($amount * $promocode->discount / 100)) }} lei
                               <?php
                                    $promocodeDiscount = $promocode->discount;
                                    $promocodeEror = false;
                               ?>
                           </div>
                       @else
                           <div class="invalid-feedback_ text-center"  style="display: block">
                               {{trans('front.cart.promoCommand')}} {{ $promocode->treshold }} {{trans('front.cart.currency')}}.
                           </div>
                        @endif
                    @else
                        @if (Session::get('promocode'))
                            <div class="invalid-feedback_ text-center"  style="display: block">
                                {{trans('front.cart.promoError')}}
                            </div>
                        @endif
                    @endif
                 </p>
                 <div class="promoBtn">
                         @if ($promocodeEror == false)
                             <div>{{ trans('front.ja.aplied') }} <span  data-toggle="modal" data-target="#promoModal">{{ trans('front.ja.details') }}</span></div>
                         @else
                              <div>{{ trans('front.ja.eror') }}</div>
                         @endif
                     <div class="removePromoCode">
                          {{ trans('front.ja.insertNew') }}
                     </div>
                 </div>
             </div>
         </div>
     </div>

     @php
        if (!is_null($promocode)){
              if ($promocode->treshold <= $amount){
                  $amount = $amount - ($amount * $promocodeDiscount / 100);
              }
          }

          if ($thresholdEURO < $amount) {
              $deliveryPriceEuro = 0;
          }
     @endphp

     <div class="col-12 marginTop">
        <div class="row">
           <div class="col-md-9 col-8 text-right">{{trans('front.ja.amountProducts')}}:</div>
           <div class="col-md-3 col-4 text-right">{{ $descountTotal + $amount }} Lei</div>
        </div>
     </div>
     <div class="col-12">
        <div class="row">
           <div class="col-md-9 col-8 text-right">{{trans('front.ja.shipingRates')}}:</div>
           <div class="col-md-3 col-4 text-right">{{ $deliveryPriceEuro }} Lei</div>
        </div>
     </div>
     <div class="col-12">
        <div class="row ">
           <div class="col-md-9 col-8 text-right fwb">{{trans('front.ja.amount')}}:</div>
           <div class="col-md-3 col-4 text-right fwb">{{ $descountTotal + $amount + $deliveryPriceEuro}} Lei</div>
        </div>
    </div>
</div>

@if ($promocodeEror == false)
<div class="modal" id="promoModal">
    <div class="modal-dialog">
        <div class="modal-content regBox">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" style="padding-top: 10px; ">
                <div class="regBox">
                    Promo Code: "{{ $promocode->name }}", {{ trans('front.ja.withDiscount') }}: {{ $promocode->discount }}%,
                    {{ trans('front.ja.validFrom') }} {{ $promocode->valid_from }} {{ trans('front.ja.to') }} {{ $promocode->valid_to }}, {{ trans('front.ja.forNextPurchaseOf') }} {{ $promocode->treshold }} lei {{ trans("front.ja.orMore") }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endif
