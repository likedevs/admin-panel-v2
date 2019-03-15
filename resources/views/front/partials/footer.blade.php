<?php
$phone = !is_null(getContactInfo('phone')->translation($lang->id)) ? getContactInfo('phone')->translation($lang->id)->value : '';
$email = !is_null(getContactInfo('emailfront')->translation($lang->id)) ?  getContactInfo('emailfront')->translation($lang->id)->value : '';
$viber = !is_null(getContactInfo('viber')->translation($lang->id)) ? getContactInfo('viber')->translation($lang->id)->value : '';
$pinterest = !is_null(getContactInfo('pinterest')->translation($lang->id)) ? getContactInfo('pinterest')->translation($lang->id)->value : '';
$facebook = !is_null(getContactInfo('facebook')->translation($lang->id)) ?  getContactInfo('facebook')->translation($lang->id)->value : '';
$instagram = !is_null(getContactInfo('instagram')->translation($lang->id)) ?  getContactInfo('instagram')->translation($lang->id)->value : '';
$linkedin = !is_null(getContactInfo('linkedin')->translation($lang->id)) ?  getContactInfo('linkedin')->translation($lang->id)->value : '';
$twitter = !is_null(getContactInfo('twitter')->translation($lang->id)) ? getContactInfo('twitter')->translation($lang->id)->value : '';
$youtube = !is_null(getContactInfo('youtube')->translation($lang->id)) ?  getContactInfo('youtube')->translation($lang->id)->value : '';
$google = !is_null(getContactInfo('google')->translation($lang->id)) ? getContactInfo('google')->translation($lang->id)->value : '';
$footerText = !is_null(getContactInfo('footertext')->translation($lang->id)) ? getContactInfo('footertext')->translation($lang->id)->value : '';
?>

