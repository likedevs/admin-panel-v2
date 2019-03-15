<?php

namespace App\Providers;

use App\Base as Model;
use App\Models\Lang;
use App\Models\Module;
use App\Models\Cart;
use App\Models\Page;
use App\Models\WishList;
use App\Models\ProductCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $lang = Lang::where('lang', 'ro')->first();
        $this->setUserId();

        if (!is_null($lang)) {
            session(['applocale' => Lang::where('lang', 'ro')->first()->lang]);
            $currentLang = Lang::where('lang', \Request::segment(1))->first()->lang ?? session('applocale');
            session(['applocale' => $currentLang]);

            $lang = Lang::where('lang', session('applocale') ?? Lang::first()->lang)->first();
            $seo['seo_title'] = env('APP_NAME');
            $seo['seo_keywords'] = env('SEO_KEYWORDS');
            $seo['seo_description'] = env('SEO_DESCRIPTION');

            $categoriesMenu = ProductCategory::where('parent_id', 0)->where('active', 1)->orderBy('position', 'asc')->get();
            $footerMenus = Page::where('active', 1)->where('on_footer', 1)->orderBy('position', 'asc')->get();
            $headerMenus = Page::where('active', 1)->where('on_header', 1)->orderBy('position', 'asc')->get();

            View::share('langs', Lang::orderBy('id', 'asc')->get());
            View::share('lang', $lang);
            View::share('menu', Module::where('parent_id', 0)->orderBy('position')->get());
            View::share('seo', $seo);
            View::share('categoriesMenu', $categoriesMenu);
            View::share('footerMenus', $footerMenus);
            View::share('headerMenus', $headerMenus);

            View::composer('*', function ($view)
            {
                if(auth('persons')->guest() && isset($_COOKIE['user_id'])) {
                  $cartProducts = Cart::where('user_id', $_COOKIE['user_id'])->where('set_id', 0)->orderBy('id', 'desc')->get();
                  $wishListProducts = WishList::where('user_id', $_COOKIE['user_id'])->where('set_id', 0)->orderBy('id', 'desc')->get();
                  $wishListIds = $wishListProducts->pluck('product_id')->toArray();
                } else {
                  $cartProducts = Cart::where('user_id', auth('persons')->id())->where('set_id', 0)->orderBy('id', 'desc')->get();
                  $wishListProducts = WishList::where('user_id', auth('persons')->id())->where('set_id', 0)->orderBy('id', 'desc')->get();
                  $wishListIds = $wishListProducts->pluck('product_id')->toArray();
                }

                View::share('cartProducts', $cartProducts);
                View::share('wishListProducts', $wishListProducts);
                View::share('wishListIds', $wishListIds);
            });

            Model::$lang = $lang->id;
        }else{
            exit('lang is not exists!');
        }
    }

    public function setUserId()
    {
        $user_id = md5(rand(0, 9999999).date('Ysmsd'));

        if (\Cookie::has('user_id')) {
            $value = \Cookie::get('user_id');
        }else{
            setcookie('user_id', $user_id, time() + 10000000, '/');
            $value = \Cookie::get('user_id');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
