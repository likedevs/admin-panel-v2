@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')

  <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control panel</a></li>
          <li class="breadcrumb-item"><a href="{{ route('frontusers.index') }}">Front Users</a></li>
          <li class="breadcrumb-item active" aria-current="page">Create Front User</li>
      </ol>
  </nav>

  <div class="title-block">
      <h3 class="title"> Create Front User </h3>
      @include('admin::admin.list-elements', [
      'actions' => [
      trans('variables.add_element') => route('frontusers.create'),
      ]
      ])
  </div>

    @if (count($countries) > 0)
      <div class="list-content">
          <div class="tab-area">
              @include('admin::admin.alerts')
          </div>
          <form class="form-reg" role="form" method="POST" action="{{ route('frontusers.store') }}" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="part left-part">
                  <h3>Personal Information</h3>
                  <ul>
                      <li>
                          <label for="name">Name</label>
                          <input type="text" name="name" class="name" id="name" value="{{old('name')}}">
                      </li>
                      <li>
                          <label for="surname">Surname</label>
                          <input type="text" name="surname" class="name" id="surname" value="{{old('surname')}}">
                      </li>
                      <li>
                          <label for="email">Email</label>
                          <input type="email" name="email" class="name" id="email" value="{{old('email')}}">
                      </li>
                      <li>
                          <label for="phone">Phone</label>
                          <input type="text" name="phone" class="name" id="phone" value="{{old('phone')}}">
                      </li>
                      <li>
                          <label for="date">Birthday</label>
                          <input type="date" name="birthday" class="name" id="date" value="{{old('birthday')}}">
                      </li>
                      <li>
                          <label for="terms_agreement">Terms_agreement</label>
                          <input type="checkbox" name="terms_agreement" class="name" id="terms_agreement" {{old('terms_agreement') ? 'checked': '' }}>
                      </li>
                      <li>
                          <label for="promo_agreement">Promo_agreement</label>
                          <input type="checkbox" name="promo_agreement" class="name" id="promo_agreement" {{old('promo_agreement') ? 'checked': '' }}>
                      </li>
                      <li>
                          <label for="personaldata_agreement">Personaldata_agreement</label>
                          <input type="checkbox" name="personaldata_agreement" class="name" id="personaldata_agreement" {{old('personaldata_agreement') ? 'checked': '' }}>
                      </li>
                      <li>
                          <label for="password">Password</label>
                          <input type="password" name="password" class="name" id="password">
                      </li>
                      <li>
                          <label for="repeatpassword">Repeat Password</label>
                          <input type="password" name="repeatpassword" class="name" id="repeatpassword">
                      </li>
                  </ul>
              </div>
              <div class="part right-part">
                  <h3>Address Information</h3>
                  <div class="address">
                    @include('admin::admin.frontusers.address')
                  </div>
              </div>
              <ul>
                  <div class="row">
                      <div class="col-md-6">
                          <li>
                              <input type="submit" value="{{trans('variables.save_it')}}">
                          </li>
                      </div>
                  </div>
              </ul>
          </form>
      </div>
    @else
      <div class="empty-response">{{trans('variables.list_is_empty')}}</div>
    @endif
@stop

@section('footer')
    <footer>
        @include('admin::admin.footer')
    </footer>
@stop
