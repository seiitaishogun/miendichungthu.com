<?php

namespace Modules\Contact\Http\Controllers;

use App\Http\Controllers\WebController;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Contact\Mails\ContactMail;
use Illuminate\Support\Facades\Auth;

class ContactController extends WebController
{
    public function index()
    {
        $this->tpl->setTemplateFrontend('index', 'contact');
        $this->tpl->setData('title', trans('contact::web.contact'));

        $this->tpl->breadcrumb()->add('/contact', trans('contact::web.contact'));

        if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }

    public function send(Request $request)
    {
        if($this->verifyCaptcha(request('g-recaptcha-response')))
        {
            Mail::send(new ContactMail($request));
            return [
                'status' => 200,
                'message' => trans('contact::web.send_contact_success')
            ];
        }else{
            return [
                'status' => 500,
                'message' => trans('contact::web.send_error')
            ];
        }
    }

    public function verifyCaptcha($value)
    {
        if (get_option('recaptcha_secret_key')) {
            try {
                $client = new Client();
                $request = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                    'form_params' => [
                        'secret' => get_option('recaptcha_secret_key'),
                        'response' => $value
                    ]
                ]);
                $body = json_decode($request->getBody(), true);

                return !! @$body['success'];
            } catch (\Exception $e) {
                return false;
            }
        }
        return true;
    }
}
