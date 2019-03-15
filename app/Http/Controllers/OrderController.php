<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartSet;
use App\Models\Contact;
use App\Models\FrontUser;
use App\Models\UserField;
use App\Models\Promocode;
use App\Models\PromocodeType;
use PDF;
use Session;
use App\Models\Collection;

class OrderController extends Controller
{
    private $addressMain;

    public function index(Request $request)
    {
        $toValidate = [];

        $uniquefields = UserField::where('in_cart', 1)->where('unique_field', 1)->get();

        $requiredPersonalDatafields = UserField::where('in_cart', 1)->where('field_group', 'personaldata')->where('required_field', 1)->get();
        $requiredAddressfields = UserField::where('in_cart', 1)->where('field_group', 'address')->where('required_field', 1)->get();

        if(count($requiredPersonalDatafields) > 0) {
            foreach ($requiredPersonalDatafields as $requiredPersonalDatafield) {
                if($requiredPersonalDatafield->field == 'name' || $requiredPersonalDatafield->field == 'surname') {
                    $toValidate[$requiredPersonalDatafield->field] = 'required|min:3';
                } else {
                    $toValidate[$requiredPersonalDatafield->field] = 'required';
                }
            }
        }

        if(request('delivery') !== 'pickup') {
            if(count($requiredAddressfields) > 0) {
                foreach ($requiredAddressfields as $requiredAddressfield) {
                    $toValidate[$requiredAddressfield->field] = 'required';
                }
            }
        } else {
            $toValidate['pickup'] = 'required';
        }

        $toValidate['delivery'] = 'required';
        $toValidate['payment'] = 'required';

        if(Auth::guard('persons')->guest()) {
            // $client = new Client;
            // $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            //         'form_params' => [
            //             'secret' => env('RE_CAP_SECRET'),
            //             'response' => request('g-recaptcha-response'),
            //             'remoteip' => request()->ip()
            //         ]
            // ]);
            //
            // if(!json_decode($response->getBody())->success) {
            //     $toValidate['captcha'] = 'required';
            // }
            if(count($uniquefields) > 0) {
                foreach ($uniquefields as $uniquefield) {
                    if($uniquefield->field == 'email') {
                        $toValidate[$uniquefield->field] = 'required|unique:front_users|email';
                    } else {
                        $toValidate[$uniquefield->field] = 'required|unique:front_users';
                    }
                }
            }

            $cartProducts = $this->getCartProducts($_COOKIE['user_id']);
            $cartSets = $this->getCartSets($_COOKIE['user_id']);
        } else {
            $user = FrontUser::find(Auth::guard('persons')->id());
            if(count($user->addresses()->get()) > 0) {
              $toValidate['addressMain'] = 'required';
            }
            unset($toValidate['terms_agreement']);
            if(count($uniquefields) > 0) {
                foreach ($uniquefields as $uniquefield) {
                    if($uniquefield->field == 'email') {
                        $toValidate[$uniquefield->field] = 'required|email';
                    } else {
                        $toValidate[$uniquefield->field] = 'required';
                    }
                }
            }
            $cartProducts = $this->getCartProducts($user->id);
            $cartSets = $this->getCartSets($user->id);
        }

        if(count($cartProducts) == 0 && count($cartSets) == 0) {
          return redirect()->back()->withInput();
        }

        $checkStock = $this->checkStock($cartProducts);
        if($checkStock) {
          return redirect()->back()->withInput();
        }

        $validator = $this->validate(request(), $toValidate);

        $order = $this->orderProducts($request->all(), $cartProducts, $cartSets);

        return redirect()->route('thanks');
    }

    // проверить данные пользователя
    // Два чекбокса, новый юзер или старый, но показывать их только если юзер не залогинен
    // Если юзер залогинен то показывается заполенная форма с его данными
    // Иначе если новый юзер показать форму с пустыми полями, иначе пусть авторизуется
    // проверить адрес
    // проверить платеж
    // создать ордер и тд


