@extends('front.app')
@section('content')
<div class="wrapp">
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="blogContent">
        <div class="row">
            <div class="col-12 nav">
                <a href="{{url($lang->lang)}}">Home</a>/
                <a href="{{url($lang->lang.'/blogs')}}">Blog</a>/
                <a href="{{url($lang->lang.'/blogs/'.$blog->translationByLanguage($lang->id)->first()->url) }}">{{$blog->translationByLanguage($lang->id)->first()->title}}</a>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-auto blog">
                            <h3>{{$blog->translationByLanguage($lang->id)->first()->title}}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    @if ($blog->translationByLanguage($lang->id)->first()->image)
                    <img src="{{ asset('images/posts/'.$blog->translationByLanguage($lang->id)->first()->image) }}" alt="{{$blog->translationByLanguage($lang->id)->first()->image_alt}}" title="{{$blog->translationByLanguage($lang->id)->first()->image_title}}" class="itemImg" style="width: 100%; margin: 10px 0;">
                    @else
                    <img src="{{ asset('images/no-image.png') }}" alt="img-advice" style="width: 100%; margin: 10px 0;">
                    @endif
                    <p>{!!$blog->translationByLanguage($lang->id)->first()->body!!}</p>
                </div>
                <div class="col-3 articles">
                    <div class="artRecente">
                        <h5>{{trans('front.ja.recentPosts')}}</h5>
                        @if (count($recentPosts) > 0)
                        <ul class="d-flex flex-column">
                            @foreach ($recentPosts as $recentPost)
                            <a href="{{ url($lang->lang.'/blogs/'.$recentPost->category->translationByLanguage($lang->id)->first()->slug.'/'.$recentPost->translationByLanguage($lang->id)->first()->url) }}">{{$recentPost->translationByLanguage($lang->id)->first()->title}}</a>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    <div class="chooseCatArt">
                        <h5>{{trans('front.ja.chooseCategory')}}</h5>
                        @if (count($blogCategories) > 0)
                        @foreach ($blogCategories as $category)
                        <a href="{{url($lang->lang.'/blogs/'.$category->translationByLanguage($lang->id)->first()->slug)}}">
                            <div class="option">{{$category->translationByLanguage($lang->id)->first()->name}}</div>
                        </a>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="row productOne">
                <div class="col-12">
                    <h5>{{trans('front.ja.chooseCategory')}}</h5>
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
                                    <a href="{{ url($lang->lang.'/blogs/'.$randomPost->category->translationByLanguage($lang->id)->first()->slug.'/'.$randomPost->translationByLanguage($lang->id)->first()->url) }}">{{$randomPost->translationByLanguage($lang->id)->first()->title}}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            <div class="articlesMobile">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <div class="chooseCatMobile">
                                <div class="chCat">
                                    {{trans('front.ja.chooseCategory')}}
                                </div>
                                <div class="chooseCatOpenMob dspNone">
                                    <div class="row justify-content-end" style="padding: 0 25px;">
                                        <div class="closeModalMenu"><img src="{{asset('fronts/img/icons/closeModal.png')}}" alt=""></div>
                                    </div>
                                    @if (count($blogCategories) > 0)
                                    @foreach ($blogCategories as $category)
                                    <a href="{{ url($lang->lang.'/blogs/'.$category->translationByLanguage($lang->id)->first()->slug) }}">
                                        <div class="option1 bcgDropBlog">{{$category->translationByLanguage($lang->id)->first()->name}}</div>
                                    </a>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="artRecenteMobile">
                                <div class="chCat2">
                                    {{trans('front.ja.inspiration')}}
                                </div>
                                <div class="chooseCatOpenMob2 dspNone">
                                    <div class="row justify-content-end" style="padding: 0 25px;">
                                        <div class="closeModalMenu"><img src="{{asset('fronts/img/icons/closeModal.png')}}" alt=""></div>
                                    </div>
                                    @if (count($recentPosts) > 0)
                                    <ul class="d-flex flex-column">
                                        @foreach ($recentPosts as $recentPost)
                                        <a href="{{ url($lang->lang.'/blogs/'.$recentPost->category->translationByLanguage($lang->id)->first()->slug.'/'.$recentPost->translationByLanguage($lang->id)->first()->url) }}">{{$recentPost->translationByLanguage($lang->id)->first()->title}}</a>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('front.partials.footer')
</div>
@stop
