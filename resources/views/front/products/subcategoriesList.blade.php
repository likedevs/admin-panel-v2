@extends('front.app')
@section('content')
<div class="wrapp">
    @include('front.partials.header', ['className' => ''])

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

    @include('front.filters.categoryFilter')

    <div class="cont">
        <div class="row">
            <div class="col-md-5 col-sm-9 col-12 padTop">
                <div class="row justify-content-center">
                    <div class="col-auto newArrival">
                        <h3>{{ $subcategory->translation($lang->id)->first()->name }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-3 filtrCollection2 padTop text-right">
                {{trans('front.ja.filter')}}
            </div>
            <div class="col-md-7 col-sm-10 col-12">
                <div class="row">
                    <div class="offset-md-1 col-md-7 col-12"></div>
                    <div class="col-md-4 padTop filtrCollection text-right">
                        {{trans('front.ja.filter')}}
                    </div>
                </div>
            </div>
        </div>

        <div class="responseProducts">

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

        <div class="load-more-area"></div>
        <div class="row justify-content-center">
            <div class="btnDetSilver col-xl-2 col-lg-4 col-md-6 col-8">
                <a href="#" class="load-more-btn" data-url="{{ $products->nextPageUrl() }}">{{trans('front.ja.loadMore')}}</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h5>{{trans('front.ja.usefullInfo')}}</h5>
        </div>
        <div class="col-12">
            <p>
                {{ $collection->translation($lang->id)->first()->seo_text }}
            </p>
        </div>
    </div>

    </div>

    @include('front.partials.footer')
</div>
@stop
