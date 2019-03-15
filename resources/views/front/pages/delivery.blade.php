@extends('front.app')

    @section('content')
    <div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])

    <div class="blogContent">
        <div class="row">
            <div class="col-12 nav">
                <a href="{{url($lang->lang)}}">Home</a>/
                <a href="{{url($lang->lang.'/blogs')}}">{{ $page->translationByLanguage($lang->id)->title }}</a>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row justify-content-center">
                        <div class="col-auto blog">
                            <h3>{{ $page->translationByLanguage($lang->id)->title }}</h3>
                        </div>
                        <div class="col-12 at_delivery">
                            {!! $page->translationByLanguage($lang->id)->body !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front.partials.footer')
    </div>
    @stop
