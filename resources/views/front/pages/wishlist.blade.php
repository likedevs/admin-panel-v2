@extends('front.app')

@section('content')
<div class="wrapp">
@include('front.partials.header', ['className' => 'oneHeader'])
<div class="cabDate wish">
    <div class="wishListBlock">
        @include('front.inc.wishListBlock')
    </div>
</div>

@include('front.partials.footer')
</div>
@stop