<div class="foter">
  <div class="container">
    <div class="row">
      <div class="col-sm-3 col-12 foterItem">
        <h6>{{trans('front.ja.about')}} julia allert</h6>
        <ul>
          {{-- <li><a href="{{url($lang->lang.'/blogs')}}">{{trans('front.ja.blog')}}</a></li> --}}
          @if (count($footerMenus) > 0)
              @foreach ($footerMenus as $key => $footerMenu)
                  <li><a href="{{ url('/'.$lang->lang.'/'.$footerMenu->alias) }}">{{ $footerMenu->translationByLanguage($lang->id)->title }}</a></li>
              @endforeach
          @endif
        </ul>
      </div>
      <div class="col-sm-3 col-12 foterItem">
        <h6>{{trans('front.ja.products')}}</h6>
        <ul>
          <li><a href="#">{{trans('front.ja.products')}}</a></li>
          <li><a href="#">{{trans('front.ja.collections')}}</a></li>
          <li><a href="{{ url('/'.$lang->lang.'/catalog/outlet') }}">{{trans('front.ja.outlet')}}</a></li>
          <li><a href="{{ url('/'.$lang->lang.'/catalog/arrival') }}">{{trans('front.ja.arrival')}}</a></li>
        </ul>
      </div>
      <div class="col-sm-3 col-12 foterItem">
        <h6>{{trans('front.ja.usefullInfo')}}</h6>
        <ul>
            @if (count($headerMenus) > 0)
                @foreach ($headerMenus as $key => $headerMenu)
                    <li><a href="{{ url('/'.$lang->lang.'/'.$headerMenu->alias) }}">{{ $headerMenu->translationByLanguage($lang->id)->title }}</a></li>
                @endforeach
            @endif
        </ul>
      </div>
      <div class="col-sm-3 col-12 foterItem">
        <h6>{{ trans('front.ja.support') }}</h6>
        <ul>
            <li><a href="tel:{{ $phone }}">Tel.: {{ $phone }}</a></li>
            <li><a href="mailto:julia@gmail.com">Mail: {{ $email }}</a></li>
            <li><a href="viber:{{ $viber }}">Viber: {{ $viber }}</a></li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-3 dac">
        <h6>{{trans('front.ja.about')}} julia allert</h6>
        <ul>
            {{-- <li><a href="{{url($lang->lang.'/blogs')}}">{{trans('front.ja.blog')}}</a></li> --}}
            @if (count($headerMenus) > 0)
                @foreach ($headerMenus as $key => $headerMenu)
                    <li><a href="{{ url('/'.$lang->lang.'/'.$headerMenu->alias) }}">{{ $headerMenu->translationByLanguage($lang->id)->title }}</a></li>
                @endforeach
            @endif
        </ul>
      </div>
      <div class="col-3 dac">
          <h6>{{trans('front.ja.products')}}</h6>
          <ul>
            <li><a href="#">{{trans('front.ja.products')}}</a></li>
            <li><a href="#">{{trans('front.ja.collections')}}</a></li>
            <li><a href="{{ url('/'.$lang->lang.'/catalog/outlet') }}">{{trans('front.ja.outlet')}}</a></li>
            <li><a href="{{ url('/'.$lang->lang.'/catalog/arrival') }}">{{trans('front.ja.arrival')}}</a></li>
          </ul>
      </div>
      <div class="col-3 dac">
        <h6>{{trans('front.ja.usefullInfo2')}}</h6>
        <ul>
            @if (count($footerMenus) > 0)
                @foreach ($footerMenus as $key => $footerMenu)
                    <li><a href="{{ url('/'.$lang->lang.'/'.$footerMenu->alias) }}">{{ $footerMenu->translationByLanguage($lang->id)->title }}</a></li>
                @endforeach
            @endif
        </ul>
      </div>
      <div class="col-3 dac">
        <h6>{{ trans('front.ja.support') }}</h6>
        <ul>
          <li><a href="tel:+373 79000000">Tel.: {{ $phone }}</a></li>
          <li><a href="mailto:julia@gmail.com">Mail: {{ $email }}</a></li>
          <li><a href="viber:{{ $viber }}">Viber: {{ $viber }}</a></li>
        </ul>
      </div>
    </div>
    <div class="row justify-content-center ftRet">
      <div class="col-auto">
        <ul>
          <li><a href="{{ $facebook }}"><img src="{{ asset('fronts/img/icons/fw.png') }}" alt=""></a></li>
          <li><a href="{{ $instagram }}"><img src="{{ asset('fronts/img/icons/iw.png') }}" alt=""></a></li>
          {{-- <li><a href="{{ $twitter }}"><img src="{{ asset('fronts/img/icons/tw.png') }}" alt=""></a></li>
          <li><a href="{{ $linkedin }}"><img src="{{ asset('fronts/img/icons/inw.png') }}" alt=""></a></li>
          <li><a href="{{ $youtube }}"><img src="{{ asset('fronts/img/icons/yw.png') }}" alt=""></a></li>
          <li><a href="{{ $pinterest }}"><img src="{{ asset('fronts/img/icons/pw.png') }}" alt=""></a></li> --}}
        </ul>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-6 col-md-10">
        <p>{{ $footerText }}</p>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-auto">
        <img src="{{ asset('fronts/img/icons/foterLogo.png') }}" alt="">
      </div>
    </div>
    <div class="row justify-content-center margeTop2">
      <div class="col-auto">
        <p>©{{ date('Y') }} Julia Allert Website by <a style="color: #FFF;" href="https://likemedia.md">Like-Media</a> </p>
      </div>
    </div>
  </div>
</div>

<div class="modalRight">
  <div class="modal fade" id="modalSize">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row justify-content-end">
            <div class="col-auto">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          </div>
          <div class="row">
            <div class="col-12 textModal">

              @php
                  $page = getPage('sizes', $lang->id);
              @endphp

              @if (!is_null($page))
                  {!! $page->body !!}
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalDelivery">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="row justify-content-end">
            <div class="col-auto">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
          </div>
          <div class="row">
            <div class="col-12 textModal">

              @php
                  $page = getPage('delivery', $lang->id);
              @endphp

              {{-- {{ dd($page->body) }} --}}

              @if (!is_null($page))
                  {!! $page->body !!}
              @endif

              {{-- <h6>
                Livrare
              </h6>
              <p>Livrare: măsurarea ar trebui făcută direct pe corp. Pentru a găsi mărimea perfectă pentru cămăși, trebuie să fiți sigur că gulerul vă vine corect. Luați o cămașă care vă vine bine și măsurați gulerul de la mijlocul nasturelui până la capătul
                butonierei.
              </p>
              <p>Plata: măsurarea ar trebui făcută direct pe corp. Pentru a găsi mărimea perfectă pentru cămăși, trebuie să fiți sigur că gulerul vă vine corect. Luați o cămașă care vă vine bine și măsurați gulerul de la mijlocul nasturelui până la capătul
                butonierei.
              </p> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="cartPop"></div>
