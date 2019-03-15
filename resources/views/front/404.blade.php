@extends('front.app')
@section('content')
@include('front.partials.header', ['className' => 'oneHeader'])

<div class="fourError blogContent">
    <div class="row">
        <div class="col-12 nav">
            <a href="{{url($lang->lang)}}">Home</a>/
            <a href="#">Page not found</a>
        </div>
    </div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-sm-8 four">
          <img src="{{ asset('images/404.png') }}">
          <p>The link you clicked may be broken or the page may have been removed.</p>
          <a href="{{ url('/'.$lang->lang) }}" class="btnError">back to home page</a>
        </div>
      </div>
    </div>
</div>

@include('front.partials.footer')
@stop
