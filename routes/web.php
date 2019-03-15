<?php

$prefix = session('applocale');

Route::get('/', 'PagesController@index')->name('index');

// Front routes
Route::group(['prefix' => $prefix], function() {

    Route::get('/', 'PagesController@index');
    Route::get('/home', 'PagesController@index');


    Route::get('/registration', 'Auth\RegistrationController@create');
    Route::post('/registration', 'Auth\RegistrationController@store');
    Route::post('/registrationAjax', 'Auth\RegistrationController@registration');
    Route::get('/registration/authorizeUser/{user}', 'Auth\RegistrationController@authorizeUser');
    Route::get('/registration/changePass/{user}', 'Auth\RegistrationController@changePass');

    Route::get('/login', 'Auth\AuthController@create')->name('front.login');
    Route::post('/login', 'Auth\AuthController@store');
    Route::post('/loginAjax', 'Auth\AuthController@login');
    Route::get('/logout', 'Auth\AuthController@logout');

    Route::get('/login/{provider}', 'Auth\AuthController@redirectToProvider');
    Route::get('/login/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

    Route::get('/forgot-password', 'Auth\ForgotPasswordController@getForgotPassword');
    Route::post('/password/email', 'Auth\ForgotPasswordController@postEmail');

    Route::get('/password/code', 'Auth\ForgotPasswordController@getCode')->name('password.code');
    Route::post('/password/code', 'Auth\ForgotPasswordController@postCode');

    Route::get('/password/reset', 'Auth\ForgotPasswordController@getReset')->name('password.reset');
    Route::post('/password/reset', 'Auth\ForgotPasswordController@postReset');
    Route::get('/{pages}', 'PagesController@getPages')->name('pages');

});

// Personal Account routes
Route::group(['prefix' => $prefix, 'middleware' => 'auth_front'], function() {

    Route::get('/cabinet/personalData', 'CabinetController@index')->name('cabinet');
    Route::post('/cabinet/savePersonalData', 'CabinetController@savePersonalData')->name('cabinet.savePersonalData');
    Route::post('/cabinet/changePass', 'CabinetController@savePass')->name('cabinet.savePass');
    Route::post('/cabinet/filterCountries', 'CabinetController@filterByCountries')->name('cabinet.filterByCountries');
    Route::post('/cabinet/filterRegions', 'CabinetController@filterByRegions')->name('cabinet.filterByRegions');
    Route::post('/cabinet/addAddress', 'CabinetController@addAddress')->name('cabinet.addAddress');
    Route::post('/cabinet/saveAddress/{id?}', 'CabinetController@saveAddress')->name('cabinet.saveAddress');
    Route::delete('/cabinet/deleteAddress/{id?}', 'CabinetController@deleteAddress')->name('cabinet.deleteAddress');
    Route::post('/cabinet/priorityAddress', 'CabinetController@priorityAddress')->name('cabinet.priorityAddress');

    Route::get('/cabinet/history', 'CabinetController@history')->name('cabinet.history');
    Route::post('/cabinet/historyCart/{id}', 'CabinetController@historyCart')->name('cabinet.historyCart');
    Route::get('/cabinet/history/order/{order}', 'CabinetController@historyOrder')->name('cabinet.historyOrder');
    Route::post('/cabinet/historyCartSet/{id}', 'CabinetController@historyCartSet')->name('cabinet.historyCartSet');
    Route::post('/cabinet/historyCartProduct/{id}', 'CabinetController@historyCartProduct')->name('cabinet.historyCartProduct');

    Route::get('/cabinet/return', 'CabinetController@return')->name('cabinet.return');
    Route::get('/cabinet/return/order/{order}', 'CabinetController@returnOrder')->name('cabinet.returnOrder');
    Route::post('/cabinet/return/addProductsToReturn/{order}', 'CabinetController@addProductsToReturn')->name('cabinet.addProductsToReturn');
    Route::post('/cabinet/return/addSetsToReturn/{order}', 'CabinetController@addSetsToReturn')->name('cabinet.addSetsToReturn');
    Route::post('/cabinet/return/saveReturn/{return}', 'CabinetController@saveReturn')->name('cabinet.saveReturn');

    Route::get('/cabinet/wishList', 'CabinetController@wishList')->name('cabinet.wishList');

});
