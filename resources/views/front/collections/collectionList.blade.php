@extends('front.app')
@section('content')
    <div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])

    <div class="cont">
        <div class="row">
            <div class="col-auto nav">
                <a href="{{ url('/'.$lang->lang) }}">Home</a>/
                <a href="{{ url('/'.$lang->lang.'/collection/'.$collection->alias) }}">{{ $collection->translation()->first()->name }}</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-auto">
                <div class="starLogo">
                    {{ $collection->translation()->first()->name }}
                </div>
            </div>
        </div>
        <!-- <div class="row">
            <div class="col-12">
                <div class="slideCollection">
                    @if (count($collection->sets()->get()) > 0)
                    @foreach ($collection->sets()->get() as $key => $set)
                    @if (!is_null($set->mainPhoto()->first()))
                    <div class="slideCollectionItem">
                        <img src="/images/sets/bg/{{ $set->mainPhoto()->first()->src }}" alt="{{ $set->translation($lang->id)->first()->name }}" title="{{ $set->translation($lang->id)->first()->name }}">
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </div> -->
        <div class="container">
            <div class="row oneItem oneitemDesk">
              <div class="col-md-auto col-12 logoMobile">
                  <h3>{{trans('front.ja.lifestylesFrom')}} {{ $collection->translation()->first()->name }}</h3>
              </div>
            </div>
            @if (count($collection->sets()->get()) > 0)
            @foreach ($collection->sets()->get() as $key => $set)
            <div class="row oneItem {{ $key % 2 != 0 ? 'evenBgItem' : '' }}">
                  <div class="col-12">
                      <h4>{{ $set->translation()->first()->name }}</h4>
                  </div>
                <div class="col-lg-6 col-md-12">
                    <div class="height1">
                        <div class="slidOr slider-for" id="slider{{ $set->id }}" data-id="{{ $set->id }}">
                            @if (count($set->photos()->get()) > 0)
                            @foreach ($set->photos()->get() as $key => $photo)
                            <div class="slidItem">
                                <img src="/images/sets/og/{{ $photo->src }}" alt="{{ $set->translation($lang->id)->first()->name }}" title="{{ $set->translation($lang->id)->first()->name }}">
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-10">
                                <div class="slideNav" id="nav{{ $set->id }}" area-controls="{{ $set->id.$key }}">
                                    @if (count($set->photos()->get()) > 0)
                                    @foreach ($set->photos()->get() as $key => $photo)
                                    <div>
                                        <img src="/images/sets/md/{{ $photo->src }}" alt="{{ $set->translation($lang->id)->first()->name }}" title="{{ $set->translation($lang->id)->first()->name }}">
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="collectionAside">
                      <div class="row justify-content-end">
                          <div class="col-lg-10 col-md-12">
                              <div class="lifeStyleAside">
                                  <div class="row justify-content-center response-item">

                                      <div class="col-lg-10 col-md-12">
                                          @if (count($set->products()->get()))
                                          <div class="row justify-content-center">
                                              <div class="col-6 detMob"  data-show="{{trans('front.ja.showProducts')}}" data-hidden="{{trans('front.ja.hideProducts')}}">
                                                  {{trans('front.ja.hideProducts')}}
                                              </div>
                                          </div>
                                          <div class="lifeItemMob">
                                              @php
                                                  $amount = 0;
                                              @endphp
                                              @foreach ($set->products()->get() as $key => $product)
                                              <div class="row justify-content-center lifeItem">

                                                  <div class="col-lg-6 col-md-3 col-sm-4 col-5">
                                                      <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                                                          @if (!is_null($product->setImage($set->id)->first()))
                                                              <img src="/images/products/md/{{ $product->setImage($set->id)->first()->image }}" alt="{{ $product->translation($lang->id)->first()->name }} - {{ $set->translation($lang->id)->first()->name }}" title="{{ $product->translation($lang->id)->first()->name }}">
                                                          @else
                                                              @if ($product->mainImage()->first())
                                                              <img src="{{ asset('/images/products/og/'.$product->mainImage()->first()->src ) }}" alt="{{ $product->translation($lang->id)->first()->name }} - {{ $set->translation($lang->id)->first()->name }}" title="{{ $product->translation($lang->id)->first()->name }}">
                                                              @else
                                                              <img src="/images/no-image.png">
                                                              @endif
                                                          @endif
                                                      </a>
                                                  </div>
                                                  <div class="col-lg-6 col-md-3 col-sm-4 col-7 lifeDescr">
                                                      <div>
                                                          <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                                                              {{ $product->translation($lang->id)->first()->name }}
                                                          </a>
                                                      </div>
                                                      @php
                                                      $color = getFullParameterById(2, $product->id, $langId = $lang->id);
                                                      @endphp
                                                      @if ($color)
                                                      <div>{{ $color['prop'] }}: <span>{{ $color['val'] }}</span></div>
                                                      @endif
                                                      <div>{{trans('front.ja.price')}}: <b>{{ $product->actual_price_lei }} Lei</b>
                                                          @if ($product->discount > 0)
                                                              <del>{{ $product->price_lei }} Lei</del>
                                                          @endif
                                                      </div>
                                                      <div class="selSize select-none">{{trans('front.ja.selectSize')}}</div>
                                                      <div class="lifeItemPop">
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
                                                                                          <input class="fucked subproductListItem" value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->property_id }}" type="radio" {{ $check ? 'disabled' : '' }}  name="radio{{ $key.$product->id}}" data-set="{{ $set->id }}">
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
                                                  </div>
                                              </div>

                                              @php
                                                  $amount += $product->actual_price_lei;
                                                  $productsId['prods'][] = $product->id;
                                              @endphp

                                              @endforeach

                                          </div>
                                          <div class="row justify-content-center total">
                                              {{-- <div class="col-xl-7 col-lg-6 col-md-3 col-sm-4 col-6">
                                                   {{trans('front.ja.priceprods')}}
                                              </div>
                                              <div class="col-xl-5 col-lg-6 col-md-3 col-sm-4 col-6 text-right">
                                                  <span class="{{ $amount > $set->price_lei ? 'discount-price' : ''}}">{{ $amount }} Lei</span>
                                              </div> --}}
                                          </div>
                                          <div class="row justify-content-center total">
                                              <div class="col-xl-4 col-lg-6 col-md-3 col-sm-4 col-6">
                                                  {{trans('front.ja.priceset')}}
                                              </div>
                                              <div class="col-xl-8 col-lg-6 col-md-3 col-sm-4 col-6 text-right">
                                                  @if ($amount > $set->price_lei)
                                                      <span class="discount-price">{{ $amount }} </span>
                                                      <span>{{ $set->price_lei }} Lei</span>
                                                  @else
                                                      <span class="discount-price">{{ $set->price_lei }}  </span>
                                                      <span>{{ $amount }} Lei</span>
                                                  @endif
                                              </div>
                                          </div>
                                          <div class="row justify-content-center searchImg">
                                              <div class="col-xl-12 col-lg-12 col-md-6 col-sm-8 col-12">
                                                  <div class=" product-alert">
                                                      <p class="text-center alert alert-danger">{{trans('front.ja.selectAllSize')}}</p>
                                                  </div>
                                                  <div class="row padButtons justify-content-between">
                                                    <div class="btnToCart cart-alert">
                                                        <!-- {{trans('front.ja.addSetCart')}} -->
                                                    </div>
                                                    <div class="btnToCart addSetToWishList" data-set_id="{{$set->id}}" data-products="{{ json_encode($productsId) }}">
                                                        <!-- {{trans('front.ja.addTowish')}} -->
                                                    </div>
                                                  </div>
                                              </div>
                                          </div>

                                          @endif
                                          <!-- <div class="row justify-content-center">
                                              <div class="col-xl-12 col-lg-12 col-md-6 col-sm-8 col-12">
                                                  <a class="btnDetSilver" href="{{ url('/'.$lang->lang.'/collection/'.$collection->alias.'/'.$set->alias) }}">{{trans('front.ja.viewDetails')}}</a>
                                              </div>
                                          </div> -->
                                      </div>

                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
            @php
                $productsId=[];
            @endphp
            @endforeach
            @endif
        </div>
        <div class="container">
          <div class="row">
              <div class="col-12">
                  <h5 style="padding-top: 30px;">{{trans('front.ja.usefullInfo')}}</h5>
              </div>
              <div class="col-12">
                  <p>
                      {{ $collection->translation($lang->id)->first()->seo_text }}
                  </p>
              </div>
          </div>
        </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
