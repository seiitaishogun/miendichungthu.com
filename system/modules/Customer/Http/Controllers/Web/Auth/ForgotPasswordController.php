<?php
namespace Modules\Customer\Http\Controllers\Web\Auth;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends WebController
{
    /*
     * |--------------------------------------------------------------------------
     * | Password Reset Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller is responsible for handling password reset emails and
     * | includes a trait which assists in sending these notifications from
     * | your application to your users. Feel free to explore this trait.
     * |
     */
    
    use SendsPasswordResetEmails;

    public function __construct(TemplateInterface $tpl)
    {
        parent::__construct($tpl);
        $this->middleware('guest:customer')->except('logout');
    }

    public function showLinkRequestForm()
    {
        $this->tpl->setTemplateFrontend('auth.password.reset', 'customer');
        
        $this->tpl->setData('title', trans('custom.shop.forgot_password'));
        
        $this->tpl->breadcrumb()->add('customer.password.request', trans('custom.shop.forgot_password'));
        
        return $this->tpl->render();
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker('customers');
    }
}
