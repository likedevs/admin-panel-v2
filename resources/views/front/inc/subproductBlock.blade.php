@php $filterSubproduct = []; @endphp

@if (count($product->category->properties) > 0)
    @foreach ($product->category->properties as $key => $prop)

        @php
            @$filterSubproduct[$key] = $filter[$product->id.$key]
        @endphp

    @endforeach
@endif

<div class="col-lg-4 col-md-3 col-sm-4 col-6">
    <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
        @if ($product->mainImage()->first())
        <img src="{{ asset('/images/products/og/'.$product->mainImage()->first()->src ) }}" alt="">
        @else
        <img src="/images/no-image.png">
        @endif
    </a>
</div>
<div class="col-lg-6 col-md-3 col-sm-4 col-6 lifeDescr">
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
    <div>Pret: <b>
        @if (!is_null($subproduct))
            {{ $subproduct->price_lei ? $subproduct->price_lei .'Lei' : '' }}
        @else
            {{ $product->price_lei ? $product->price_lei .'Lei' : '' }}
        @endif
    </b></div>
    <div class="selSize">Select size</div>
    <div class="lifeItemPop">
        <div class="row">
            <div class="col-5">
                <div class="itemPop" data-toggle="modal" data-target="#modalSize">
                    marimi
                </div>
            </div>
            <div class="col-5">
                <div class="itemPop2" data-toggle="modal" data-target="#modalDelivery">
                    livrare
                </div>
            </div>
            <div class="col-2">
                <div class="itemPop3">
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-center centr">
                    <div class="col-11 ban">
                        Selectati marimea
                    </div>

                    @if (count($product->category->properties) > 0)
                    @foreach ($product->category->properties as $key => $prop)
                        @if (count($prop->property->multidata) > 0)
                        @foreach ($prop->property->multidata as $keyItem => $item)
                        @php $check = chechSubproduct($product->id, $item->id) @endphp
                        <div class="col-11">
                            @if (!$check)
                                <label class="sizeRadio">
                                    <input class="fucked subproductListItem" {{ @$filter[$product->id.$key]['valueId'] == $item->id ? 'checked' : '' }} value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->id }}" type="radio" {{ $check ? 'disabled' : '' }}  name="radio{{ $key.$product->id}}">
                                    <span class="sizeCheckmark">
                                        <div class="dat">{{ $item->translationByLanguage($lang->id)->first()->name }}</div>
                                        <div>mai sunt citeva produse in stoc</div>
                                    </span>
                                </label>
                            @else
                                <label class="sizeRadio {{ $check ? 'disabled' : '' }}">
                                    <input class="fucked" name="radio{{ $key.$product->id}}">
                                    <span class="sizeCheckmark">
                                        <div class="dat">{{ $item->translationByLanguage($lang->id)->first()->name }}</div>
                                        <div class="noStocSize">stoc epuizat</div>
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
