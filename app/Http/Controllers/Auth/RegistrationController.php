<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FrontUser;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use App\Models\Promocode;
use App\Models\PromocodeType;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{

    public function create()
    {
        return view('auth.front.register');
    }

    public function store()
    {
        $toValidate = [];
        // $client = new Client;
        // $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
        //         'form_params' => [
        //             'secret' => env('RE_CAP_SECRET'),
        //             'response' => request('g-recaptcha-response'),
        //             'remoteip' => request()->ip()
        //         ]
        // ]);
        // if(!json_decode($response->getBody())->success) {
        //     $toValidate['captcha'] = 'required';
        // }

        $toValidate['email'] = 'required|unique:front_users|email';
        $toValidate['phone'] = 'required|unique:front_users';
        $toValidate['name'] = 'required|min:3';
        $toValidate['surname'] = 'required|min:3';
        $toValidate['password'] = 'required|min:4';
        $toValidate['passwordRepeat'] = 'required|same:password';
        $toValidate['terms_agreement'] = 'required';
        $validator = $this->validate(request(), $toValidate);

        $user = FrontUser::create([
            'lang' => 1,
            'name' => request('name') ? request('name') : '',
            'surname' => request('surname') ? request('surname') : '',
            'email' => request('email') ? request('email') : '',
            'phone' => request('phone') ? request('phone') : '',
            'password' => request('password') ? bcrypt(request('password')) : '',
            'terms_agreement' => request('terms_agreement') ? request('terms_agreement') : 0,
            'promo_agreement' => request('promo_agreement') ? request('promo_agreement') : 0,
            'personaldata_agreement' => request('personaldata_agreement') ? request('personaldata_agreement') : 0,
            'remember_token' => request('_token')
        ]);

        $password = request('password');

        session()->put(['token' => str_random(60), 'user_id' => $user->id]);

        $to = request('email');
        $subject = trans('auth.register.subject');
        $message = view('front.emailTemplates.registerPromo', compact('user', 'password', 'promocode'))->render();
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);

        Auth::guard('persons')->login($user);

        if(!empty(request('prev'))) {
            // return redirect(request('prev'))->withSuccess(trans('auth.register.success'));
          return redirect('/')->withSuccess($promocode->name);
        } else {
            return redirect('/')->withSuccess($promocode->name);
          // return redirect()->back()->withSuccess(trans('auth.register.success'));
        }
    }

    public function registration(Request $request) {
        $validator = validator($request->all(), [
          'email' => 'required|unique:front_users|email',
          'phone' => 'required|unique:front_users|min:9',
          'name' => 'required|min:3',
          'surname' => 'required|min:3',
          'password' => 'required|min:4',
          'terms_agreement' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 400);
        }

        $user = FrontUser::create([
            'lang' => 1,
            'name' => $request->get('name'),
            'surname' => $request->get('surname'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'password' => bcrypt($request->get('password')),
            'terms_agreement' => $request->get('terms_agreement') ? 1 : 0,
            'promo_agreement' => $request->get('promo_agreement') ? 1 : 0,
            'remember_token' => $request->get('_token')
        ]);

        $password = $request->get('password');

        session()->put(['token' => str_random(60), 'user_id' => $user->id]);

        $to = $request->get('email');
        $subject = trans('auth.register.subject');
        $message = view('front.emailTemplates.register', compact('user', 'password'))->render();
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);

        return response()->json(['success'=>'You have been successfully registered'], 200);
    }

    public function authorizeUser($token) {
        if($token == session('token')) {
            $user = FrontUser::find(session('user_id'));

            if(count($user) > 0) {
              session()->forget('token');
              session()->forget('user_id');

              $user->is_authorized = 1;
              $user->save();

              return redirect()->route('home');
            } else {
              return redirect()->route('404')->send();
            }
        } else {
            return redirect()->route('404')->send();
        }
    }

    public function changePass($token) {
        if($token == session('token')) {
            $user = FrontUser::find(session('user_id'));
            if(count($user) > 0) {
              $user->is_authorized = 1;
              $user->save();

              return redirect()->route('password.reset');
            } else {
              return redirect()->route('404')->send();
            }
        } else {
            return redirect()->route('404')->send();
        }
    }
}
