@php
    $amount = 0;
    $onlySubproduses = true;
@endphp
<div class="col-lg-10 col-md-12">
    <!-- <div class="row justify-content-center">
        <div class="col-lg-10 col-md-6 col-sm-8 col-12">
            <h4>{{ $set->translation()->first()->name }}</h4>
        </div>
    </div> -->
    @if (count($set->products()->get()))
    <div class="row justify-content-center">
        <div class="col-auto detMob" data-show="{{trans('front.ja.showProducts')}}" data-hidden="{{trans('front.ja.hideProducts')}}">
            {{trans('front.ja.hideProducts')}}
        </div>
    </div>
    <div class="lifeItemMob">
        @foreach ($set->products()->get() as $key => $product)
        <div class="row justify-content-center lifeItem response-item">

            <div class="col-lg-4 col-md-3 col-sm-4 col-5">
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

                @if (array_key_exists($product->id, @$filter[$set->id]))
                    @php
                        $subproductId = @$filter[$set->id][$product->id]['subproductId'];
                        $amount += $product->subproductById($subproductId)->first()->actual_price_lei;
                    @endphp
                    <div>{{trans('front.ja.price')}}: <b>{{  $product->subproductById($subproductId)->first()->actual_price_lei }} Lei</b>
                        @if ($product->subproductById($subproductId)->first()->discount > 0)
                            <del>{{ $product->subproductById($subproductId)->first()->price_lei }} Lei</del>
                        @endif
                    </div>
                @else
                    <div>{{trans('front.ja.price')}}: <b>{{ $product->actual_price_lei }} Lei</b>
                        @if ($product->discount > 0)
                            <del>{{ $product->price_lei }} Lei</del>
                        @endif
                    </div>
                    @php
                        $subproductId = 0;
                        $amount += $product->actual_price_lei;
                    @endphp
                @endif

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
                                                    <input class="fucked subproductListItem" {{ @$filter[$set->id][$product->id]['valueId'] == $item->id ? 'checked' : '' }} value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->property_id }}" type="radio" {{ $check ? 'disabled' : '' }}  name="radio{{ $key.$product->id}}" data-set="{{ $set->id }}">
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
                if (!is_null($product->subproductById($subproductId)->first())) {
                    $productsId['subprods'][] = $product->subproductById($subproductId)->first()->id;
                }else{
                    $productsId['prods'][] = $product->id;
                    $onlySubproduses = false;
                }
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
            {{-- <span class="{{ $amount > $set->price_lei ? 'discount-price' : ''}}">{{ $amount }} Lei </span>
            <span class="{{ $amount < $set->price_lei ? 'discount-price' : ''}}">{{ $set->price_lei }} Lei</span> --}}
            @if ($amount > $set->price_lei)
                <span class="discount-price">{{ $amount }} </span>
                <span>{{ $set->price_lei }} Lei</span>
            @else
                <span class="discount-price">{{ $set->price_lei }}  </span>
                <span>{{ $amount }} Lei</span>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-10 col-md-6 col-sm-8 col-12">

            <div class="row padButtons justify-content-between">
              @if ($onlySubproduses == true)
                  <div class="btnToCart setToCart cart-alert" data-toggle="modal" data-target="#addToCart" data-products="{{ json_encode($productsId) }}" data-id="{{ $set->id }}" data-price="{{ $amount < $set->price_lei ? $amount : $set->price_lei}}">
                      <!-- {{trans('front.ja.addSetCart')}} -->
                  </div>
              @else
                  <p class="text-center col-12 alert alert-danger">{{trans('front.ja.selectAllSize')}}</p>
                  <div class="btnToCart cart-alert">
                      <!-- {{trans('front.ja.addSetCart')}} -->
                  </div>
                @endif
              <div class="btnToCart addSetToWishList" data-set_id="{{ $set->id }}" data-products="{{ json_encode($productsId) }}">
                  <!-- {{trans('front.ja.addSetWish')}} -->
              </div>

            </div>
        </div>

    </div>
    <!-- <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-6 col-sm-8 col-12">
            <div class="btnDetSilver">
                <a href="{{ url('/'.$lang->lang.'/collection/'.$set->collection()->first()->alias.'/'.$set->alias) }}">{{trans('front.ja.viewDetails')}}</a>
            </div>
        </div>
    </div> -->
    @endif
</div>
