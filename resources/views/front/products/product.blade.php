@extends('front.app')
@section('content')
@include('front.partials.header', ['className' => 'oneHeader'])

@php
    $images = [];

    if ($product->images()->get()){
        foreach ($product->images()->get() as $key => $photo){
            $images[] = $photo->src;
        }
    }

    if ($product->setImages()->get()){
        foreach ($product->setImages()->get() as $key => $photoset){
            $images[] = $photoset->image;
        }
    }

@endphp

<div class="one">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 nav">
                <a href="#">Home</a>/
                <a href="{{ url('/'.$lang->lang.'/catalog/'.$category->alias) }}">{{ $category->translation($lang->id)->first()->name }}</a>/
                <a href="#">{{ $product->translation($lang->id)->first()->name }}</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="hft">
                    <div class="row">
                        <div class="col-12">
                            <div class="row slideOne">
                                @if ($images)
                                @foreach ($images as $key => $photo)
                                @if (($key == 0) || ($key == 1))
                                <div class="col-md-6 col-12 marProd">
                                    @php
                                        $fileExists = file_exists(public_path('/images/products/og/'.$photo));
                                    @endphp
                                    @if ($fileExists)
                                        <img src="/images/products/og/{{ $photo }}" class="mainImg"/>
                                    @endif
                                </div>
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 descr">
                            <p>{!! $product->translation($lang->id)->first()->description !!}</p>
                            <p>
                                @php
                                $cut = getFullTextParameter(3, $product->id, $langId = $lang->id);
                                @endphp
                                @if ($cut)
                                <strong>{{ $cut['prop'] }}</strong> {{ $cut['val'] }}
                                @endif
                                @php
                                $compozition = getFullTextParameter(4, $product->id, $langId = $lang->id);
                                @endphp
                                @if ($compozition)
                                <strong>{{ $compozition['prop'] }}</strong> {{ $compozition['val'] }}
                                @endif
                                @php
                                $art = getFullTextParameter(5, $product->id, $langId = $lang->id);
                                @endphp
                                @if ($art)
                                <strong>{{ $art['prop'] }}</strong> {{ $art['val'] }}
                                @endif
                            </p>
                            <div class="row justify-content-center">
                                <div class="col-lg-5 col-md-6 col-auto btn-cart-wish addToWishList {{ in_array($product->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{$product->id}}">
                                    {{ trans('front.ja.addTowish') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row slideOne">
                        @if ($images)
                        @foreach ($images as $key => $photo)
                        @if (($key == 2) || ($key == 3))
                        <div class="col-md-6 col-12 marProd">
                            @php
                                $fileExists = file_exists(public_path('/images/products/og/'.$photo));
                            @endphp

                            @if ($fileExists)
                                <img src="/images/products/og/{{ $photo }}" class="mainImg"/>
                            @endif
                        </div>
                        @endif
                        @endforeach
                        @endif
                    </div>

                    <div class="row margeTop2">
                        <div class="col-md-6 col-12">
                            <div class="iframe-video-full">
                                @if ($product->video)
                                    <video width="100%" height="100%" src="/videos/{{ $product->video }}" autoplay muted loop></video>
                                @else
                                    <img src="{{ asset('/images/default.jpg' ) }}" alt="">
                                @endif
                                <style media="screen">
                                    .iframe-video-full img{
                                        width: 100%;
                                    }
                                    .iframe-video-full iframe{
                                        display: block;
                                        position: absolute;
                                        z-index: 10;
                                        padding-left: 15px;
                                        padding-right: 15px;
                                        left: 0;
                                        top: 0;
                                    }
                                </style>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 marProd">
                            <div class="iframe-video-full">
                                @if ($images)
                                @foreach ($images as $key => $photo)
                                @if (($key == 4))
                                    @php
                                        $fileExists = file_exists(public_path('/images/products/og/'.$photo));
                                    @endphp
                                    @if ($fileExists)
                                        <img style="width: 100%;" src="/images/products/bg/{{ $photo }}" class="mainImg"/>
                                    @endif
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-12">
                <div class="response-single-item">
                    <div class="row oneItemDet searchImg">
                        <div class="col-md-12 col-6 maning">
                            <div class="desktop-only">{{ $product->translation($lang->id)->first()->name }}</div>
                            <div class="mob-only">
                                {{ strlen($product->translation($lang->id)->first()->name) >= 15 ? str_limit($product->translation($lang->id)->first()->name, 15) : $product->translation($lang->id)->first()->name }}
                            </div>
                        </div>
                        <div class="col-md-12 col-6 text-right maning">
                            {{ $product->actual_price_lei }} Lei
                            @if ($product->discount)
                                <span>{{ $product->price_lei }} Lei</span>
                            @endif
                        </div>

                        <div class="col-12 maning">
                            @php
                            $color = getFullParameterById(2, $product->id, $langId = $lang->id);
                            @endphp
                            @if ($color)
                            {{ $color['prop'] }}: {{ $color['val'] }}
                            @endif
                        </div>
                        <div class="col-md-12 col-6 selSize">
                            {{trans('front.ja.selectSize')}}
                        </div>
                        <div class="lifeItemPop popSet">
                            <div class="row">
                                <div class="col-5">
                                    <div class="itemPop" data-toggle="modal" data-target="#modalSize">
                                        {{trans('front.ja.sizes')}}
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="itemPop2" data-toggle="modal" data-target="#modalDelivery">
                                        {{trans('front.ja.delivery')}}
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="itemPop3">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row justify-content-center centr">

                                        <div class="col-11 ban">
                                            {{trans('front.ja.selectSize')}}
                                        </div>
                                        @if (count($product->category->properties) > 0)
                                        @foreach ($product->category->properties as $key => $prop)
                                        @if (count($prop->property->multidata) > 0)
                                        @foreach ($prop->property->multidata as $keyItem => $item)
                                        @php $check = chechSubproduct($product->id, $item->id) @endphp
                                        <div class="col-11">
                                            @if (!$check)
                                            <label class="sizeRadio">
                                                <input class="fucked subproductSingle" value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->property_id }}" type="radio" {{ $check ? 'disabled' : '' }}  name="radio{{ $key.$product->id}}">
                                                <span class="sizeCheckmark">
                                                    <div class="dat" >{{ $item->translationByLanguage($lang->id)->first()->name }}</div>
                                                    <div>{{trans('front.ja.inStock')}}</div>
                                                </span>
                                            </label>
                                            @else
                                            <label class="sizeRadio {{ $check ? 'disabled' : '' }}">
                                                <input class="fucked" name="radio{{ $key.$product->id}}">
                                                <span class="sizeCheckmark">
                                                    <div class="dat">{{ $item->translationByLanguage($lang->id)->first()->name }}</div>
                                                    <div class="noStocSize">{{trans('front.ja.notInStock')}}</div>
                                                </span>
                                            </label>
                                            @endif
                                        </div>
                                        @endforeach
                                        @endif
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <span class="col-12 product-alert">
                            <p class="text-center alert alert-danger">{{trans('front.ja.selectSize')}}</p>
                        </span>
                        <div class="col-md-12 col-6 btn-cart-wish open-selects">
                          {{trans('front.cart.addToCart')}}
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="example3">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                                <img src="{{ asset('fronts/img/icons/verticalSlide.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if (count($wearWith) > 0)

            <div class="col-12">
                <h3 class="text-center">{{trans('front.ja.wearWith')}}</h3>
            </div>
            <div class="col-12">
                <div class="slideMob justify-content-center">
                    @foreach ($wearWith as $key => $productWearn)
                    <div class="searchItem">
                        @if ($productWearn->discount)
                        <div class="reduceBloc">
                            -{{ $productWearn->discount }}%
                        </div>
                        @endif
                        <div class="response-subproduct">
                            <div class="searchImg">
                                <a href="{{ url($lang->lang.'/catalog/'.getProductLink($productWearn->category_id).$productWearn->alias) }}">
                                @if ($productWearn->mainImage()->first())
                                <img src="{{ asset('/images/products/og/'.$productWearn->mainImage()->first()->src ) }}" alt="">
                                @else
                                <img src="/images/no-image.png">
                                @endif
                                </a>
                                <div class="wishBloc">
                                    <div class="row">
                                        <div class="col-12">
                                            @if (count($productWearn->category->properties) > 0)
                                            @foreach ($productWearn->category->properties as $key => $prop)
                                            <div class="filterSize">
                                                @if (count($prop->property->multidata) > 0)
                                                @foreach ($prop->property->multidata as $keyItem => $item)
                                                @php $check = chechSubproduct($productWearn->id, $item->id) @endphp
                                                <label class="containerFilterLeftSize {{ $check ? 'disabled' : '' }}">
                                                <input type="radio" {{ $check ? 'disabled' : '' }} name="radioSize{{ $productWearn->id}}" class="subproductSingle"
                                                value="{{ $item->id }}"
                                                data="{{ $productWearn->id }}"
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
                                              <div class="iconWish modalButton4 addToWishList {{ in_array($productWearn->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{ $product->id }}"></div>
                                          </div>
                                          <div class="col-4">
                                              <div class="iconWishCart cart-alert"></div>
                                          </div>
                                      </div>
                                </div>
                            </div>
                            <div class="searchFt">
                                <div>
                                    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($productWearn->category_id).$productWearn->alias) }}">
                                    {{ $productWearn->translation($lang->id)->first()->name }}
                                </div>
                                </a>
                                <div>
                                    <div class="price">
                                        <span>{{ $productWearn->actual_price_lei }} Lei</span>
                                        <span>
                                            @if ($productWearn->discount > 0)
                                                {{ $productWearn->price_lei }} Lei
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif


            @if (count($similarSets) > 0)
                <div class="col-12">
                    <h3 class="text-center">{{trans('front.ja.recLifeStyles')}}</h3>
                </div>

                <div class="col-12">
                    <div class="slideMob justify-content-center">
                        @foreach ($similarSets as $key => $setItem)
                            <div class="searchItem ">
                              <div class="searchImg">
                                <a href="{{ url('/'.$lang->lang.'/collection/'.$setItem->collection()->first()->alias.'/'.$setItem->alias) }}">
                                    @if ($setItem->mainPhoto()->first())
                                        <img src="/images/sets/og/{{ $setItem->mainPhoto()->first()->src }}" alt="">
                                    @endif
                                    </a>
                                <div class="wishBloc">
                                  <div class="row justify-content-center"></div>
                                </div>
                              </div>
                              <div class="searchFt">
                                <div>{{ $setItem->translation($lang->id)->first()->name }}</div>
                                <div>
                                  <div class="price">
                                    <span>{{ $setItem->price_lei }} Lei</span>
                                    <span></span>
                                  </div>
                                </div>
                              </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


@include('front.partials.footer')
@stop
