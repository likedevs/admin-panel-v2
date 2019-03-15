<div class="row oneItemDet searchImg">
    <div class="col-md-12 col-6 maning">
        <div class="desktop-only">{{ $product->translation($lang->id)->first()->name }}</div>
        <div class="mob-only">
            {{ strlen($product->translation($lang->id)->first()->name) >= 15 ? str_limit($product->translation($lang->id)->first()->name, 15) : $product->translation($lang->id)->first()->name }}
        </div>
    </div>
    <div class="col-md-12 col-6 text-right maning">
        @if (!is_null($subproduct))
            {{ $subproduct->actual_price_lei }} Lei
        @endif
        @if ($subproduct->discount > 0)
            <span>{{ $subproduct->price_lei }} Lei</span>
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
    <div class="col-md-12 col-5 selSize">
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
                            <input class="fucked subproductSingle" {{ @$filter[$set->id][$product->id]['valueId'] == $item->id ? 'checked' : '' }} value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->property_id }}" type="radio" {{ $check ? 'disabled' : '' }}  name="radio{{ $key.$product->id}}">
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
    <div class="col-md-12 col-6 btn-cart-wish modalToCart {{ in_array($subproduct->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-id="{{ $subproduct->id }}">
        {{trans('front.cart.addToCart')}}
    </div>
</div>
