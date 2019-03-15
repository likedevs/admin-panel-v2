@extends('front.app')
@section('content')
    @include('front.partials.header', ['className' => 'oneHeader'])
    <div class="cart cabDate">
           <div class="container">
               <div class="row justify-content-center comandSucces">
                    <div class="col-auto">
                      {{trans('front.ja.shopingCart') }}
                    </div>
                </div>

            @if (count($cartProducts) == 0 && count($cartSets) == 0)
              <div class="responseCartBlock">
                  <h3 class="text-center">Cosul este gol</h3>
              </div>
            @else
              <div class="responseCartBlock">
                  @include('front.inc.cartBlock')
              </div>

              <div class="deliveryCart">
                 <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 1) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 2) }}</p>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 3) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 4) }}</p>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 5) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 6) }}</p>
                       </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-12">
                       <div class="deliveryItem">
                          <div class="deliveryTitle">
                             {{ Label($page->id, $lang->id, 7) }}
                          </div>
                          <p>{{ Label($page->id, $lang->id, 8) }}</p>
                       </div>
                    </div>
                 </div>
              </div>

              <div class="deliveryDetail">
                  <cart :user="{{json_encode($userdata)}}" />
              </div>
            @endif
        </div>
    </div>



    <div class="modal" id="loginModal">
        <div class="modal-dialog">
            <div class="modal-content regBox">
                <!-- Modal Header -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body" style="padding-top: 10px; ">

                    <div class="regBox">

                      <div class="row">
                        <div class="col-12">
                          <h4><strong>{{trans('front.ja.signIn')}}</strong></h4></div>
                      </div>
                      <div class="row" style="margin-bottom: 10px;">
                        <div class="col-12">
                          {{trans('front.ja.dontHaveAccount')}} <a href="{{url($lang->lang.'/register')}}"> {{trans('front.ja.signUp')}}</a>
                        </div>
                      </div>
                      <login />
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front.partials.footer')
    {{-- <script>
        $(document).on('scroll', function(){
          var height = $('.summarComanda').offset();

          if ($(window).scrollTop() > height.top) {
              $(".fixedForm").addClass('fixedBlock');
          }

          if($(window).scrollTop() < height.top){
              $(".fixedForm").removeClass('fixedBlock');
          }
        });
    </script> --}}
@stop
