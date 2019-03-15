@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control panel</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontusers.index') }}">Front Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Front User</li>
    </ol>
</nav>

<div class="title-block">
    <h3 class="title"> Edit Front User </h3>
    @include('admin::admin.list-elements', [
    'actions' => [
    trans('variables.add_element') => route('frontusers.create'),
    ]
    ])
</div>


    <div class="list-content">
        <div class="tab-area">
            @include('admin::admin.alerts')
        </div>

        <form class="form-reg" role="form" method="POST" action="{{ route('frontusers.update', $user->id) }}" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PATCH') }}
          <div class="part left-part">
            <h3>Personal Information</h3>
            <ul>
                <li>
                    <label for="name">Name</label>
                    <input type="text" name="name" class="name" id="name" value="{{$user->name}}">
                </li>
                <li>
                    <label for="surname">Surname</label>
                    <input type="text" name="surname" class="name" id="surname" value="{{$user->surname}}">
                </li>
                <li>
                    <label for="email">Email</label>
                    <input type="email" name="email" class="name" id="email" value="{{$user->email}}">
                </li>
                <li>
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="name" id="phone" value="{{$user->phone}}">
                </li>
                <li>
                    <label for="date">Birthday</label>
                    <input type="date" name="birthday" class="name" id="date" value="{{$user->birthday}}">
                </li>
                <li>
                    <label for="terms_agreement">Terms_agreement</label>
                    <input type="checkbox" name="terms_agreement" class="name" id="terms_agreement" {{$user->terms_agreement == 1 ? 'checked' : ''}}>
                </li>
                <li>
                    <label for="promo_agreement">Promo_agreement</label>
                    <input type="checkbox" name="promo_agreement" class="name" id="promo_agreement" {{$user->promo_agreement == 1 ? 'checked' : ''}}>
                </li>
                <li>
                    <label for="personaldata_agreement">Personaldata_agreement</label>
                    <input type="checkbox" name="personaldata_agreement" class="name" id="personaldata_agreement" {{$user->personaldata_agreement == 1 ? 'checked' : ''}}>
                </li>
                <li>
                  <label>Date of Registration: {{$user->created_at}}</label>
                </li>
                <li>
                  <label>Language: {{getLangById($user->lang)->lang}}</label>
                </li>
                <li>
                    <input type="submit" value="{{trans('variables.save_it')}}">
                </li>
            </ul>
          </div>
        </form>

        <div class="part right-part">
            <h3>Address Information</h3>
            <div class="address">
              <ul>
                  @if (count($user->addresses()->get()) > 0)
                      @foreach ($user->addresses()->get() as $key => $address)
                          <li>
                              <label>{{$address->addressname}}</label>
                              <input type="button" data-toggle="modal" data-target="#modalCart{{$address->id}}" name="updateBtn" value="Update">
                              <form action="{{ route('frontusers.deleteAddress', [$user->id, $address->id]) }}" method="post">
                                  {{ csrf_field() }} {{ method_field('DELETE') }}
                                  <input type="submit" name="deleteBtn" value="Delete">
                              </form>
                          </li>
                      @endforeach
                  @endif
              </ul>
              <input type="button" data-toggle="modal" data-target="#modalCart" name="updateBtn" value="Add address">
            </div>
        </div>
    </div>

    <!-- MODALKA Update address-->
      @if(count($user->addresses()->get()) > 0)
        @foreach ($user->addresses()->get() as $address)
          <div class="modal" id="modalCart{{$address->id}}">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">{{trans('front.cart.addAddressBtn')}}</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <form method="post" action="{{ route('frontusers.updateAddress', [$user->id, $address->id]) }}">
                    {{ csrf_field() }}
                    <div class="row frAdr">
                      <div class="address">
                        @include('admin::admin.frontusers.editAddress')
                      </div>

                    </div>
                  </div>

                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('front.cart.closeBtn')}}</button>
                    <input type="submit" value="{{trans('front.cart.addAddressBtn')}}">
                  </div>
              </form>
              </div>
            </div>
          </div>
        @endforeach
      @endif
    <!-- MODALKA -->

    <!-- MODALKA Add address-->
    <div class="modal" id="modalCart">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">{{trans('front.cart.addAddressBtn')}}</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form method="post" action="{{ route('frontusers.addAddress', $user->id) }}">
              {{ csrf_field() }}
              <div class="row frAdr">

                <div class="address">
                  @include('admin::admin.frontusers.address')
                </div>

              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">{{trans('front.cart.closeBtn')}}</button>
              <input type="submit" value="{{trans('front.cart.addAddressBtn')}}">
            </div>
        </form>
        </div>
      </div>
    </div>
    <!-- MODALKA -->
@stop

@section('footer')
    <footer>
        @include('admin::admin.footer')
    </footer>
@stop