    private function checkCart($user_id) {
        $products = Cart::where('user_id', @$_COOKIE['user_id'])->get();
        $products_id = Cart::where('user_id', $user_id)->pluck('product_id')->toArray();

        $sets = CartSet::where('user_id', @$_COOKIE['user_id'])->get();
        $sets_id = CartSet::where('user_id', $user_id)->pluck('set_id')->toArray();

        if(count($products) > 0) {
            Session::flash('message', 'Nu uita că ai articole suplimentare în coș dintr-o vizită anterioară pe site.');
            foreach ($products as $key => $product) {
                if(in_array($product->product_id, $products_id)) {

                    Cart::where('id', $product->id)->delete();
                    Cart::where('user_id', $user_id)->where('product_id', $product->product_id)->increment('qty', $product->qty);

                } else {
                    Cart::where('id', $product->id)->update([
                          'is_logged' => 1,
                          'user_id' => $user_id
                    ]);
                }
            }
        }

        if(count($sets) > 0) {
            Session::flash('message', 'Nu uita că ai articole suplimentare în coș dintr-o vizită anterioară pe site.');
            foreach ($sets as $key => $set) {
                if(in_array($set->set_id, $sets_id)) {

                    CartSet::where('id', $set->id)->delete();
                    CartSet::where('user_id', $user_id)->where('product_id', $set->product_id)->increment('qty', $set->qty);

                } else {
                    CartSet::where('id', $set->id)->update([
                          'is_logged' => 1,
                          'user_id' => $user_id
                    ]);
                }
            }
        }
    }

    private function checkStockOfCart($user_id){
        $cartProducts = Cart::where('user_id', $user_id)->get();
        $message = "Unul sau mai multe dintre articolele din coșul dvs. de cumpărături sunt vândute. Mutați-le la favoritele dvs. pentru a le putea urmări, ar putea să revină în stoc.";
        if (count($cartProducts) > 0) {
            foreach ($cartProducts as $key => $cartProduct) {
                if (is_null($cartProduct->product)) {
                    if ($cartProduct->product->stock == 0) {
                        Session::flash('messageStok', $message);
                        return false;
                    }
                }
                if (is_null($cartProduct->subproduct)) {
                    if ($cartProduct->subproduct->stock == 0) {
                        Session::flash('messageStok', $message);
                        return false;
                    }
                }
            }
        }

        return true;
    }

    private function checkWishList($user_id) {
        $products = WishList::where('user_id', @$_COOKIE['user_id'])->get();

        $sets = WishListSet::where('user_id', @$_COOKIE['user_id'])->get();

        if(count($products) > 0) {
            foreach ($products as $key => $product) {
                WishList::where('id', $product->id)->update([
                      'is_logged' => 1,
                      'user_id' => $user_id
                ]);
            }
        }

        if(count($sets) > 0) {
            foreach ($sets as $key => $set) {
                WishListSet::where('id', $set->id)->update([
                      'is_logged' => 1,
                      'user_id' => $user_id
                ]);
            }
        }
    }

