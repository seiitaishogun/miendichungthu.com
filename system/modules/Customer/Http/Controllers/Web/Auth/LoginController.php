<?php
namespace Modules\Customer\Http\Controllers\Web\Auth;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class LoginController extends WebController
{
    /*
     * |--------------------------------------------------------------------------
     * | Login Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles authenticating users for the application and
     * | redirecting them to your home screen. The controller uses a trait
     * | to conveniently provide its functionality to your applications.
     * |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct(TemplateInterface $tpl)
    {
        parent::__construct($tpl);
        $this->middleware('guest:customer')->except('logout');
    }

    /**
     * Show the kiosk's login form.
     */
    public function showLoginForm()
    {
        $this->tpl->setTemplateFrontend('auth.login', 'customer');

        $this->tpl->setData('title', trans('custom.shop.login'));

        $this->tpl->breadcrumb()->add('customer.login', trans('custom.shop.login'));

        return $this->tpl->render();
    }

    public function showAlertUserForm()
    {
        $this->tpl->setTemplateFrontend('auth.alert-user', 'customer');

        $this->tpl->setData('title', trans('custom.shop.login'));

        $this->tpl->breadcrumb()->add('customer.login', trans('custom.shop.login'));

        return $this->tpl->render();
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('customer');
    }

    protected function authenticated(Request $request, $user) {
        if(isset($user) && !$user->activated) {
            Auth::guard('customer')->logout();
            return redirect('alert-user')->with(['alert_user' => 'none_verify']);
        }
        if ($request->has('redirect')) {
            return redirect($request->input('redirect'));
        }
    }
}
