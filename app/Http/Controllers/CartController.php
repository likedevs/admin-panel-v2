<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lang;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Promocode;
use App\Models\FrontUser;
use App\Models\SubProduct;
use App\Models\UserField;
use App\Models\Country;
use App\Models\Region;
use App\Models\City;
use App\Models\Set;
use App\Models\Page;
use App\Models\Contact;
use App\Models\CartSet;
use Session;


class CartController extends Controller
{
    public function index() {
        $userCart = $this->checkIfLogged();

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();

        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $userfields = UserField::where('in_cart', 1)->get();

        $loginFields = UserField::where('in_auth', 1)->get();

        $countries = UserField::where('field', 'countries')->first();

        if(count($countries) > 0 && $countries->value != '') {
          $countries = Country::whereIn('id', json_decode($countries->value))->get();
        } else {
          $countries = Country::all();
        }

        if (!@$_COOKIE['promocode']) {
            setcookie('promocode', "", time() + 10000000, '/');
        }

        $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })
                                ->first();

        if(count($userdata) > 0 && !empty($userdata->addresses()->get())) {
            foreach ($userdata->addresses()->get() as $address) {
                $regions[] = Region::where('location_country_id', $address->country)->get();
                $cities[] = City::where('location_region_id', $address->region)->get();
            }
        }

        $adresses = Contact::where('title', 'magazins')->first();

        $page = Page::where('alias', 'home')->first();
        $seoData = $this->getSeo($page);

        if (view()->exists('front/pages/cart')) {
            return view('front.pages.cart', compact('page', 'adresses', 'seoData', 'cartProducts', 'userdata', 'userfields', 'loginFields', 'countries', 'regions', 'cities', 'promocode'));
        }else{
            echo "view for cart is not found";
        }
    }

    public function filterByCountries(Request $request)
    {
        $locationItems = Region::where('location_country_id', $request->get('value'))->get();

        if(!empty($request->get('address_id'))) {
            $address = FrontUserAddress::find($request->get('address_id'));
            $data['regions'] = view('front.inc.options', compact('locationItems', 'address'))->render();
        } else {
            $data['regions'] = view('front.inc.options', compact('locationItems'))->render();
        }

        return json_encode($data);
    }

    public function filterByRegions(Request $request) {
        $locationItems = City::where('location_region_id', $request->get('value'))->get();

        if(!empty($request->get('address_id'))) {
            $address = FrontUserAddress::find($request->get('address_id'));
            $data['cities'] = view('front.inc.options', compact('locationItems', 'address'))->render();
        } else {
            $data['cities'] = view('front.inc.options', compact('locationItems'))->render();
        }

        return json_encode($data);
    }

    public function changeQty(Request $request) {
        $userCart = $this->checkIfLogged();

        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();

        $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->update([
                'qty' => $request->get('value'),
            ]);
        }else{
            $cartItem = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('prod'))->where('subproduct_id', $request->get('subprod'))->first();
            if (!is_null($cartItem)) {
                Cart::where('id', $cartItem->id)->update([
                    'qty' => $request->get('value'),
                ]);
            }
        }

        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();
        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartCount'] = count($cartProducts) + count($cartSets);

        return json_encode($data);
    }

    public function changeQtySet(Request $request)
    {
        $userCart = $this->checkIfLogged();

        $cartSet = CartSet::where('id', $request->get('id'))->first();

        if (!is_null($cartSet)) {
            CartSet::where('id', $cartSet->id)->update([
                'qty' => $request->get('value')
            ]);
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartCount'] = count($cartProducts) + count($cartSets);

        return json_encode($data);
    }

    public function changeQtyPlus(Request $request) {
        $userCart = $this->checkIfLogged();
        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->update([
                'qty' => $cartItem->qty + 1,
            ]);
        }else{
            $cartItem = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('prod'))->where('subproduct_id', $request->get('subprod'))->first();
            if (!is_null($cartItem)) {
                Cart::where('id', $cartItem->id)->update([
                    'qty' => $cartItem->qty + 1,
                ]);
            }
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = count($cartProducts);

        return json_encode($data);
    }

    public function changeQtyMinus(Request $request) {
        $userCart = $this->checkIfLogged();
        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->update([
                'qty' => $cartItem->qty >= 2 ? $cartItem->qty - 1 : 1,
            ]);
        }else{
            $cartItem = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('prod'))->where('subproduct_id', $request->get('subprod'))->first();
            if (!is_null($cartItem)) {
                Cart::where('id', $cartItem->id)->update([
                    'qty' => $cartItem->qty + 1,
                ]);
            }
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts'))->render();
        $data['cartCount'] = count($cartProducts);

        return json_encode($data);
    }

    public function removeItemCart(Request $request) {
        $userCart = $this->checkIfLogged();


        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();

        if (!is_null($cartItem)) {
            Cart::where('id', $cartItem->id)->delete();
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();

        $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })->first();

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartCount'] = count($cartProducts) + count($cartSets);

        return json_encode($data);
    }

    public function removeSetCart(Request $request)
    {
        $userCart = $this->checkIfLogged();

        $cartSet = CartSet::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();

        if (!is_null($cartSet)) {
            Cart::where('set_id', $cartSet->id)->delete();
            CartSet::where('id', $cartSet->id)->delete();
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartCount'] = count($cartProducts) + count($cartSets);

        return json_encode($data);
    }

    public function removeAllItemCart(Request $request) {
        $userCart = $this->checkIfLogged();

        Cart::where('user_id', $userCart['user_id'])->delete();
        CartSet::where('user_id', $userCart['user_id'])->delete();

        $cartSetsAll = CartSet::where('user_id', $userCart['user_id'])->get();

        if (count($cartSetsAll) > 0) {
            foreach ($cartSetsAll as $key => $cartSetItem) {
                Cart::where('user_id', $userCart['user_id'])->where('set_id', $cartSetItem->id)->delete();
            }
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'userdata'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'userdata'))->render();
        $data['cartCount'] = count($cartProducts);

        return json_encode($data);
    }

    public function addToCart(Request $request)
    {
        $checkStock = 'true';
        $userCart =  $this->checkIfLogged();

        $subproduct = Subproduct::find($request->get('id'));

        if (!is_null($subproduct)) {
            $cart = Cart::where('user_id', $userCart['user_id'])->where('subproduct_id', $request->get('id'))->first();

            if (is_null($cart)) {
                Cart::create([
                    'product_id' => $subproduct->product_id,
                    'subproduct_id' => $request->get('id'),
                    'user_id' => $userCart['user_id'],
                    'qty' => $request->get('qty') ?? 1,
                ]);
            }else{
                if ($subproduct->stock > $cart->qty) {
                    Cart::where('id', $cart->id)->update([
                        'qty' =>  $cart->qty + 1,
                    ]);
                }else{
                    $checkStock = 'false';
                }
            }

        }
        // else{
        //     $product = Product::find($request->get('id'));
        //     if (!is_null($product)) {
        //         $cart = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('id'))->first();
        //
        //         if (is_null($cart)) {
        //             Cart::create([
        //                 'product_id' => $product->id,
        //                 'subproduct_id' => 0,
        //                 'user_id' => $userCart['user_id'],
        //                 'qty' => $request->get('qty') ?? 1,
        //             ]);
        //         }else{
        //             Cart::where('id', $cart->id)->update([
        //                 'qty' =>  $cart->qty + 1,
        //             ]);
        //         }
        //     }
        // }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();

        $data['cartCount'] = count($cartProducts) + count($cartSets);
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets'))->render();
        $data['cartQuick'] = view('front.inc.cartQuickView', compact('cartProducts', 'cartSets', 'checkStock', 'subproduct'))->render();
        $data['InStock'] = $checkStock;

        return json_encode($data);
    }

    public function addSetToCart(Request $request)
    {
        $userCart =  $this->checkIfLogged();
        $userCart = $this->checkIfLogged();

        // dd($request->get('setPrice'));

        $set = Set::find($request->get('setId'));
        $cartSet = CartSet::where('set_id', $set->id)->where('user_id', $userCart['user_id'])->first();

        if (is_null($cartSet)) {
            $cartSet = CartSet::create([
                'set_id' => $request->get('setId'),
                'user_id' => $userCart['user_id'],
                'qty' => 1,
                'price' => $request->get('setPrice'),
                'is_logged' => $userCart['is_logged']
            ]);

            $productsId = (array) json_decode($request->get('prodsId'));
            if (count($productsId)) {
                if (array_key_exists('subprods', $productsId)) {
                    foreach ($productsId['subprods'] as $key => $subProductId) {
                        $subproduct = SubProduct::find($subProductId);
                        if (!is_null($subproduct)) {
                            Cart::create([
                                'product_id' => $subproduct->product_id,
                                'subproduct_id' => $subProductId,
                                'user_id' => $userCart['user_id'],
                                'qty' => 1,
                                'is_logged' => $userCart['is_logged'],
                                'set_id' => $cartSet->id,
                            ]);
                        }
                    }
                }
            }
        }else{
            Cart::where('set_id', $cartSet->id)->delete();
            CartSet::where('id', $cartSet->id)->update([
                'set_id' => $request->get('setId'),
                'user_id' => $userCart['user_id'],
                'qty' => $cartSet->qty + 1,
                'price' => $request->get('setPrice'),
                'is_logged' => $userCart['is_logged']
            ]);

            $subProductsId = (array) json_decode($request->get('prodsId'));
            if (count($subProductsId)) {
                Cart::where('set_id', $set->id)->where('user_id', $userCart['user_id'])->delete();
                if (array_key_exists('subprods', $subProductsId)) {
                    foreach ($subProductsId['subprods'] as $key => $subProductId) {
                        $subproduct = SubProduct::find($subProductId);
                        Cart::create([
                            'product_id' => $subproduct->product_id,
                            'subproduct_id' => $subProductId,
                            'user_id' => $userCart['user_id'],
                            'qty' => 1,
                            'is_logged' => $userCart['is_logged'],
                            'set_id' => $cartSet->id,
                        ]);
                    }
                }
            }
        }

        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();

        $data['cartCount'] = count($cartProducts) + count($cartSets);
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets'))->render();
        $data['cartQuick'] = view('front.inc.cartQuickViewSet', compact('cartProducts', 'cartSets', 'set'))->render();


        return json_encode($data);
    }

    public function order()
    {
        Cart::where('user_id', @$_COOKIE['user_id'])->delete();
        Session::flash('message', "Va multumim pentru cumparaturi, in cateva minute managerii nostri vor lua legetura cu Dvs!");
        return redirect()->route('home');
    }

    public function orderOneClick()
    {
        Session::flash('message', "Va multumim, managerii nostri vor lua legetura cu Dvs!");

        return redirect()->route('home');
    }

    public function setPromocode(Request $request)
    {
        $userCart =  $this->checkIfLogged();

        $promocode = Promocode::where('name', $request->get('promocode'))
                                // ->where('to_use', $request->get('promocode'))
                                ->where(function($query){
                                    $query->where('status', 'valid');
                                    $query->orWhere('status', 'partially');
                                })->first();

        if (!is_null($promocode)) {
            $promocodeId = $promocode->id;
            setcookie('promocode', $promocodeId, time() + 10000000, '/');
            Session::flash('promocode', $request->get('promocode'));

            $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();
            $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
            $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
            $userdata = FrontUser::where('id', auth('persons')->id())->first();

            $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
            $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
            $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
            $data['cartCount'] = count($cartProducts) + count($cartSets);

            return json_encode($data);
        }
        return 'false';
    }

    public function removePromoCode(Request $request)
    {
        $userCart =  $this->checkIfLogged();

        setcookie('promocode', '', time() + 10000000, '/');
        Session::flash('promocode', '');

        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();
        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();
        $promocode = null;

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartCount'] = count($cartProducts) + count($cartSets);

        return json_encode($data);
    }

    public function moveFromCartToWishList(Request $request)
    {
        $userCart = $this->checkIfLogged();

        $cartProduct = Cart::where('user_id', $userCart['user_id'])->where('product_id', $request->get('product_id'))->where('subproduct_id', $request->get('subproduct_id'))->first();

        if (!is_null($cartProduct)) {
            WishList::create([
                'product_id' => $cartProduct->product_id,
                'subproduct_id' => $cartProduct->subproduct_id,
                'user_id' => $userCart['user_id'],
                'is_logged' => $userCart['is_logged']
            ]);

            $cartProduct->delete();
        }

        $cartItem = Cart::where('user_id', $userCart['user_id'])->where('id', $request->get('id'))->first();
        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $cartSets = CartSet::where('user_id', $userCart['user_id'])->get();
        $userdata = FrontUser::where('id', auth('persons')->id())->first();

        $data['block'] = view('front.inc.cartBlock', compact('cartProducts', 'cartSets', 'promocode', 'userdata'))->render();
        $data['summary'] = view('front.inc.cartSummary', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartBox'] = view('front.inc.cartBox', compact('cartProducts', 'cartSets', 'promocode'))->render();
        $data['cartCount'] = count($cartProducts) + count($cartSets);

        return json_encode($data);
    }

    private function checkIfLogged() {
        if(auth('persons')->guest()) {
          return array('is_logged' => 0, 'user_id' => @$_COOKIE['user_id']);
        } else {
          return array('is_logged' => 1, 'user_id' => auth('persons')->id());
        }
    }

    public function validateProducts()
    {
        $userCart = $this->checkIfLogged();
        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();
        $errorProducts = [];

        if (count($cartProducts) > 0) {
            foreach ($cartProducts as $key => $cartProduct) {
                if ($cartProduct->subproduct_id > 0) {
                    if ($cartProduct->subproduct->stock < $cartProduct->qty) {
                        $errorProducts[] = $cartProduct->id;
                    }
                }else{
                    if ($cartProduct->product->stock < $cartProduct->qty) {
                        $errorProducts[] = $cartProduct->id;
                    }
                }
            }
        }

        $cartProductsErrors = Cart::where('user_id', $userCart['user_id'])->whereIn('id', $errorProducts)->get();

        if (count($cartProductsErrors) > 0) {
            return json_encode(view('front.modals.modalValidateProducts', compact('cartProductsErrors'))->render());
        }else{
            return "false";
        }
    }

    // get SEO data for a page
    private function getSeo($page){
        $seo['seo_title'] = $page->translation($this->lang->id)->first()->meta_title;
        $seo['seo_keywords'] = $page->translation($this->lang->id)->first()->meta_keywords;
        $seo['seo_description'] = $page->translation($this->lang->id)->first()->meta_description;

        return $seo;
    }

    public function moveToFavorites()
    {
        $stoc = 0;
        $userCart = $this->checkIfLogged();
        $cartProducts = Cart::where('user_id', $userCart['user_id'])->where('set_id', 0)->get();

        if (count($cartProducts) > 0) {
            foreach ($cartProducts as $key => $cartProduct) {

                $subprod =  SubProduct::find($cartProduct->subproduct_id);

                if (!is_null($subprod)) {
                    $stoc = $subprod->stock;
                }else{
                    $prod =  Product::find($cartProduct->product_id);
                    if (!is_null($prod)) {
                        $stoc = $prod->stock;
                    }
                }

                if ($cartProduct->qty > $stoc) {
                    $wishlist =  WishList::where('product_id', $cartProduct->product_id)
                                            ->where('subproduct_id', $cartProduct->subproduct_id)
                                            ->where('user_id', $cartProduct->user_id)
                                            ->first();
                    if (is_null($wishlist)) {
                        WishList::create([
                            'product_id' => $cartProduct->product_id,
                            'subproduct_id' => $cartProduct->subproduct_id,
                            'user_id' => $cartProduct->user_id,
                        ]);
                    }
                    Cart::where('id', $cartProduct->id)->delete();
                }
            }
        }

        return redirect()->back();
    }
}
