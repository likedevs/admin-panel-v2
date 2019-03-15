<div class="">
  <div class="row">
    <div class="col-lg-4 nav">
      <a href="{{url($lang->lang)}}">Home</a>/
      <a href="{{url($lang->lang.'/wishList')}}">{{trans('front.ja.wishlist')}}</a>
    </div>
  </div>
  <div class="row justify-content-center margeTop2">
    <div class="col-auto">
        <div class="col-auto blog">
            <h3>{{trans('front.ja.wishlist')}}</h3>
        </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-12">
            {{count($wishListProducts) + count($wishListSets)}} {{trans('front.ja.products')}}
          </div>
          @if (count($wishListSets) > 0)
              @foreach ($wishListSets as $wishListSet)
                <div class="col-12">
                  <div class="wishItemSet">
                    <div class="row">
                      <div class="col-md-2 col-3">
                        @if ($wishListSet->set()->first())
                        <img src="/images/sets/og/{{ $wishListSet->set()->first()->mainPhoto()->first()->src }}">
                        @else
                        <img src="{{ asset('/images/no-image.png') }}" alt="">
                        @endif
                      </div>
                      <div class="col-8">
                        <div class="denWishSet">{{ $wishListSet->set->translation($lang->id)->first()->name }}({{trans('front.ja.thisISOneSet')}})</div>
                        <div class="txtWish">{{trans('front.ja.productCode')}} <strong class="code">{{ $wishListSet->set->code }}</strong></div>
                        <div class="txtWish">{{trans('front.ja.price')}} <strong class="priceBlock">{{ $wishListSet->set->price_lei }} Lei</strong></div>
                      </div>
                      <div class="col-md-2 col-1">
                        <div class="delWish text-right removeSetWishList" data-id="{{$wishListSet->id}}"></div>
                      </div>
                    </div>
                    @if (count($wishListSet->wishlist) > 0)
                        <div class="row wishSet justify-content-center" >
                        @foreach ($wishListSet->wishlist as $wishListProduct)
                            <div class="col-md-11 col-12 wishProduct">
                              <div class="row">
                                <div class="col-md-2 col-3">
                                  @if (!is_null($wishListProduct->product->mainImage()->first()))
                                      @php $image = getMainProductImage($wishListProduct->product_id, $lang->id) @endphp
                                      <img src="{{ asset('images/products/md/'.$wishListProduct->product->mainImage()->first()->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="cartImg">
                                  @else
                                      <img src="{{ asset('/images/no-image.png') }}" alt="">
                                  @endif
                                </div>
                                <div class="col-8 setDesc">
                                  <div class="row">
                                    <div class="col-12">
                                      <div class="denWish">{{$wishListProduct->product->translation($lang->id)->first()->name}}</div>
                                    </div>
                                  </div>
                                  @if ($wishListProduct->subproduct)
                                    <div class="txtWish">{{trans('front.ja.productStock')}} <span><span class="stock">{{ $wishListProduct->subproduct->stock }}</span></span></div>
                                    <div class="txtWish">{{trans('front.ja.productCode')}} <strong class="code">{{$wishListProduct->subproduct->code}}</strong></div>
                                    <div class="txtWish">{{trans('front.ja.price')}} <strong class="priceBlock">{{ $wishListProduct->product->price_lei }} Lei</strong></div>
                                  @else
                                    <div class="txtWish">{{trans('front.ja.productStock')}} <span><span class="stock">{{ $wishListProduct->product->stock }}</span></span></div>
                                    <div class="txtWish">{{trans('front.ja.productCode')}} <strong class="code">{{ $wishListProduct->product->code }}</strong></div>
                                    <div class="txtWish">{{trans('front.ja.price')}} <strong class="priceBlock">{{ $wishListProduct->product->price_lei }} Lei</strong></div>
                                  @endif
                                  <div class="colorWish">
                                    <?php
                                      $propertyValueID = getPropertiesData($wishListProduct->product->id, ParameterId('color'));
                                    ?>
                                    @if (!is_null($propertyValueID) && $propertyValueID !== 0)
                                      <?php
                                        $propertyValue = getMultiDataList($propertyValueID, $lang->id)->value;
                                      ?>
                                      <div class="d-flex blockItem"><div>{{GetParameter('color', $lang->id)}}: </div> <b> {{$propertyValue}}</b></div>
                                    @endif

                                  </div>
                                  <div class="row">
                                    <div class="col-md-4 col-sm-6 col-12 bm">
                                      <div class="selWish">
                                        <select name="subproductSize" data-id="{{$wishListProduct->id}}">
                                            <option value="">{{trans('front.ja.selectSize')}}</option>
                                            @foreach ($wishListProduct->product->subproducts as $subKey => $subproduct)
                                                @foreach (json_decode($subproduct->combination) as $key => $combination)
                                                    @if ($key != 0)
                                                      <?php $property = getMultiDataList($combination, $lang->id); ?>

                                                      @if ($subproduct->stock > 0)
                                                          <option {{$wishListProduct->subproduct && $wishListProduct->subproduct->id === $subproduct->id ? 'selected' : ''}} value="{{$subproduct->id}}">{{$property->value}} - {{trans('front.ja.inStock')}}</option>
                                                      @else
                                                          <option disabled>{{$property->value}} - {{trans('front.ja.notInStock')}}</option>
                                                      @endif

                                                    @endif
                                                @endforeach
                                            @endforeach
                                          </select>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row justify-content-start">
                      <div class="offset-sm-2 col-sm-8 col-12">
                        <div class="row">
                          <div class="col-sm-4 col-6">
                            <div class="btnGrey">
                              <a class="moveSetFromWishListToCart" data-id="{{$wishListSet->id}}">{{trans('front.wishList.addToCart')}}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                </div>
              @endforeach
          @endif

          @if (count($wishListProducts) > 0)
              @foreach ($wishListProducts as $wishListProduct)
                <div class="col-12">
                  <div class="wishItem wishProduct">
                    <div class="row">
                      <div class="col-md-2 col-3">
                        @if (getMainProductImage($wishListProduct->product_id, $lang->id))
                            @php $image = getMainProductImage($wishListProduct->product_id, $lang->id) @endphp
                            <img src="{{ asset('images/products/md/'.$image->src) }}" alt="{{$image->alt}}" title="{{$image->title}}" class="cartImg">
                        @else
                            <img src="{{ asset('/images/no-image.png') }}" alt="">
                        @endif
                      </div>
                      <div class="col-8">
                        <div class="denWish">{{ $wishListProduct->product->translationByLanguage($lang->id)->first()->name }}({{ trans('front.ja.thisISOneProduct') }})</div>
                        @if ($wishListProduct->subproduct)
                          <div class="txtWish">{{trans('front.ja.productStock')}} <span><span class="stock">{{ $wishListProduct->subproduct->stock }}</span></span></div>
                          <div class="txtWish">{{trans('front.ja.productCode')}} <strong class="code">{{$wishListProduct->subproduct->code}}</strong></div>
                          <div class="txtWish">{{trans('front.ja.price')}} <strong class="priceBlock">{{$wishListProduct->subproduct->price_lei}} Lei</strong></div>
                        @else
                          <div class="txtWish">{{trans('front.ja.productStock')}} <span><span class="stock">{{ $wishListProduct->product->stock }}</span></span></div>
                          <div class="txtWish">{{trans('front.ja.productCode')}} <strong class="code">{{ $wishListProduct->product->code }}</strong></div>
                          <div class="txtWish">{{trans('front.ja.price')}} <strong class="priceBlock">{{$wishListProduct->product->price_lei}} Lei</strong></div>
                        @endif
                        <div class="colorWish">
                          <?php
                            $propertyValueID = getPropertiesData($wishListProduct->product->id, ParameterId('color'));
                          ?>
                          @if (!is_null($propertyValueID) && $propertyValueID !== 0)
                            <?php
                              $propertyValue = getMultiDataList($propertyValueID, $lang->id)->value;
                            ?>
                            <div class="d-flex blockItem"><div>{{GetParameter('color', $lang->id)}}: </div> <b> {{$propertyValue}}</b></div>
                          @endif
                        </div>
                        <div class="row">
                          <div class="col-sm-4 col-6 bm">
                            <div class="selWish">
                                <select name="subproductSize" data-id="{{$wishListProduct->id}}">
                                  <option value="">{{trans('front.ja.selectSize')}}</option>
                                  @foreach ($wishListProduct->product->subproducts as $subKey => $subproduct)
                                      @foreach (json_decode($subproduct->combination) as $key => $combination)
                                          @if ($key != 0)
                                            <?php $property = getMultiDataList($combination, $lang->id); ?>

                                            @if ($subproduct->stock > 0)
                                                <option {{$wishListProduct->subproduct && $wishListProduct->subproduct->id === $subproduct->id ? 'selected' : ''}} value="{{$subproduct->id}}">{{$property->value}} - {{trans('front.ja.inStock')}}</option>
                                            @else
                                                <option disabled>{{$property->value}} - {{trans('front.ja.notInStock')}}</option>
                                            @endif

                                          @endif
                                      @endforeach
                                  @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-sm-4 col-6 bm1">
                            <div class="btnGrey">
                              <a class="moveFromWishListToCart" data-id="{{$wishListProduct->id}}">{{trans('front.wishList.addToCart')}}</a>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-2 col-1">
                        <div class="delWish removeItemWishList" data-id="{{$wishListProduct->id}}"></div>
                      </div>
                    </div>
                  </div>
                </div>
              @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