    public function checkUserdata(Request $request) {
        if(Auth::guard('persons')->guest()) {
          $validator = validator($request->all(), [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'email' => 'required|unique:front_users|email',
            'phone' => 'required|unique:front_users|min:9',
            'terms_agreement' => "required"
          ]);

          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()->all()], 400);
          }

          $password = str_random(10);
          $user = $this->createClient($password);

          Auth::guard('persons')->login($user);

          $this->checkWishList(Auth::guard('persons')->id());
          $this->checkCart(Auth::guard('persons')->id());
          $this->checkStockOfCart(Auth::guard('persons')->id());
        } else {
          $validator = validator($request->all(), [
            'name' => 'required|min:3',
            'surname' => 'required|min:3',
            'email' => 'required|email',
            'phone' => 'required|min:9'
          ]);

          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()->all()], 400);
          }

          $this->updateClient();
        }

        return response()->json(['success'=> 'Your data have been successfully updated']);
    }

    private function createClient($password) {
        $user = FrontUser::create([
            'is_authorized' => 0,
            'lang' => 1,
            'name' => request('name') ? request('name') : '',
            'surname' => request('surname') ? request('surname') : '',
            'email' => request('email') ? request('email') : '',
            'phone' => request('phone') ? request('phone') : '',
            'password' => bcrypt($password),
            'terms_agreement' => request('terms_agreement') ? 1 : 0,
            'promo_agreement' => request('promo_agreement') ? 1 : 0,
            'remember_token' => request('_token')
        ]);

        // $this->createClientAddress($user);

        return $user;
    }

    private function createClientAddress($user) {
        if(request('delivery') !== 'pickup') {
            $address = $user->addresses()->create([
                'addressname' => request('addressname'),
                'country' => request('country'),
                'region' => request('region'),
                'location' => request('location')
            ]);

            $this->addressMain = $address->id;
        } else {
            $this->addressMain = request('pickup');
        }

    }

    private function createPromocode($promoType, $userId) {
        $promocode = Promocode::create([
          'name' => 'repeated'.str_random(5),
          'type_id' => $promoType->id,
          'discount' => $promoType->discount,
          'valid_from' => date('Y-m-d'),
          'valid_to' => date('Y-m-d', strtotime(' + '.$promoType->period.' days')),
          'period' => $promoType->period,
          'treshold' => $promoType->treshold,
          'to_use' => 0,
          'times' => $promoType->times,
          'status' => 'valid',
          'user_id' => $userId
        ]);

        return $promocode;
    }

    private function createOrder($userId, $amount, $promocode, $cartProducts, $cartSets) {
        $order = Order::create([
            'user_id' => $userId,
            'address_id' => $this->addressMain,
            'is_logged' => 1,
            'amount' => $amount,
            'status' => 'pending',
            'secondarystatus' => 'confirmed',
            'paymentstatus' => 'notpayed',
            'delivery' => request('delivery'),
            'payment' => request('payment'),
            'promocode_id' => count($promocode) > 0 ? $promocode->id : 0
        ]);

        if(count($cartSets) > 0) {
            foreach ($cartSets as $key => $cartSet):
                $orderSet = $order->orderSets()->create([
                    'set_id' => $cartSet->set_id,
                    'qty' => $cartSet->qty,
                    'price' => $cartSet->price
                ]);

                foreach ($cartSet->cart as $cart):
                    $order->orderProducts()->create([
                      'product_id' => $cart->product_id,
                      'subproduct_id' => $cart->subproduct_id,
                      'qty' => $cart->qty,
                      'set_id' => $orderSet->id
                    ]);

                    if ($cart->subproduct->stock >= $cartSet->qty) {
                        $cart->subproduct->stock -= $cartSet->qty;
                    }else{
                        $cart->subproduct->stock = 0;
                    }
                    $cart->subproduct->save();

                endforeach;
            endforeach;
        }

        if(count($cartProducts) > 0) {
            foreach ($cartProducts as $key => $cartProduct):
                $order->orderProducts()->create([
                  'product_id' => $cartProduct->product_id,
                  'subproduct_id' => $cartProduct->subproduct_id,
                  'qty' => $cartProduct->qty
                ]);

                if ($cartProduct->subproduct->stock >= $cartProduct->qty) {
                    $cartProduct->subproduct->stock -= $cartProduct->qty;
                }else{
                    $cartProduct->subproduct->stock = 0;
                }
                $cartProduct->subproduct->save();

            endforeach;
        }

        return $order;
    }

    private function sendMessage($user, $promocode, $password) {
        $to = request('email');

        $subject = trans('auth.register.subject');

        if(Auth::guard('persons')->check()) {
            $message = view('front.emailTemplates.loggedOrder', compact('user'))->render();
        } else {
            $message = view('front.emailTemplates.unloggedOrder', compact('user', 'password'))->render();
        }

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);
    }

    private function sendMessageToAdmin($order) {
        $to = implode(',', getContactInfo('emailadmin')->translationByLanguage()->pluck('value')->toArray());

        $subject = 'New order from '.getContactInfo('site')->translationByLanguage()->first()->value.'';

        $message = view('front.emailTemplates.admin', compact('order'))->render();

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);
    }

    private function updateClient() {
        $user = FrontUser::find(Auth::guard('persons')->id());
        $user->name = request('name');
        $user->surname = request('surname');
        $user->email = request('email');
        $user->phone = request('phone');

        $user->save();

        // $this->updateClientAddress($user);

        return $user;
    }

    private function updateClientAddress($user) {
        if(request('delivery') !== 'pickup') {
            if(count($user->addresses()->get()) > 0) {
                foreach ($user->addresses()->get() as $key => $address) {
                    $address->addressname = request('addressname')[$key];
                    $address->country = request('country')[$key];
                    $address->region = request('region')[$key];
                    $address->location = request('location')[$key];
                    $address->save();
                }
                $this->addressMain = request('addressMain');
            } else {
                $address = $user->addresses()->create([
                    'addressname' => request('addressname'),
                    'country' => request('country'),
                    'region' => request('region'),
                    'location' => request('location')
                ]);
                $this->addressMain = $address->id;
            }
        } else {
            $this->addressMain = request('pickup');
        }
    }

    private function checkStock($cartProducts){

        if (count($cartProducts) > 0) {

            foreach ($cartProducts as $key => $cartProduct) {

                if (!is_null($cartProduct->subproduct)) {
                    if ($cartProduct->subproduct->stock > 0) {
                        if($cartProduct->qty > $cartProduct->subproduct->stock) {
                            return true;
                        }
                    } else {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    private function checkPromo($amount) {
      $promocode = Promocode::where('id', @$_COOKIE['promocode'])
                              ->where('treshold', '<', $amount)
                              ->whereRaw('to_use < times')
                              ->where(function($query) {
                                  $query->where('status', 'valid');
                                  $query->orWhere('status', 'partially');
                              })
                              ->first();

      if(count($promocode) > 0) {
          if($promocode->user_id !== 0) {
              if(Auth::guard('persons')->guest()) {
                  return false;
              } else if(Auth::guard('persons')->check() && $promocode->user_id !== Auth::guard('persons')->id()) {
                  return false;
              }
          }
          $amount = $amount - ($amount * $promocode->discount / 100);
          $promocode->to_use += 1;
          $promocode->status = 'invalid';
          $promocode->save();
      }

      return $amount;
    }

    private function orderProducts($request, $cartProducts, $cartSets) {
        $amountWithOutPromo = $this->getAmount($cartProducts) + $this->getSetsAmount($cartSets);

        $amount = $this->checkPromo($amountWithOutPromo);

        // $deliveryPriceEuro = getContactInfo('deliveryPriceEuro')->translationByLanguage()->first()->value;
        // $thresholdEURO = getContactInfo('ThresholdEURO')->translationByLanguage()->first()->value;
        $deliveryPriceMdl = getContactInfo('deliveryPriceMdl')->translationByLanguage()->first()->value;
        $thresholdMDL = getContactInfo('ThresholdMDL')->translationByLanguage()->first()->value;

        if ($thresholdMDL < $amount) {
            $deliveryPriceMdl = 0;
        }

        $amount = $amount + $deliveryPriceMdl;

        $promoType = PromocodeType::find(4);

        if(Auth::guard('persons')->check()) {
            $user = $this->updateClient();

            $promocode = $this->createPromocode($promoType, $user->id);

            $order = $this->createOrder($user->id, $amount, $promocode, $cartProducts, $cartSets);

            Cart::where('user_id', Auth::guard('persons')->id())->delete();
            CartSet::where('user_id', Auth::guard('persons')->id())->delete();

            $this->sendMessage($user, $promocode, '');
        } else {
            $password = str_random(12);

            $user = $this->createClient($password);

            $promocode = $this->createPromocode($promoType, $user->id);

            $order = $this->createOrder($user->id, $amount, $promocode, $cartProducts, $cartSets);

            Cart::where('user_id', @$_COOKIE['user_id'])->delete();
            CartSet::where('user_id', @$_COOKIE['user_id'])->delete();

            session()->put(['token' => str_random(60), 'user_id' => $user->id]);

            $this->sendMessage($user, $promocode, $password);

            Auth::guard('persons')->login($user);
        }

        $this->sendMessageToAdmin($order);

        return $order;
    }

    private function getAmount($cartProducts) {
        $amount = 0;
        foreach ($cartProducts as $key => $cartProduct):

          if($cartProduct->set) {
            $price = $cartProduct->price_lei;
          } else {
            $price = $cartProduct->subproduct->price_lei - ($cartProduct->subproduct->price_lei * $cartProduct->subproduct->discount / 100);
          }

          if($price) {
            $amount +=  $price * $cartProduct->qty;
          }
        endforeach;

        return $amount;
    }

    private function getSetsAmount($cartSets) {
        $amount = 0;
        foreach ($cartSets as $key => $cartSet):
          $amount +=  $cartSet->price * $cartSet->qty;
        endforeach;

        return $amount;
    }

    private function getCartProducts($id) {
       $rows = Cart::where('user_id', $id)->where('set_id', 0)->get();
       return $rows;
    }

    private function getCartSets($id) {
        $rows = CartSet::where('user_id', $id)->get();
        return $rows;
    }

    public function thanks() {
        $promocode = Promocode::where('user_id', Auth::guard('persons')->id())
                      ->whereRaw('to_use < times')
                      ->where('valid_to', '>', date('Y-m-d'))
                      ->orderBy('id', 'desc')->first();
        if(Auth::guard('persons')->check() && count($promocode) > 0) {
            $collections = Collection::all();
            return view('front.orders.thanks', compact('collections', 'promocode'));
        } else {
            return redirect()->route('404')->send();
        }
    }

}
