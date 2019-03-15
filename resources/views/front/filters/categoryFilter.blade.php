<div class="iconFiltr">
    <div class="btnFiltr"></div>
    <div class="filterOpen">
        <div class="row justify-content-between" style="padding: 10px 0;">
            <div class="col-auto">
                <div class="filter2">
                    {{trans('front.ja.filter')}}
                </div>
            </div>
            <div class="col-auto">
                <div class="closeFiltr2">
                </div>
            </div>
        </div>
        <div class="row heightFiltr">
            <input type="hidden" class="category-id" value="{{ $categoryId }}">

            @if (count($subcategories) > 0)

            <div class="col-12 optionFiltr">
                <div class="opt">Categorii</div>
                <div class="optionFiltrOpen size1">
                    <div class="row">
                        <div class="col-12">
                            @foreach ($subcategories as $key => $subcategoryLoop)

                            <label class="containerRadio">{{ $subcategoryLoop->translationByLanguage($lang->id)->first()->name }}
                            <input type="checkbox" name="category" class="filter-checkbox-category" value="{{ $subcategoryLoop->id }}" {{ in_array($subcategoryLoop->id, $filter['categories']) ? 'checked' : '' }} {{ $subcategoryLoop->alias == Request::segment(4) ? 'checked' : '' }}>
                            <span class="checkmark color"></span>
                            </label>

                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
            @endif


            @if (!empty($properties))
                @foreach ($properties as $key => $property)
                    @if (checkProductInProprty($property->id, $products->pluck('id')))
                        @if ($property->type == 'select')
                        <div class="col-12 optionFiltr">
                            <div class="opt">{{ $property->translationByLanguage($lang->id)->first()->name }}</div>
                            <div class="optionFiltrOpen size1">
                                <div class="row">
                                    @if (!empty($property->multidata))
                                        @foreach ($property->multidata as $key => $multidata)
                                            @if (checkProductInProprtyValue($property->id, $multidata->id, $productsAll->pluck('id')))
                                            @php $value = getMultiDataList($multidata->id, $lang->id); @endphp
                                                @if ($value->name !== "0")
                                                    <div class="col-12">
                                                        <label class="containerRadio">{{ trim($value->value) }}
                                                        @if (array_key_exists($property->id.$value->property_multidata_id, $filter['properties']))
                                                        <input class="uk-checkbox filter-checkbox-property" checked
                                                            value="{{ $value->property_multidata_id }}" name="{{ $property->id }}" type="checkbox">
                                                        @else
                                                        <input class="uk-checkbox filter-checkbox-property" class="filter-checkbox" value="{{ $value->property_multidata_id }}" name="{{ $property->id }}" type="checkbox">
                                                        @endif
                                                        <span class="checkmark color"></span>
                                                        </label>
                                                    </div>
                                                @endif
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endforeach
        @endif
        <div class="col-12 optionFiltr">
          {{-- Price filter --}}
          <div class="opt submenuBcgMinus">
              {{ trans('front.ja.price') }}
          </div>
          <div class="optionFiltrOpen inputsFilter row">
              <input class="" id="curent-price-from" name="curentPrice" value="{{ array_key_exists('from', $filter['price']) ?  $filter['price']['from'] : ''  }}" placeholder="min">
              <input class="" id="curent-price-to" name="curentPrice" value="{{ array_key_exists('to', $filter['price']) ?  $filter['price']['to'] : ''  }}" placeholder="max">

              <input type="button" id="sendPrice" class="buttonSubmitFilter" value="ok" />
          </div>
        </div>

        </div>


        <div class="row">
            <div class="col-6">
                <div class="btnTransparent">
                    <a href="{{ url($lang->lang.'/filter/reset') }}">{{trans('front.ja.clearAll')}}</a>
                </div>
            </div>
            <div class="col-6">
                <div class="btnBrun closeFiltr">
                    {{trans('front.ja.cloose')}}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
