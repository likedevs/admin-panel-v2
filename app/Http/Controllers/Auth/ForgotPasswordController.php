<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\FrontUser;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{

    public function getForgotPassword()
    {
        return view('auth.front.forgotpassword');
    }

    public function postEmail(Request $request)
    {
        // $this->validate(request(), [
        //     'email' => 'required|email',
        // ]);
        //
        // $user = FrontUser::where('email', request('email'))->first();
        //
        // if(count($user) > 0) {
        //   session()->put(['code' => str_random(10), 'user_id' => $user->id]);
        //
        //   $to = request('email');
        //   $subject = trans('auth.forgotpass.subject');
        //   $message = view('front.emailTemplates.forgotPassword', compact('user'))->render();
        //   $headers  = 'MIME-Version: 1.0' . "\r\n";
        //   $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        //
        //   mail($to, $subject, $message, $headers);
        //
        //   return redirect()->route('password.code')->withSuccess(trans('auth.forgotpass.code'));
        // } else {
        //   return back()->withErrors(['invalidEmail' => [trans('auth.forgotpass.email')]]);
        // }
        $validator = validator($request->all(), [
          'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 400);
        }

        $user = FrontUser::where('email', request('email'))->first();

        if(count($user) > 0) {
          session()->put(['code' => str_random(10), 'user_id' => $user->id]);

          $to = $request->get('email');
          $subject = trans('auth.forgotpass.subject');
          $message = view('front.emailTemplates.forgotPassword', compact('user'))->render();
          $headers  = 'MIME-Version: 1.0' . "\r\n";
          $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

          mail($to, $subject, $message, $headers);

          return response()->json(['success'=> 'Code was sent to your email']);
        } else {
          return response()->json(['errors'=> ['Such user does not exist']], 400);
        }
    }

    public function getCode()
    {
        return view('auth.front.code');
    }

    public function postCode(Request $request)
    {
        // $this->validate(request(), [
        //     'code' => 'required|in:'.session('code')
        // ]);
        //
        // return redirect()->route('password.reset')->withSuccess(trans('auth.forgotpass.codeSuccess'));
        $validator = validator($request->all(), [
          'code' => 'required|in:'.session('code')
        ]);

        if ($validator->fails()) {
          return response()->json(['errors'=>$validator->errors()->all()], 400);
        }

        return response()->json(['success'=> 'Now you can reset your password']);
    }

    public function getReset()
    {
        return view('auth.front.resetpassword');
    }

    public function postReset(Request $request)
    {
        // $this->validate(request(), [
        //     'password' => 'required|min:3',
        //     'passwordRepeat' => 'required|same:password',
        // ]);
        //
        // $user = FrontUser::find(session('user_id'));
        //
        // if(count($user) > 0) {
        //   $user->password = bcrypt(request('password'));
        //   $user->remember_token = request('_token');
        //   $user->save();
        //
        //   session()->forget('code');
        //   session()->forget('user_id');
        //
        //   return redirect()->route('front.login')->withSuccess(trans('auth.forgotpass.pass'));
        // } else {
        //   return redirect()->route('404');
        // }

        $validator = validator($request->all(), [
          'password' => 'required|min:3',
        ]);

        if ($validator->fails()) {
          return response()->json(['errors'=>$validator->errors()->all()], 400);
        }

        $user = FrontUser::find(session('user_id'));

        if(count($user) > 0) {
          $user->password = bcrypt($request->get('password'));
          $user->remember_token = $request->get('_token');
          $user->save();

          session()->forget('code');
          session()->forget('user_id');

          return response()->json(['success'=> 'Your password was changed successfully']);
        } else {
          return response()->json(['errors'=> ['Such user does not exist']], 400);
        }
    }
}
