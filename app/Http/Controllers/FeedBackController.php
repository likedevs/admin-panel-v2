<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\FeedBack;
use Session;


class FeedBackController extends Controller
{
    public function index() {

        return view('front.pages.thanks');
    }

    public function feedBack(Request $request)
    {
        $userData['name'] = $request->get('first_name');
        $userData['lastName'] = $request->get('second_name');
        $userData['email'] = $request->get('email');

        $to = getContactInfo('emailfront')->translationByLanguage($this->lang->id)->first()->value;
        $subject = 'Feedback form';

        $message = view('mails.feedBack', ['user' => $userData])->render();
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

        mail($to, $subject, $message, $headers);

        $feedback = new FeedBack();
        $feedback->first_name = request('first_name');
        $feedback->second_name = request('second_name');
        $feedback->email = request('email');
        $feedback->form = request('form');
        $feedback->status = 'new';

        $feedback->save();

        Session::flash('message', 'Va multumim, in scrut timp managerii nostri va vor contcta.');
        return redirect()->back();
    }

    public function sendSize(Request $request)
    {
        $product = Product::find($request->get('product_id'));

        if (!is_null($product)) {
            $userData['name'] = $request->get('first_name');
            $userData['lastName'] = $request->get('second_name');
            $userData['email'] = $request->get('email');
            $userData['phone'] = $request->get('phone');
            $userData['date_from'] = $request->get('date_metting');
            $userData['date_to'] = $request->get('date_mariage');
            $userData['address'] = $request->get('address');

            // $to = getContactInfo('emailfront')->translationByLanguage($this->lang->id)->first()->value;
            $to = "iovitatudor@gmail.com";
            $subject = 'Masurari';

            $message = view('mails.sendSizes', ['product' => $product, 'user' => $userData])->render();
            $headers  = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

            mail($to, $subject, $message, $headers);
        }

        Session::flash('message', 'Va multumim, in scrut timp managerii nostri va vor contcta.');
        return redirect()->back();
    }

}
