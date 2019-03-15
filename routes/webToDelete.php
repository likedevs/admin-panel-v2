<?php

$prefix = session('applocale');

Route::get('/', 'PagesController@index')->name('index');

Route::get('/sitemap.xml', 'SitemapController@xml')->name('sitemap.xml');

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

Route::group(['prefix' => $prefix], function() {

    Route::get('promocode/{promocodeId}', 'PagesController@getPromocode');
    Route::get('/thanks', 'OrderController@thanks')->name('thanks');
    Route::get('/404', 'PagesController@get404')->name('404');

    Route::post('/feedback', 'FeedBackController@feedBack')->name('user.feedBack');
    Route::post('/sizes', 'FeedBackController@sendSize')->name('user.sendSize');

    Route::get('/sizes/{id}', 'ProductsController@chooseSizes')->name('product.choose.sizes');

    Route::get('/sitemap', 'SitemapController@html')->name('sitemap.html');



    Route::post('/changeLang', 'LanguagesController@changeLang');

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

    Route::get('/blogs/{category?}', 'BlogController@index')->name('blogs');
    Route::get('/blogs/{category}/{blog}', 'BlogController@getBlog');
    Route::post('/blogs/addMoreBlogs', 'BlogController@addMoreBlogs');
    Route::post('/blogs/filterBlogs', 'BlogController@filterBlogs');

    // Ajax request
    Route::post('/addToCart', 'CartController@addToCart');
    Route::post('/addSetToCart', 'CartController@addSetToCart');
    Route::post('/cartQty/minus', 'CartController@changeQtyMinus');
    Route::post('/cartQty/plus', 'CartController@changeQtyPlus');
    Route::post('/cartQty/changeQty', 'CartController@changeQty');
    Route::post('/cartQty/changeQtySet', 'CartController@changeQtySet');
    Route::post('/cart/set/promocode', 'CartController@setPromocode');
    Route::post('/cart/remove/promocode', 'CartController@removePromocode');
    Route::post('/cart/validateProducts', 'CartController@validateProducts');
    Route::get('/move/to/favorites', 'CartController@moveToFavorites');
    Route::post('/removeItemCart', 'CartController@removeItemCart');
    Route::post('/removeSetCart', 'CartController@removeSetCart');
    Route::post('/removeAllItemCart', 'CartController@removeAllItemCart');
    Route::post('/moveFromCartToWishList', 'CartController@moveFromCartToWishList');
    Route::post('/filterCountries', 'CartController@filterByCountries');
    Route::post('/filterRegions', 'CartController@filterByRegions');
    Route::post('/filter', 'ProductsController@filter');
    Route::post('/filter/brands', 'ProductsController@filterBrand');
    Route::post('/filter/property', 'ProductsController@filterProperty');
    Route::post('/filter/price', 'ProductsController@filterPrice');
    Route::post('/filter/limit', 'ProductsController@filterLimit');
    Route::post('/filter/order', 'ProductsController@filterOrder');
    Route::post('/change/subproduct', 'ProductsController@getSubproduct');
    Route::post('/change/subproductListSingle', 'ProductsController@subproductListSingle');
    Route::post('/change/subproductList', 'ProductsController@getSubproductList');
    Route::post('/change/subproductListWishList', 'ProductsController@getSubproductListWishList');

    Route::post('/search/autocomplete', 'SearchController@index');
    Route::get('/search', 'SearchController@search');

    Route::get('/filter/reset', 'ProductsController@filterReset');

    Route::post('/order', 'CartController@order');
    Route::post('/order/oneClick', 'CartController@orderOneClick');

    Route::get('/', 'PagesController@index')->name('home');
    Route::get('/home', 'PagesController@index')->name('home-second');

    Route::get('/cart', 'CartController@index')->name('cart');

    Route::get('/wishList', 'WishListController@index')->name('wishList');
    Route::post('/addToWishList', 'WishListController@addToWishList');
    Route::post('/addSetToWishList', 'WishListController@addSetToWishList');
    Route::post('/changeSubproductSizeWishList', 'WishListController@changeSubproductSizeWishList');
    Route::post('/moveFromWishListToCart', 'WishListController@moveFromWishListToCart');
    Route::post('/moveSetFromWishListToCart', 'WishListController@moveSetFromWishListToCart');
    Route::post('/removeItemWishList', 'WishListController@removeItemWishList');
    Route::post('/removeSetWishList', 'WishListController@removeSetWishList');

    Route::post('/order', 'OrderController@index');
    Route::post('/order/userdata', 'OrderController@checkUserdata');

    Route::get('/catalog/outlet', 'ProductsController@discount')->name('products-outlet');
    Route::get('/catalog/arrival', 'ProductsController@arrival')->name('products-arrival');
    Route::get('/catalog', 'ProductsController@productsList')->name('products-categories-all');
    Route::get('/catalog/{category}', 'ProductsController@categoriesList')->name('products-categories');
    Route::get('/catalog/{category}/{subcategory}', 'ProductsController@subcategoriesList')->name('products-categories-subctegories');
    Route::get('/catalog/{category}/{subcategory}/{product}', 'ProductsController@getProductSingle')->name('products');

    Route::get('/collection/{collection}/{set}', 'CollectionController@getSet')->name('set-collection');
    Route::get('/collection/{category}', 'CollectionController@getProductsCategories')->name('products-collection');
    Route::get('/collection/{category}/{subcategory}', 'CollectionController@getProductsCategoriesSubcategories')->name('products-collection-subcollection');

    Route::get('/brand/{category}', 'BrandsController@getBrandsCategories')->name('brands-categories');
    Route::get('/brand/{category}/{subcategory}', 'BrandsController@getBrandsCategoriesSubcategories')->name('brands-categories-subctegories');
    Route::get('/brand/{category}/{subcategory}/{product}', 'BrandsController@getBrands')->name('brands');

    Route::get('/solutions/{category}', 'SolutionsController@getSolutionssCategory')->name('brands-category');

    Route::get('/{pages}', 'PagesController@getPages')->name('pages');

});
