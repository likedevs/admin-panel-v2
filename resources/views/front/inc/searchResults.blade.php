@if (count($products) > 0)
    @foreach ($products as $key => $product)
        <li>
            <a href="{{ url($lang->lang.'/catalog/'.getProductLink($product->category_id).$product->alias) }}">
                {!! str_ireplace($search, '<i>'.$search.'</i>', $product->translationByLanguage($lang->id)->first()->name) !!}
            </a>
        </li>
    @endforeach
@endif
