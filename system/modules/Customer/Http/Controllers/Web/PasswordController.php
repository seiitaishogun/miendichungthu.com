<?php
namespace Modules\Customer\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends WebController
{

    public function index()
    {
        $this->tpl->setTemplateFrontend('password', 'customer');

        $this->tpl->setData('title', trans('custom.shop.change_password'));

        $this->tpl->breadcrumb()->add('customer.profile', trans('custom.shop.profile'));
        $this->tpl->breadcrumb()->add('customer.password', trans('custom.shop.change_password'));

        return $this->tpl->render();
    }

    public function change(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required|min:4',
            'password' => 'required|min:4|confirmed'
        ]);

        if (Hash::check($request->input('old_password'), $request->user('customer')->password)) {
            $request->user('customer')->update([
                'password' => bcrypt($request->input('password'))
            ]);

            return back()->with('message', trans('customer::language.changed_password'));
        }

        return back()->with('error', trans('customer::language.wrong_password'));
    }
}
