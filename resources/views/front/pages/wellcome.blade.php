<!DOCTYPE html>
<html lang="ro">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-129451698-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-129451698-1');
    </script>
  <meta charset="utf-8">
  <meta name="robots" content="nofollow,noindex">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>JuliaAllert</title>
  <link rel="stylesheet" href="{{ asset('fronts/juliaExp/css/resets.css') }}">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <link rel="stylesheet" href="{{ asset('fronts/juliaExp/css/style.css') }}">
  <script src='https://www.google.com/recaptcha/api.js'></script>

</head>

<body>
  <div id="cover">
    <div class="imgBlock">
      <img src="{{ asset('fronts/juliaExp/img/image.png') }}" alt="">
    </div>
    <div class="mobile">
      <img src="{{ asset('fronts/juliaExp/img/mobile.png') }}" alt="">
    </div>
    <div class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-xl-4 col-lg-6 col-md-8 col-sm-10">
          <div class="row justify-content-center">
            <h3 class="col-auto">
              Register and receive Promo Code
            </h3>
          </div>
          <div class="row justify-content-center">
            <a href="{{ url($lang->lang.'/login/facebook') }}" class="col-auto logFace">
              login with facebook
            </a>
          </div>
          <div class="row justify-content-center">
            <a href="{{ url($lang->lang.'/login/google') }}" class="col-auto logGoogle">
              login with google
            </a>
          </div>
          <div class="row">
            <div class="col-12 titleForm">
              or fill in the form
            </div>
            <form action="{{ url($lang->lang.'/registration') }}" method="post"  class="col-12">
              {{ csrf_field() }}

              <input type="hidden" name="prev" value="{{url()->previous()}}">

              @if (Session::has('success'))
                  <div class="row">
                     <div class="col-12">
                        <div class="errorPassword text-center">
                           <p>{{ Session::get('success') }}</p>
                        </div>
                     </div>
                  </div>
              @endif
            {{-- <form action=""> --}}
              {{-- <div class="form-group">
                   <label for="name">First Name<b>*</b></label>
                   <input type="text" class="form-control" id="name" name="name" required placeholder="First Name ...">
                </div>
                <div class="form-group">
                     <label for="name1">Last Name<b>*</b></label>
                     <input type="text" class="form-control" id="name1" name="surname" required placeholder="Last Name ...">
                  </div>
                <div class="form-group">
                   <label for="email">Email<b>*</b></label>
                   <input type="text" class="form-control" id="email" name="email" required placeholder="Email ...">
                </div>
                <div class="form-group">
                   <label for="pwd">Password<b>*</b></label>
                   <input type="password" class="form-control" id="pwd" name="password" required placeholder="******">
                </div>
                <div class="form-group">
                   <label for="confpwd">Repeat password<b>*</b></label>
                   <input type="password" class="form-control" id="confpwd" name="passwordRepeat" required placeholder="******">
                </div> --}}

                @if (count($userfields) > 0)
                  @foreach ($userfields as $key => $userfield)
                      @if ($userfield->type != 'checkbox')
                          <div class="form-group">
                            <label for="{{$userfield->field}}">{{trans('front.register.'.$userfield->field)}}<b>*</b></label>
                            <input type="text" class="form-control" name="{{$userfield->field}}" id="{{$userfield->field}}" value="{{ old($userfield->field) }}">
                            @if ($errors->has($userfield->field))
                               <div class="invalid-feedback" style="display: block">
                                 {!!$errors->first($userfield->field)!!}
                               </div>
                            @endif
                          </div>
                      @endif
                  @endforeach
                @endif

                <div class="form-group">
                  <label for="pwd">{{trans('front.register.pass')}}<b>*</b></label>
                  <input type="password" class="form-control" name="password" id="pwd" >
                  @if ($errors->has('password'))
                     <div class="invalid-feedback" style="display: block">
                       {!!$errors->first('password')!!}
                     </div>
                  @endif
                </div>
                <div class="form-group">
                  <label for="confpwd">{{trans('front.register.repeatPass')}}<b>*</b></label>
                  <input type="password" class="form-control" name="passwordRepeat" id="confpwd" >
                  @if ($errors->has('passwordRepeat'))
                     <div class="invalid-feedback" style="display: block">
                       {!!$errors->first('passwordRepeat')!!}
                     </div>
                  @endif
                </div>

                <div class="row justify-content-center">
                    <div class="col-auto recaptha">
                        <span class="msg-error error"></span>
                        <div id="recaptcha" class="g-recaptcha " data-sitekey="6Le8034UAAAAAD8zhLNkJZwwrTlOLxMyStDN_J4K"></div>
                      </div>
                </div>
                <div class="row">
                  <div class="col-12">
                    <input type="submit" value="submit">
                  </div>
                </div>
            </form>
            <div class="col-12 titleForm">
              how to get and use promo code
            </div>
          </div>
        </div>
        <div class="footer col-12">
          <p>Register. You will receive an email with login and password, which will allow you to access the future site <span>www.juliaallert.com</span>. You will also receive an email with Promocode to get a 10% discount on your first shopping cart on the upcoming <span>www.juliaallert.com</span> site, which will be launched in a week!</p>
          <p>Once the future site is launched, you will be able to log in and enter the promocode you received by email at creating your first shopping cart. Success!</p>
          <p>Trully Yours, <br>
          Julia Allert</p>
          <div class="star"></div>
        </div>
      </div>
    </div>
    @if (Session::has('success'))
        <div class="modal" tabindex="-1" role="dialog" id="myModal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header text-center">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                    <div class="errorPassword text-center">
                        <h5 class="text-center">Congrats!</h5>
                         You successfully registered at www.juliaallert.com and received the promocode <b> {{ Session::get('success') }} </b> to get 10% off on first purchase at www.juliaallert.com, when the site will be launched.
                         <p>We’ve sent You an email with Your promocode. Enjoy Your shopping.</p>
                        <br>Truly Yours,
                        <br>Julia Allert
                       {{-- <p>{{ Session::get('success') }}</p> --}}
                    </div>
                </div>
              </div>
            </div>
          </div>

    @endif
  </div>





  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f.fbq)f.fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window,document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
 fbq('init', '1967232043325036');
fbq('track', 'PageView');
</script>
<noscript>
 <img height="1" width="1"
src="https://www.facebook.com/tr?id=1967232043325036&ev=PageView
&noscript=1"/>
</noscript>
<!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Ads: 878159902 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-878159902"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'AW-878159902');
</script>

<script>
  gtag('event', 'page_view', {
    'send_to': 'AW-878159902',
    'user_id': 'replace with value'
  });
</script>

<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
</body>

</html>
