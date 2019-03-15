@extends('front.app')
@section('content')
<div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cabDate search">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 navSearch setOneNav">
                    <br><a href="{{ url('/'.$lang->lang) }}">Home</a>/
                    <a href="{{ url('/'.$lang->lang.'/outlet') }}">Outlet</a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto newArrival margeTop2">
                    <h3>Outlet</h3>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-10 col-md-10 col-sm-10 col-12">
                    {{--
                    <form action="">
                        <div class="row out margeTop2 justify-content-center">
                            <div class="col-auto bag">
                                Sorteaza dupa:
                            </div>
                            <div class="col-auto text-center radSer">
                                <label class="radioSearch">
                                <input type="radio" checked name="radioSearch">
                                <span class="checkSearch">Loewest Price</span>
                                </label>
                                <label class="radioSearch">
                                <input type="radio" name="radioSearch">
                                <span class="checkSearch">Loewest Price</span>
                                </label>
                                <label class="radioSearch">
                                <input type="radio" name="radioSearch">
                                <span class="checkSearch">Cele mai noi produse</span>
                                </label>
                            </div>
                        </div>
                    </form>
                    --}}
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
            </div>
            <div class="row load-more-area"></div>

        </div>
        @if ($products->nextPageUrl())
            <div class="row justify-content-center">
                <div class="btnDetSilver col-xl-2 col-lg-3 col-md-6 col-sm-8 col-12">
                    <a href="#" class="load-more-btn" data-url="{{ $products->nextPageUrl() }}">{{trans('front.ja.loadMore')}}</a>
                </div>
            </div>
        @endif
    </div>
    @include('front.partials.footer')
</div>
@stop
