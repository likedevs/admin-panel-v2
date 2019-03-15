@extends('front.app')
@section('content')
<div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cabDate search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 navSearch setOneNav"> <br>
                    <a href="{{ url('/'.$lang->lang) }}">Home</a>/
                    <a href="{{ url('/'.$lang->lang.'/search') }}">{{trans('front.ja.search')}}</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <h5>{{trans('front.ja.searchRezult')}} "{{ Request::get('search') }}"</h5>
                </div>
                <div class="col-xl-7 col-lg-8 col-md-10 col-sm-10 col-12">
                    <form action="{{ url($lang->lang.'/search') }}" method="get">
                        <div class="row justify-content-center dorinCaifuet">
                            <div class="col-md-6 col-7 searchInput">
                                <input type="text" name="search" placeholder="{{ trans('front.ja.searchNow') }}" value="{{ Request::get('search') }}">
                            </div>
                            <div class="col-md-4 col-5">
                                <div class="btnBrun">
                                    <input type="submit" value="{{trans('front.ja.search')}}" value="{{ Request::get('search') }}">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row margeTop2 gallery">
                @if (count($products))
                @foreach ($products as $key => $product)
                <div class="col-xl-3 col-lg-4 col-12">
                    <div class="searchItem">
                        @if ($product->discount)
                        <div class="reduceBloc">
                            -{{ $product->discount }}%
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
                                <div class="wishBloc">
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
                @endforeach
              @endif

              @if (count($sets))
                @foreach ($sets as $key => $set)
                <div class="col-xl-3 col-lg-4 col-12">
                    <div class="searchItem">
                        @if ($set->discount)
                        <div class="reduceBloc">
                            -{{ $set->discount }}%
                        </div>
                        @endif
                        <div class="response-subproduct">
                            <div class="searchImg">
                                <a href="{{ url($lang->lang.'/collection/'.$set->collection()->first()->alias.'/'.$set->alias) }}">
                                  @if ($set->mainPhoto()->first())
                                  <img src="/images/sets/og/{{ $set->mainPhoto()->first()->src }}" alt="">
                                  @else
                                  <img src="{{ asset('/images/no-image.png') }}" alt="">
                                  @endif
                                </a>
                                <div class="searchFt searchFtMobile">
                                  <div>
                                      <a href="{{ url($lang->lang.'/catalog/'.$set->alias) }}">
                                      {{ $set->translation($lang->id)->first()->name }}
                                      </a>
                                  </div>
                                  <div>
                                          <div class="price">
                                              <span>{{ $set->price_lei - ($set->price_lei * $set->discount) / 100}} Lei</span>
                                              @if ($set->discount)
                                                  <span>{{ $set->price_lei.' Lei'}}</span>
                                              @else
                                                  <span></span>
                                              @endif
                                          </div>
                                  </div>
                                </div>
                                <div class="wishBloc">
                                    <div class="row justify-content-center">
                                          <div class="col-10 product-alert">
                                              <p class="text-center alert alert-danger">{{trans('front.ja.selectSize')}}</p>
                                          </div>
                                           <div class="col-12">
                                              {{-- <div class="iconWish modalButton4 addSetToWishList {{ in_array($product->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{ $product->id }}"></div> --}}
                                          </div>
                                          <div class="col-4">
                                              {{-- <div class="iconWishCart cart-alert"></div> --}}
                                          </div>
                                      </div>
                                </div>
                            </div>
                            <div class="searchFt">
                                <div>
                                    <a href="{{ url($lang->lang.'/catalog/'.$set->alias) }}">
                                    {{ $set->translation($lang->id)->first()->name }}
                                    </a>
                                </div>
                                <div>
                                        <div class="price">
                                            <span>{{ $set->price_lei - ($set->price_lei * $set->discount) / 100}} Lei</span>
                                            @if ($set->discount)
                                                <span>{{ $set->price_lei.' Lei'}}</span>
                                            @else
                                                <span></span>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
              @endif

              @if(count($products) === 0 && count($sets) === 0)
                  <div class="col-12">
                      <h4 class="text-center">{{ trans('front.ja.nothingFound') }}</h4>
                  </div>
              @endif
            </div>
        </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
