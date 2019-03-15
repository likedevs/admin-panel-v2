@extends('front.app')

@section('content')

<h1 class="text-center">Soledy home page.</h1>

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

@stop
