@extends('front.app')
@section('content')
@include('front.partials.header', ['className' => 'headSet'])
@php
$amount = 0;
@endphp

<div class="container-fluid">
  <div class="row">
    <div class="col-lg-6 col-md-4  nav setOneNav">
        <a href="{{ url('/'.$lang->lang) }}">Home</a>/
        <a href="{{ url('/'.$lang->lang.'/collection/'.$set->collection->alias) }}">{{ $set->collection()->first()->translation($lang->id)->first()->name }}</a>/
        <a href="#">{{ $set->translation()->first()->name }}</a>
    </div>
  </div>
</div>
<div class="cont">
  <div class="row">
    <div class="col-12">
      <div class="starLogo">
          @if (!is_null($set->collection()->first()))
              {{ $set->translation($lang->id)->first()->name }}
          @endif
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12 dampac">
      <div class="slideCollection">
          @if (count($set->photos()->get()) > 0)
          @foreach ($set->photos()->get() as $key => $photo)
          <div class="slideCollectionItem">
              <img src="/images/sets/md/{{ $photo->src }}" alt="{{ $set->translation($lang->id)->first()->name }}" title="{{ $set->translation($lang->id)->first()->name }}">
          </div>
          @endforeach
          @endif
      </div>
    </div>
  </div>
</div>
<div class="one oneSet">
  <div class="container-fluid">

    <div class="row response-item">
      <div class="col-md-8 col-12">
        <div class="hft">
          <div class="row justify-content-center">
            <div class="col-md-auto col-12">
              <h3>{{trans('front.ja.prodsInSet')}}</h3>
            </div>
            <div class="col-12">
              <div class="row">
                <div class="col-12 descr">
                  <p>{{ $set->description }}</p>
                </div>
              </div>
            </div>
          </div>

          @if (count($set->products()->get()))
              @foreach ($set->products()->get() as $key => $product)

          <div class="row">
            <div class="col-12">
              <div class="row slideOne">
                <div class="col-md-6 col-12 bc">
                    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                        @if (!is_null($product->setImage($set->id)->first()))
                            <img src="/images/products/md/{{ $product->setImage($set->id)->first()->image }}" alt="{{ $product->translation($lang->id)->first()->name }} - {{ $set->translation($lang->id)->first()->name }}" title="{{ $product->translation($lang->id)->first()->name }}">
                        @else
                            @if ($product->mainImage()->first())
                            <img src="{{ asset('/images/products/md/'.$product->mainImage()->first()->src ) }}" alt="{{ $product->translation($lang->id)->first()->name }} - {{ $set->translation($lang->id)->first()->name }}" title="{{ $product->translation($lang->id)->first()->name }}">
                            @else
                            <img src="/images/no-image.png">
                            @endif
                        @endif
                    </a>
                </div>

                <div class="col-md-6 col-12 setOneDescr">

                  <div class="row margZero">
                    <div class="col-12 paddZero">
                        <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                            {{ $product->translation($lang->id)->first()->name }}
                        </a>
                    </div>
                    <div class="col-12 paddZero">
                      {{ $product->actual_price_lei }} Lei
                      <span class="sp">
                            @if ($product->discount > 0)
                                {{ $product->price_lei }}  Lei
                            @endif
                      </span>
                    </div>
                    <div class="col-12 paddZero">
                        @php
                        $color = getFullParameterById(2, $product->id, $langId = $lang->id);
                        @endphp
                        @if ($color)
                        <div>{{ $color['prop'] }}: <span>{{ $color['val'] }}</span></div>
                        @endif
                    </div>
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
                    </div>
                    <div class="col-12">
                      <div class="row">
                        <div class="col-12 selSize">
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
                                        {{trans('front.cart.delivery')}}
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
                                                            <input class="fucked subproductSingle" value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->property_id }}" type="radio" {{ $check ? 'disabled' : '' }}  name="radio{{ $key.$product->id}}" data-set="{{ $set->id }}">
                                                            <span class="sizeCheckmark">
                                                                <div class="dat">{{ $item->translationByLanguage($lang->id)->first()->name }}</div>
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
                        <!-- <div class="col-12 viewDet">
                          <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">{{trans('front.ja.viewDetails')}}</a>
                        </div> -->
                      </div>
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
             @php
                  $amount += $product->actual_price_lei;
                  $productsId['prods'][] = $product->id;
             @endphp
             @endforeach
          @endif

        </div>
      </div>
      <div class="col-xl-4 col-lg-4 col-md-4 col-12 searchImg">
        <div class="row oneItemDet justify-content-end">

            {{-- Preturile --}}
            @if ($amount > $set->price_lei)
                <div class="col-lg-11 col-md-12 col-sm-8 col-9 setChange">
                  {{trans('front.ja.priceset')}}
                  <span><strong>{{ $amount }}  </strong></span>

                  <span>{{ $set->price_lei }} Lei</span>
                </div>
            @else
                <div class="col-lg-11 col-md-12 col-sm-8 col-9 setChange">
                    {{trans('front.ja.priceset')}}
                    <span><strong>{{ $set->price_lei }}  </strong></span>

                    <span>{{ $amount }} Lei</span>
                </div>
            @endif


            <div class="col-lg-11 col-md-12 col-sm-8 col-auto">
                <div class="btnToCart cart-alert">
                    {{trans('front.ja.addSetCart')}}
                </div>
            </div>
            <div class="col-12 product-alert">
                <p class="text-center alert alert-danger">{{trans('front.ja.selectAllSize')}}</p>
            </div>
        </div>


        <div class="row justify-content-center gad">
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


    <div class="row justify-content-center">
      <div class="col-auto">
        <h3>{{trans('front.ja.lifestylesRecomand')}}</h3>
      </div>
      <div class="col-12">
        <div class="slideMob">

            @if (count($similarSets) > 0)
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
            @endif
        </div>
      </div>
    </div>
  </div>

 <div class="cont">
     <div class="container">
       <div class="row">
           <div class="col-12">
               <h5 style="padding-top: 30px;">{{trans('front.ja.usefullInfo')}}</h5>
           </div>
           <div class="col-12">
               <p>
                   {{ $set->translation($lang->id)->first()->seo_text }}
               </p>
           </div>
       </div>
     </div>
 </div>
</div>


@include('front.partials.footer')
@stop
