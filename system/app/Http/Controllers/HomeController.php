<?php

namespace App\Http\Controllers;

use App\Libraries\Thumbnail;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Models\Customer;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Mails\VerifyMail;
use Cookie;

class HomeController extends WebController
{
    public function index()
    {
        $this->tpl->setTemplate('theme::home');
        $verify = session()->get('user_verify');
        if($verify) {
            session()->forget('user_verify');
            $customer = Customer::where('user_verify', $verify)->first();
            if(!$customer->user_confirm){
                Customer::where('user_verify', $verify)
                ->update(['user_confirm' => 1]);
                return redirect('alert-user')->with(['alert_user' => 'verify']);
                //Mail::send(new VerifyMail($customer));
            }
        }
        if ( !isset($_COOKIE['user']) || empty($_COOKIE['user']) ) {
        // if (! Auth::guard('customer')->check()) {
            return redirect('/login');
        }

        return $this->tpl->render();
    }

    public function test()
    {
        $this->tpl->setTemplate('theme::test_home');

        return $this->tpl->render();
    }

    public function thumbnail($hash = null)
    {
        return app()->make(Thumbnail::class)->imageGenerator($hash);
    }
}