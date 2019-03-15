@extends('front.app')
@section('content')
<div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="blog">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 blogImg">
                    <img src="{{asset('fronts/img/products/blogImg.png')}}" style="width: 100%;" alt="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-auto">
                    <h3>{{trans('front.ja.blog')}}</h3>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-10">
                            <div class="blOptions">
                                <div class="btnBlog">
                                    {{trans('front.ja.theMostPopular')}}
                                </div>
                                <div class="blogOptions">
                                    @if (count($blogCategories) > 0)
                                    @foreach ($blogCategories as $category)
                                    <div class="option filterBlogs" data-id="{{$category->id}}">{{$category->translationByLanguage($lang->id)->first()->name}}</div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row blogs">
                        @include('front.blogs.items')
                    </div>
                </div>
                <div class="col-12">
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 col-10">
                            <div class="readMore">
                                <a href="#" id="addMoreBlogs" data-id="0">{{trans('front.ja.viewDetails')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <h5>{{trans('front.ja.theMostPopular')}}</h5>
                </div>
                <div class="col-12">
                    @if (count($randomPosts) > 0)
                    <div class="slideMob">
                        @foreach ($randomPosts as $randomPost)
                        <div class="blogItem">
                            @if ($randomPost->translationByLanguage($lang->id)->first()->image)
                            <img src="{{ asset('images/posts/'.$randomPost->translationByLanguage($lang->id)->first()->image) }}" alt="{{$randomPost->translationByLanguage($lang->id)->first()->image_alt}}" title="{{$randomPost->translationByLanguage($lang->id)->first()->image_title}}" class="itemImg">
                            @else
                            <img src="{{ asset('images/no-image.png') }}" alt="img-advice">
                            @endif
                            <div class="blogAnnonce">
                                <a href="{{ url($lang->lang.'/blogs/'.$randomPost->category->translationByLanguage($lang->id)->first()->slug.'/'.$randomPost->translationByLanguage($lang->id)->first()->url) }}">{{$randomPost->translationByLanguage($lang->id)->first()->title}}</a>
                            </div>
                            <div class="blogButton">
                                <div class="btnGrey">
                                    <a href="{{ url($lang->lang.'/blogs/'.$randomPost->category->translationByLanguage($lang->id)->first()->slug.'/'.$randomPost->translationByLanguage($lang->id)->first()->url) }}">Citeste articol</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                <div class="col-12">
                    <h5>{{trans('front.ja.usefullInfo')}}</h5>
                </div>
                <div class="col-12">
                    <p>Lorem Ipsum este pur şi simplu o machetă pentru text a industriei tipografice. Lorem Ipsum a fost macheta standard a industriei încă din secolul al XVI-lea, când un tipograf anonim a luat o planşetă de litere şi le-a amestecat pentru a crea
                        o carte demonstrativă pentru literele respective. Nu doar că a supravieţuit timp de cinci secole, dar şi a facut saltul în tipografia electronică practic neschimbată. A fost popularizată în anii '60 odată cu ieşirea colilor Letraset care
                        conţineau pasaje Lorem Ipsum, iar mai recent, prin programele de publicare pentru calculator, ca Aldus PageMaker care includeau versiuni de Lorem Ipsum.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
