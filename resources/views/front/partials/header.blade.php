<div class="header {{ $className }} widthDrop">
    <div class="menuMobile">
        <div class="row">
            <div class="col-2 burgerHome">
                <div class="burger">
                </div>
                <div class="submenu6 kakta">
                    <div class="row justify-content-end">
                        <div class="col-1">
                            <div class="closeModalMenu4"></div>
                        </div>
                    </div>
                    <ul>
                        <li class="submenuButton" onclick="closeNav(event)">
                            {{trans('front.ja.products')}}
                            <div class="submenu2">
                                <ul>
                                    @if (count($categoriesMenu))
                                    @foreach ($categoriesMenu as $key => $categoryItem)
                                    @if (count($categoryItem->children()->get()) > 0)
                                    <li class="submenuButton">
                                        <a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias) }}">
                                         {{ $categoryItem->translation($lang->id)->first()->name }}
                                     </a>
                                        <div class="submenu2">
                                            <ul>
                                                @foreach ($categoryItem->children()->get() as $key => $categoryItem2)
                                                <li>
                                                    <a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias.'/'.$categoryItem2->alias) }}">
                                                        {{ $categoryItem2->translation($lang->id)->first()->name }}
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </li>
                                    @else
                                    <li>
                                        <a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias) }}"> {{ $categoryItem->translation($lang->id)->first()->name }}</a>
                                    </li>
                                    @endif
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li class="submenuButton" onclick="closeNav(event)">
                            {{trans('front.ja.collections')}}
                            <div class="submenu2">
                                <ul>
                                    @if (count($collectionsMenu))
                                    @foreach ($collectionsMenu as $key => $collectionItem)
                                    <li class="submenuButton">
                                        <a href="{{ url($lang->lang.'/collection/'.$collectionItem->alias) }}">
                                            {{ $collectionItem->translation($lang->id)->first()->name }}
                                        </a>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                        </li>
                        <li><a href="{{ url('/'.$lang->lang.'/catalog/outlet') }}">{{trans('front.ja.outlet')}}</a></li>
                        <li><a href="{{ url('/'.$lang->lang.'/catalog/arrival') }}">{{trans('front.ja.arrival')}}</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-4 col-2 logoHome">
                <a href="{{ url('/'.$lang->lang) }}"><div class="logoJuliaAlert"></div></a>
            </div>
            <div class="col-sm-6 col-8">
                <div class="menuRight">
                    <ul>
                        <li class="modalButton1"></li>
                        <div class="modalOpen1">
                            <div class="row justify-content-end">
                                <div class="col-auto">
                                    <div class="closeModalMenu1"></div>
                                </div>
                            </div>

                            <form action="{{ url($lang->lang.'/search') }}" method="get">
                                <div class="row justify-content-center">
                                    <div class="col-12">
                                        <input type="text" name="search" class="search-field" placeholder="{{trans('front.ja.searchProduct')}}" autocomplete="off">
                                        <ul class="autocomplete"></ul>
                                    </div>
                                  <div class="col-11">
                                      <div class="btnGrey">
                                          <input type="submit" value="{{trans('front.ja.search')}}">
                                      </div>
                                  </div>
                              </div>
                          </form>
                        </div>

                        <li class="modalButton2"></li>
                        <div class="modalOpen2">
                         <div class="row justify-content-end">
                           <div class="col-12">
                             <div class="row justify-content-end">
                                 <div class="col-auto">
                                     <div class="closeModalMenu2"></div>
                                 </div>
                             </div>
                           </div>
                         @if(Auth::guard('persons')->check())
                           <div class="col-12" style="font-weight: bold; font-size: 20px;">
                             {{trans('front.ja.hello')}} {{Auth::guard('persons')->user()->name}} {{Auth::guard('persons')->user()->surname}}
                           </div>
                           <div class="col-12 borderBottom">
                             <h6>{{trans('front.ja.myAccount')}}</h6>
                           </div>
                           <div class="col-12 welcomeJa">{{trans('front.ja.wellcome')}} Julia Alert</div>
                           <div class="col-12">
                             <ul>
                               {{trans('front.ja.signIn')}}
                               <li><a href="{{route('cabinet')}}">{{trans('front.cabinet.userdata')}}</a></li>
                               <li><a href="{{route('cart')}}">{{trans('front.cabinet.cart')}}</a></li>
                               <li><a href="{{route('cabinet.wishList')}}">{{trans('front.cabinet.wishList')}}</a></li>
                               <li><a href="{{route('cabinet.history')}}">{{trans('front.cabinet.history')}}</a></li>
                               <li><a href="{{route('cabinet.return')}}">{{trans('front.cabinet.return')}}</a></li>
                               <li><a href="{{url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a></li>
                             </ul>
                           </div>
                         @else
                           <div class="col-12 welcomeJa">{{trans('front.ja.wellcome')}} Julia Alert</div>
                           <div class="col-12">
                             <a href="{{url($lang->lang.'/login')}}">
                               <div class="btnBrun">
                                 {{trans('front.ja.signIn')}}
                               </div>
                             </a>
                           </div>
                           <div class="col-12 borderBottom">
                             <div class="row justify-content-between align-items-center">
                               <div class="col-6">
                                 {{trans('front.ja.signWith')}}
                               </div>
                               <div class="col-6 contRet">
                                 <a href="{{url($lang->lang.'/login/facebook')}}"><img src="{{asset('fronts/img/icons/facebook.svg')}}" alt=""></a>
                                 <a href="{{url($lang->lang.'/login/google')}}"><img src="{{asset('fronts/img/icons/gg.svg')}}" alt=""></a>
                               </div>
                             </div>
                           </div>
                           <div class="col-12">
                             <div class="row">
                               <div class="col-12" style="margin-top: 20px;">
                                 {{trans('front.ja.newClient')}}?
                               </div>
                             </div>
                           </div>
                           <div class="col-12">
                             <a href="{{url($lang->lang.'/registration')}}">
                               <div class="btnGrey">
                                 {{trans('front.ja.signUp')}}
                               </div>
                             </a>
                           </div>
                         @endif
                         </div>
                        </div>

                        <li class="modalButton3">
                            <div class="cartNumber nrProducts">{{ count($cartProducts) + count($cartSets) }}</div>
                        </li>
                        <div class="modalOpen3 cart-area">
                            @include('front.inc.cartBox')
                        </div>

                        <div class="wishCount">
                          @include('front.inc.wishListCount')
                        </div>

                        <div class="modalOpen4 wish-area">
                          @include('front.inc.wishListBox')
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="mainMenu">
        <ul>
            <li>
                <a href="#">{{trans('front.ja.products')}}</a>
                <div class="submenu kakta">
                    <ul>
                        @if (count($categoriesMenu))
                        @foreach ($categoriesMenu as $key => $categoryItem)
                        @if (count($categoryItem->children()->get()) > 0)
                        <li class="submenuButton" onclick="closeNav(event)">
                            {{ $categoryItem->translation($lang->id)->first()->name }}
                            <div class="submenu2">
                                <ul>
                                    @foreach ($categoryItem->children()->get() as $key => $categoryItem2)
                                    <li><a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias.'/'.$categoryItem2->alias) }}">{{ $categoryItem2->translation($lang->id)->first()->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                        @else
                        <li><a href="{{ url($lang->lang.'/catalog/'.$categoryItem->alias) }}">{{ $categoryItem->translation($lang->id)->first()->name }}</a></li>
                        @endif
                        @endforeach
                        @endif
                    </ul>
                </div>
            </li>
            <li>
                <a href="#">{{trans('front.ja.collections')}}</a>
                <div class="submenuCollection kakta">
                    <ul>
                        @if (count($collectionsMenu))
                        @foreach ($collectionsMenu as $key => $collectionItem)
                        <li><a href="{{ url($lang->lang.'/collection/'.$collectionItem->alias) }}">{{ $collectionItem->translation($lang->id)->first()->name }}</a></li>
                        @endforeach
                        @endif
                    </ul>
                </div>
            </li>
            <li><a href="{{ url('/'.$lang->lang.'/catalog/outlet') }}">{{trans('front.ja.outlet')}}</a></li>
            <li><a href="{{ url('/'.$lang->lang.'/catalog/arrival') }}">{{trans('front.ja.arrival')}}</a></li>
            <li><a href="{{ url('/'.$lang->lang) }}"></a></li>
        </ul>
    </div>
    <div class="menuRight menuNone menuRightMedium">
        <ul>
            <li class="modalButton1"></li>
            <div class="modalOpen1">
                <div class="row justify-content-end">
                    <div class="col-1">
                        <div class="closeModalMenu1"></div>
                    </div>
                </div>

                <form action="{{ url($lang->lang.'/search') }}" method="get">
                  <div class="row justify-content-center">
                    <div class="col-12">
                        <input type="text" name="search" class="search-field" placeholder="{{trans('front.ja.searchProduct')}}" autocomplete="off">
                        <ol class="autocomplete"></ol>
                    </div>
                  </div>
                  <div class="row justify-content-center">
                    <div class="col-11">
                        <div class="btnGrey">
                            <input type="submit" value="{{trans('front.ja.search')}}">
                        </div>
                    </div>
                  </div>
              </form>
            </div>
            <li class="modalButton2"></li>
            <div class="modalOpen2">
              <div class="row justify-content-end">
                <div class="col-2">
                  <div class="closeModalMenu2"></div>
                </div>
              </div>
              <div class="row">
                @if(Auth::guard('persons')->check())
                  <div class="col-12">
                    {{trans('front.ja.hello')}} {{Auth::guard('persons')->user()->name}} {{Auth::guard('persons')->user()->surname}}
                  </div>
                  <div class="col-12 borderBottom">
                    <h6>{{trans('front.ja.myAccount')}}</h6>
                  </div>
                  <div class="col-12" style="margin-top: 20px;">{{trans('front.ja.wellcome')}} Julia Alert</div>
                  <div class="col-12">
                    <ul>
                      {{trans('front.ja.signIn')}}
                      <li><a href="{{route('cabinet')}}">{{trans('front.cabinet.userdata')}}</a></li>
                      <li><a href="{{route('cart')}}">{{trans('front.cabinet.cart')}}</a></li>
                      <li><a href="{{route('cabinet.wishList')}}">{{trans('front.cabinet.wishList')}}</a></li>
                      <li><a href="{{route('cabinet.history')}}">{{trans('front.cabinet.history')}}</a></li>
                      <li><a href="{{route('cabinet.return')}}">{{trans('front.cabinet.return')}}</a></li>
                      <li><a href="{{url($lang->lang.'/logout')}}">{{trans('front.header.logout')}}</a></li>
                    </ul>
                  </div>
                @else
                  <div class="col-12" style="margin-top: 20px;">{{trans('front.ja.wellcome')}} Julia Alert</div>
                  <div class="col-12">
                    <a href="{{url($lang->lang.'/login')}}">
                      <div class="btnBrun">
                        {{trans('front.ja.signIn')}}
                      </div>
                    </a>
                  </div>
                  <div class="col-12 borderBottom">
                    <div class="row justify-content-between align-items-center">
                      <div class="col-6">
                        {{trans('front.ja.signWith')}}
                      </div>
                      <div class="col-6 contRet">
                        <a href="{{url($lang->lang.'/login/facebook')}}"><img src="{{asset('fronts/img/icons/facebook.svg')}}" alt=""></a>
                        <a href="{{url($lang->lang.'/login/google')}}"><img src="{{asset('fronts/img/icons/gg.svg')}}" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="row">
                      <div class="col-12" style="margin-top: 20px;">
                        {{trans('front.ja.newClient')}}?
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <a href="{{url($lang->lang.'/registration')}}">
                      <div class="btnGrey">
                        {{trans('front.ja.signUp')}}
                      </div>
                    </a>
                  </div>
                @endif
              </div>
            </div>
            <li class="modalButton3">
                <div class="cartNumberOne nrProducts">{{ count($cartProducts) + count($cartSets) }}</div>
            </li>
            <div class="modalOpen3 cart-area">
                @include('front.inc.cartBox')
            </div>
            <div class="wishCount">
              @include('front.inc.wishListCount')
            </div>
            <div class="modalOpen4 wish-area">
              @include('front.inc.wishListBox')
            </div>
            <li class="lang header-lang-swich" style="display: block;">{{ mb_strtoupper($lang->lang) }}</li>
              <div class="langOpen">
                 <ul>
                    <?php $pathWithoutLang = pathWithoutLang(Request::path(), $langs);?>
                    @if (!empty($langs))
                        @foreach ($langs as $key => $oneLang)
                            <li>
                              <a href="{{ url($oneLang->lang.'/'.$pathWithoutLang) }}" class="{{Request::segment(1) == $oneLang->lang ? 'active': ''}}">{{ $oneLang->lang }}</a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </ul>
    </div>
</div>
