<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\CartSet;
use App\Models\WishList;
use App\Models\WishListSet;
use App\Models\FrontUser;
use Socialite;
use Session;
use App\Models\UserField;
use App\Models\Lang;
use App\Models\Promocode;
use App\Models\PromocodeType;

class AuthController extends Controller
{
  public function create()
  {
      return view('auth.front.login');
  }

  public function store()
  {
      $toValidate = [];

      $uniquefields = UserField::where('in_auth', 1)->get();

      if(count($uniquefields) > 0) {
          foreach ($uniquefields as $uniquefield) {
              if($uniquefield->field == 'email') {
                  $toValidate[$uniquefield->field] = 'required|email';
              } else {
                  $toValidate[$uniquefield->field] = 'required';
              }
          }
      }

      $toValidate['password'] = 'required';

      $validator = $this->validate(request(), $toValidate);

      if (Auth::guard('persons')->attempt(request()->except('_token'))) {
          $this->checkWishList(Auth::guard('persons')->id());
          $this->checkCart(Auth::guard('persons')->id());
          $this->checkStockOfCart(Auth::guard('persons')->id());
          $lang = Lang::find(Auth::guard('persons')->user()->lang);
          return redirect($lang->lang.'/cabinet/personalData');
      }
      else {
          return redirect()->back()->withErrors(['authErr' => [trans('auth.email')]]);
      }
  }

  public function login(Request $request) {
      $validator = validator($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:4'
      ]);

      if ($validator->fails()) {
          return response()->json(['errors'=>$validator->errors()->all()], 400);
      }

      if (Auth::guard('persons')->attempt($request->all())) {
          $this->checkWishList(Auth::guard('persons')->id());
          $this->checkCart(Auth::guard('persons')->id());
          $this->checkStockOfCart(Auth::guard('persons')->id());
          return response()->json(['success'=> 'You have successfully logged in'], 200);
      }
      else {
          return response()->json(['errors'=> ['Auth failed']], 400);
      }
  }

  public function logout()
  {
      Auth::guard('persons')->logout();

      return redirect()->route('home');
  }

  public function redirectToProvider($provider)
  {
        return Socialite::driver($provider)->redirect();
  }

  public function handleProviderCallback($provider)
  {
        $user = Socialite::driver($provider)->user();
        $authUser = FrontUser::where('email', $user->getEmail())->first();

        if (count($authUser) > 0) {
            $this->checkCart($authUser->id);
            $this->checkWishList($authUser->id);
        } else {
            $username = explode(' ', $user->getName());
            $password = str_random(12);

            $authUser = FrontUser::create([
                'lang' => 1,
                'name' => count($username) > 0 ? $username[0] : $user->getName(),
                'surname' => count($username) > 1 ? $username[1] : '',
                'email' => $user->getEmail(),
                'remember_token' => $user->token,
                'password' => bcrypt($password),
            ]);

            $user = $authUser;
            $promoType = PromocodeType::where('name', 'newuser')->first();

            $promocode = Promocode::create([
              'name' => 'newuser'.str_random(5),
              'type_id' => $promoType->id,
              'discount' => $promoType->discount,
              'valid_from' => date('Y-m-d'),
              'valid_to' => date('Y-m-d', strtotime(' + '.$promoType->period.' days')),
              'period' => $promoType->period,
              'treshold' => $promoType->treshold,
              'to_use' => 0,
              'times' => $promoType->times,
              'status' => 'valid',
              'user_id' => $user->id
            ]);

            $to = $user->email;
            $subject = trans('auth.register.subject');

            session()->put(['token' => str_random(60), 'user_id' => $user->id]);

            $message = view('front.emailTemplates.registerPromo', compact('user', 'password', 'promocode'))->render();
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text; charset=utf-8' . "\r\n";

            $status = mail($to, $subject, $message, $headers);

            // dd($status);

            Auth::guard('persons')->login($authUser);

            $lang = Lang::find(Auth::guard('persons')->user()->lang);
            return redirect('/')->withSuccess($promocode->name);
        }


        Auth::guard('persons')->login($authUser);

        $lang = Lang::find(Auth::guard('persons')->user()->lang);
        // return redirect($lang->lang.'/cabinet/personalData');
        return redirect('/');
  }

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

  public function checkStockOfCart($user_id){
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

}
