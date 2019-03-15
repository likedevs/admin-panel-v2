@php
$i = 0;
$s = 0;
$productsArr = [];
if (!$products->isEmpty()) {
    foreach ($products as $key => $value) {
        if (($key + 1) % 3 == 1) {
            $i = 0;
            $s++;
        }
        $i++;
        $productsArr[$s][$i] = $value;
    }
}
@endphp

@php $i = 0; @endphp
@if (count($productsArr) > 0)
    @foreach ($productsArr as $key => $productArr)
        @if ($key % 3 == 1)
            @php
                $i = 0;
            @endphp
        @endif

        @php $i++; @endphp

        @include('front.templatesProducts.template'.$i, ['productsList' => $productArr])
    @endforeach
@endif
