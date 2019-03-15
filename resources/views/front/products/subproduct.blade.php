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
                <input type="radio" {{ $check ? 'disabled' : '' }} name="radioSize{{ $product->id}}" class="subproductSingle" value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->property_id }}" {{ @$filter[$set->id][$product->id]['valueId'] == $item->id ? 'checked' : '' }}>
                <span class="checkmarkFilterOpenSize">{{ $item->translationByLanguage($lang->id)->first()->name }}</span>
                </label>
                @endforeach
                @endif
            </div>
            @endforeach
            @endif
        </div>
      </div>
      <div class="row justify-content-center">
            <div class="col-4">
                @if (!is_null($subproduct))
                    <div class="iconWish modalButton4 addToWishList {{ in_array($product->id, $wishListIds) ? 'thisfuckoff' : ''}}" data-product_id="{{ $product->id }}" data-subprod_id="{{ $subproduct->id }}"></div>
                @else
                    <div class="iconWish modalButton4" data-id="{{ $product->id }}"></div>
                @endif
            </div>
            <div class="col-4">
                @if (!is_null($subproduct))
                    <div class="iconWishCart modalButton3 modalToCart" data-id="{{ $subproduct->id }}"></div>
                @else
                    <div class="iconWishCart modalButton3 modalToCart" data-id="{{ $subproduct->id }}"></div>
                @endif
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
                @if (!is_null($subproduct))
                    <span>{{ $subproduct->actual_price_lei }} Lei</span>
                @endif
                <span>{{ $product->discount > 0 ? $product->price_lei.' Lei' : ''}}</span>
            </div>
        </div>
    </div>
</div>
