<?php
namespace Modules\Customer\Http\Controllers\Web\Auth;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends WebController
{
    /*
     * |--------------------------------------------------------------------------
     * | Password Reset Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller is responsible for handling password reset requests
     * | and uses a simple trait to include this behavior. You're free to
     * | explore this trait and override any methods you wish to tweak.
     * |
     */
    
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct(TemplateInterface $tpl)
    {
        parent::__construct($tpl);
        $this->middleware('guest:customer');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $this->tpl->setTemplateFrontend('auth.password.email', 'customer');
        
        $this->tpl->setData('title', trans('custom.shop.reset_password'));
        $this->tpl->setData('token', $token);
        
        $this->tpl->breadcrumb()->add(route('customer.password.reset', $token), trans('custom.shop.reset_password'));
        
        return $this->tpl->render();
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('customers');
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
}
