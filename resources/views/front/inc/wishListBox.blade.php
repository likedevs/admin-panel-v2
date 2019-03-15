<div class="row justify-content-end">
    <div class="col-auto">
        <div class="closeModalMenu5"></div>
    </div>
</div>
<div class="row justify-content-center">
    <div class="col-12">
        <h6>Wish List</h6>
    </div>

    @if ((count($wishListProducts) > 0) || count($wishListSets) > 0)
        <div class="col-12 buttonsScroll">
         <div id="btnTopWish">

         </div>
        </div>
    @endif

    <div class="col-12">
      <div class="row wrappCart">
        <div class="wishScrollBlock col-12">
            @if (count($wishListProducts) > 0)
                @foreach ($wishListProducts as $wishListProduct)
                            <div class="cartMenu borderBottom">
                                <div class="row">
                                    <div class="col-lg-4 col-md-2 col-4">
                                        @if (!is_null($wishListProduct->product->mainImage()->first()))
                                          {{-- @php $image = getMainProductImage($wishListProduct->product_id, $lang->id) @endphp --}}
                                          <img src="{{ asset('images/products/sm/'.$wishListProduct->product->mainImage()->first()->src) }}">
                                        @else
                                          <img src="{{ asset('/images/no-image.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="col-lg-8 col-md-10 col-8 text-right">
                                        <p>{{ $wishListProduct->product->translationByLanguage($lang->id)->first()->name }}</p>
                                        <div>1 x {{ ($wishListProduct->product->price_lei - ($wishListProduct->product->price_lei * $wishListProduct->product->discount / 100)) }}</div>
                                    </div>
                                </div>
                            </div>
                @endforeach
            @endif

            @if (count($wishListSets) > 0)
                @foreach ($wishListSets as $wishListSet)
                        <div class="cartMenu borderBottom">
                            <div class="row">
                                <div class="col-lg-4 col-md-2 col-4">
                                    @if ($wishListSet->set()->first())
                                    <img src="/images/sets/og/{{ $wishListSet->set()->first()->mainPhoto()->first()->src }}" alt="">
                                    @else
                                    <img src="{{ asset('/images/no-image.png') }}" alt="">
                                    @endif
                                </div>
                                <div class="col-lg-8 col-md-10 col-8 text-right">
                                    <p>{{ $wishListSet->set()->first()->translation($lang->id)->first()->name }}</p>
                                    <div>1 X {{ $wishListSet->set()->first()->price_lei }}</div>
                                </div>
                            </div>
                        </div>
                @endforeach
            @endif

            @if ((count($wishListProducts) == 0) && (count($wishListSets) == 0))
                <p class="text-center">{{ trans('front.ja.wishlistEmpty') }}</p>
            @endif
        </div>
      </div>
    </div>

    @if ((count($wishListProducts) > 0) || count($wishListSets) > 0)
        <div class="col-12 buttonsScroll">
         <div id="btnBottomWish">

         </div>
        </div>
    @endif
    <div class="col-xl-10 col-lg-10 col-md-12 margeTop2">
        <div class="btnGrey"><a href="{{url($lang->lang.'/wishList')}}">{{trans('front.ja.gotoWish')}}</a></div>
    </div>
</div>
