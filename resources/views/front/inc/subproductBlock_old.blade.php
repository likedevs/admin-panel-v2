@php $filterSubproduct = []; @endphp

@if (count($product->category->properties) > 0)
    @foreach ($product->category->properties as $key => $prop)

        @php
            @$filterSubproduct[$key] = $filter[$product->id.$key]
        @endphp

    @endforeach
@endif


<a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">

   <div class="evenningOnHover">
      <div class="evenningItem">
          @if (!is_null($subproduct))
              <div class="wishHeartWhite addToWishList" data-id="{{ $product->id }}" data-subproduct="{{ $subproduct->id }}"></div>
          @else
              <div class="wishHeartWhite addToWishList" data-id="{{ $product->id }}" data-subproduct="0"></div>
          @endif

         @if ($product->mainImage()->first())
             <img src="{{ asset('/images/products/og/'.$product->mainImage()->first()->src ) }}" alt="">
         @else
             <img src="/images/no-image.png">
         @endif

         <div class="evenItemFooter">
             {{ $product->translation($lang->id)->first()->name }}
             @if (!is_null($subproduct))
                 {{ $subproduct->code }}
             @endif
         </div>

         <div class="eveningPrice">
             @if (!is_null($subproduct))
                 {{ $subproduct->price_lei ? $subproduct->price_lei .'Lei' : '' }}
             @else
                 {{ $product->price_lei ? $product->price_lei .'Lei' : '' }}
             @endif
         </div>

         <div class="evenDet">
             @if (count($product->category->properties) > 0)
                 @foreach ($product->category->properties as $key => $prop)
                <div class="filterSize">
                    @if (count($prop->property->multidata) > 0)
                        @foreach ($prop->property->multidata as $keyItem => $item)
                            @php $check = chechSubproduct($product->id, $item->id) @endphp
                            <label class="containerFilterLeftSize {{ $check ? 'disabled' : '' }}">
                            <input type="radio" {{ $check ? 'disabled' : '' }} {{ @$filter[$product->id.$key]['valueId'] == $item->id ? 'checked' : '' }} name="radioSize" class="subproductListItem" value="{{ $item->id }}" data="{{ $product->id }}" data-key="{{ $key }}" data-name="{{ $prop->id }}">
                            <span class="checkmarkFilterOpenSize">{{ $item->translationByLanguage($lang->id)->first()->name }}</span>
                            </label>
                       @endforeach
                   @endif
                </div>
                @endforeach
            @endif
            <div class="btnEvenning">
                @if (is_null($subproduct))
                <p class="alert alert-danger"><small> Din pacate o astfel de configurare nu exista in stoc </small></p>
                @else
                    @if ($product->stock > 0)
                        <a class="modalToCart" data-id="{{ $subproduct->id }}" href="#">add to card</a>
                    @else
                        <a href="#"><del>add to card (stock 0)</del></a>
                    @endif
                @endif
            </div>
            <div class="inscr">
               <a href="{{ url($lang->lang.'/sizes/'.$product->id) }}">ÎNSCRIETE LA MĂSURI</a>
            </div>
         </div>
      </div>
   </div>
</a>
