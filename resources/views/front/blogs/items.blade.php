@if (count($blogs) > 0)
@foreach ($blogs as $blog)
<div class="col-lg-4 col-md-6 col-sm-12">
    <div class="blogItem">
        @if ($blog->translationByLanguage($lang->id)->first()->image)
        <img src="{{ asset('images/posts/'.$blog->translationByLanguage($lang->id)->first()->image) }}" alt="{{$blog->translationByLanguage($lang->id)->first()->image_alt}}" title="{{$blog->translationByLanguage($lang->id)->first()->image_title}}" class="itemImg">
        @else
        <img src="{{ asset('images/no-image.png') }}" alt="img-advice">
        @endif
        <div class="blogAnnonce">
            <a href="{{ url($lang->lang.'/blogs/'.$blog->category->translationByLanguage($lang->id)->first()->slug.'/'.$blog->translationByLanguage($lang->id)->first()->url) }}">{{$blog->translationByLanguage($lang->id)->first()->title}}</a>
        </div>
        <div class="blogButton">
            <div class="btnGrey">
                <a href="{{ url($lang->lang.'/blogs/'.$blog->category->translationByLanguage($lang->id)->first()->slug.'/'.$blog->translationByLanguage($lang->id)->first()->url) }}">{!!substr($blog->translationByLanguage($lang->id)->first()->body, 0, 100) . '...'!!}</a>
            </div>
        </div>
    </div>
</div>
@endforeach
@endif
