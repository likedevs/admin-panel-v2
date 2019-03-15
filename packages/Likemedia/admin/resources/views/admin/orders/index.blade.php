@extends('admin::admin.app')
@include('admin::admin.nav-bar')
@include('admin::admin.left-menu')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/back') }}">Control Panel</a></li>
        <li class="breadcrumb-item active" aria-current="brand">Orders </li>
    </ol>
</nav>

<br>

<div class="title-block">
    <h3 class="title"> Orders </h3>
    @include('admin::admin.list-elements', [
    'actions' => [
      trans('variables.elements_list') => route('order.index'),
      trans('variables.add_element') => route('order.create'),
    ]
    ])
</div>

@include('admin::admin.alerts')

<div class="row filterOrders">
  <label class="radio-inline radPlus">
    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" checked value="pending">
    <span class="spanRad">{{trans('front.cabinet.historyOrder.pending')}} </span>
  </label>
  <label class="radio-inline radPlus">
    <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="processing">
    <span class="spanRad">{{trans('front.cabinet.historyOrder.processing')}} </span>
  </label>
  <label class="radio-inline radPlus">
    <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="inway">
    <span class="spanRad">{{trans('front.cabinet.historyOrder.inway')}} </span>
  </label>
  <label class="radio-inline radPlus">
    <input type="radio" name="inlineRadioOptions" id="inlineRadio3" value="completed">
    <span class="spanRad">{{trans('front.cabinet.historyOrder.completed')}} </span>
  </label>
</div>

<div class="orders">
  @include('admin::admin.orders.orders')
</div>

@stop
@section('footer')
<footer>
    @include('admin::admin.footer')
</footer>
@stop
