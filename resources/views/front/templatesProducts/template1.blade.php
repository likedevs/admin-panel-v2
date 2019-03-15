<div class="templateProductsOne">
    @foreach ($productsList as $key => $product)
    @if ($key == 1)
    <div class="product1">
        <div class="searchItem">
            @if ($product->created_at < date('Y-m-d', strtotime('+20 days')))
                <div class="reduceBloc">
                    New
                </div>
            @endif
            <div class="response-subproduct">
                <div class="searchImg">
                    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                    @if ($product->mainImage()->first())
                        <img src="{{ asset('/images/products/og/'.$product->mainImage()->first()->src ) }}" alt="">
                    @else
                        <img src="/images/no-image.png">
                    @endif
                    </a>
                    <div class="searchFt searchFtMobile">
                        <div>
                            <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                            {{ $product->translation($lang->id)->first()->name }}
                            </a>
                        </div>
                        <div>
                            <div class="price">
                                <div class="price">
                                    <span>{{ $product->actual_price_lei ? $product->actual_price_lei.' Lei' :  $product->price_lei.' Lei'}}</span>
                                    <span>{{ $product->discount ? $product->price_lei.' Lei' : ''}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="wishBloc show-block">
                        <div class="row">
                          <div class="col-12">
                              @if (count($product->category->properties) > 0)
                              @foreach ($product->category->properties as $key => $prop)
                              <div class="filterSize">
                                  @if (count($prop->property->multidata) > 0)
                                  @foreach ($prop->property->multidata as $keyItem => $item)
                                  @php $check = chechSubproduct($product->id, $item->id) @endphp
                                  <label class="containerFilterLeftSize {{ $check ? 'disabled' : '' }}">
                                      <input type="radio" {{ $check ? 'disabled' : '' }} name="radioSize{{ $product->id}}" class="subproductSingle"
                                                        value="{{ $item->id }}"
                                                        data="{{ $product->id }}"
                                                        data-key="{{ $key }}"
                                                        data-name="{{ $prop->property_id }}">
                                      <span class="checkmarkFilterOpenSize {{ $check ? 'disabledInput' : '' }}">{{ $item->translationByLanguage($lang->id)->first()->name }}</span>
                                  </label>
                                  @endforeach
                                  @endif
                              </div>
                              @endforeach
                              @endif
                          </div>
                        </div>
                      <div class="row justify-content-center">
                            <div class="col-10 product-alert">
                                <p class="text-center alert alert-danger">{{trans('front.ja.selectSize')}}</p>
                            </div>
                             <div class="col-4">
                                <div class="iconWish modalButton4 addToWishList {{ in_array($product->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{ $product->id }}"></div>
                            </div>
                            <div class="col-4">
                                <div class="iconWishCart cart-alert"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="searchFt">
                    <div>
                        <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                        {{ $product->translation($lang->id)->first()->name }}
                        </a>
                    </div>
                    <div>
                        <div class="price">
                            <div class="price">
                                <span>{{ $product->actual_price_lei ? $product->actual_price_lei.' Lei' :  $product->price_lei.' Lei'}}</span>
                                <span>{{ $product->discount ? $product->price_lei.' Lei' : ''}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($key == 2)
    <div class="product2">
        <div class="searchItem">
            @if ($product->created_at < date('Y-m-d', strtotime('+20 days')))
                <div class="reduceBloc">
                    New
                </div>
            @endif
            <div class="response-subproduct">
              <div class="searchImg">
                  <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                  @if ($product->mainImage()->first())
                  <img src="{{ asset('/images/products/md/'.$product->mainImage()->first()->src ) }}" alt="">
                  @else
                  <img src="/images/no-image.png">
                  @endif
                  </a>
                  <div class="searchFt searchFtMobile">
                      <div>
                          <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                          {{ $product->translation($lang->id)->first()->name }}
                          </a>
                      </div>
                      <div>
                          <div class="price">
                              <div class="price">
                                  <span>{{ $product->actual_price_lei ? $product->actual_price_lei.' Lei' :  $product->price_lei.' Lei'}}</span>
                                  <span>{{ $product->discount ? $product->price_lei.' Lei' : ''}}</span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="wishBloc show-block">
                      <div class="row">
                        <div class="col-12">
                            @if (count($product->category->properties) > 0)
                            @foreach ($product->category->properties as $key => $prop)
                            <div class="filterSize">
                                @if (count($prop->property->multidata) > 0)
                                @foreach ($prop->property->multidata as $keyItem => $item)
                                @php $check = chechSubproduct($product->id, $item->id) @endphp
                                <label class="containerFilterLeftSize {{ $check ? 'disabled' : '' }}">
                                    <input type="radio" {{ $check ? 'disabled' : '' }} name="radioSize{{ $product->id}}" class="subproductSingle"
                                                      value="{{ $item->id }}"
                                                      data="{{ $product->id }}"
                                                      data-key="{{ $key }}"
                                                      data-name="{{ $prop->property_id }}">
                                    <span class="checkmarkFilterOpenSize {{ $check ? 'disabledInput' : '' }}">{{ $item->translationByLanguage($lang->id)->first()->name }}</span>
                                </label>
                                @endforeach
                                @endif
                            </div>
                            @endforeach
                            @endif
                        </div>
                      </div>
                      <div class="row justify-content-center">
                            <div class="col-10 product-alert">
                                <p class="text-center alert alert-danger">{{trans('front.ja.selectSize')}}</p>
                            </div>
                             <div class="col-4">
                                <div class="iconWish modalButton4 addToWishList {{ in_array($product->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{ $product->id }}"></div>
                            </div>
                            <div class="col-4">
                                <div class="iconWishCart cart-alert"></div>
                            </div>
                      </div>
                  </div>
              </div>
              <div class="searchFt">
                  <div>
                      <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                      {{ $product->translation($lang->id)->first()->name }}
                      </a>
                  </div>
                  <div>
                      <div class="price">
                          <div class="price">
                              <span>{{ $product->actual_price_lei ? $product->actual_price_lei.' Lei' :  $product->price_lei.' Lei'}}</span>
                              <span>{{ $product->discount ? $product->price_lei.' Lei' : ''}}</span>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div>
    @endif
    @if ($key == 3)
    <div class="product3">
        <div class="response-subproduct">

        <div class="searchItem">
              <div class="searchImg">
                  @if ($product->mainImage()->first()->src)
                      <img src="{{ asset('/images/products/md/'.$product->mainImage()->first()->src ) }}" alt="">
                      <a class="linkVideo" href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                      <video width="100%" height="auto" src="/videos/{{ $product->video }}" autoplay muted loop>
                      </video>
                      </a>
                  @else
                      <img src="{{ asset('/images/products/default.jpg') }}" alt="">
                  @endif
                  <div class="searchFt searchFtMobile">
                      <div>
                          <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                          {{ $product->translation($lang->id)->first()->name }}
                          </a>
                      </div>
                      <div>
                          <div class="price">
                              <div class="price">
                                  <span>{{ $product->actual_price_lei ? $product->actual_price_lei.' Lei' :  $product->price_lei.' Lei'}}</span>
                                  <span>{{ $product->discount ? $product->price_lei.' Lei' : ''}}</span>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="wishBloc show-block">
                      <div class="row">
                        <div class="col-12">
                            @if (count($product->category->properties) > 0)
                            @foreach ($product->category->properties as $key => $prop)
                            <div class="filterSize">
                                @if (count($prop->property->multidata) > 0)
                                @foreach ($prop->property->multidata as $keyItem => $item)
                                @php $check = chechSubproduct($product->id, $item->id) @endphp
                                <label class="containerFilterLeftSize {{ $check ? 'disabled' : '' }}">
                                    <input type="radio" {{ $check ? 'disabled' : '' }} name="radioSize{{ $product->id}}" class="subproductSingle"
                                                      value="{{ $item->id }}"
                                                      data="{{ $product->id }}"
                                                      data-key="{{ $key }}"
                                                      data-name="{{ $prop->property_id }}">
                                    <span class="checkmarkFilterOpenSize {{ $check ? 'disabledInput' : '' }}">{{ $item->translationByLanguage($lang->id)->first()->name }}</span>
                                </label>
                                @endforeach
                                @endif
                            </div>
                            @endforeach
                            @endif
                        </div>
                      </div>
                    <div class="row justify-content-center">
                          <div class="col-10 product-alert">
                              <p class="text-center alert alert-danger">{{trans('front.ja.selectSize')}}</p>
                          </div>
                           <div class="col-4">
                              <div class="iconWish modalButton4 addToWishList {{ in_array($product->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{ $product->id }}"></div>
                          </div>
                          <div class="col-4">
                              <div class="iconWishCart cart-alert"></div>
                          </div>
                      </div>
                  </div>
              </div>

            <div class="searchFt">
                <div>
                    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                    {{ $product->translation($lang->id)->first()->name }}
                    </a>
                </div>
                <div>
                    <div class="price">
                        <div class="price">
                            <span>{{ $product->actual_price_lei ? $product->actual_price_lei.' Lei' :  $product->price_lei.' Lei'}}</span>
                            <span>{{ $product->discount ? $product->price_lei.' Lei' : ''}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    @endif
    @endforeach
</div>
