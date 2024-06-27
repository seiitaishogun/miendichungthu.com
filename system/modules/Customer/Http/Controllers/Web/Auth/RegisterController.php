<?php

namespace Modules\Customer\Http\Controllers\Web\Auth;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Customer\Models\Address;
use Modules\Customer\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Mails\CustomerMail;
use Modules\Customer\Mails\AdminMail;

class RegisterController extends WebController
{
    /*
     * |--------------------------------------------------------------------------
     * | Register Controller
     * |--------------------------------------------------------------------------
     * |
     * | This controller handles the registration of new users as well as their
     * | validation and creation. By default this controller uses a trait to
     * | provide this functionality without requiring any additional code.
     * |
     */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function __construct(TemplateInterface $tpl)
    {
        parent::__construct($tpl);
        $this->middleware('guest:customer');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        /* return Validator::make($data, [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|min:9|max:20',
            'address' => 'required|string|max:255'
        ]);*/

        return Validator::make(
            $data,
            [
                'last_name' => 'required|string|max:255',
                'first_name' => 'required|string|max:255',
                'hospital' => 'required',
                'province' => 'required',
                'job' => 'required',
                'specialists' => 'required',
                'email' => 'required|string|email|max:255|unique:customers',
                'password' => 'required|string|min:6|confirmed',
                'phone' => 'required|string|min:9|max:20',
                'recived_promo_mail' => 'required',
                'privacy_policy' => 'required',
                'terms_of_use' => 'required',
                // 'address' => 'required|string|max:255'
            ],
            [
                'hospital.required' => 'Bạn chưa chọn bệnh viện',
                'province.required' => 'Bạn chưa chọn Tỉnh / Thành Phố',
                'specialists.required' => 'Bạn chưa chọn chuyên khoa',
                'job.required' => 'Bạn chưa chọn nghề nghiệp',
                'recived_promo_mail.required' => 'Bạn chưa chọn nhận thông báo mới',
                'privacy_policy.required' => 'Bạn chưa chọn điều khoản riêng tư',
                'terms_of_use.required' => 'Bạn chưa chọn điều khoản sử dụng',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $customer = Customer::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'sex' => @$data['sex'] ? true : false,
            'note' => '',
            'tags' => '',
            'activated' => false,
            'recived_promo_mail' => @$data['recived_promo_mail'] ? true : false
        ]);
        $address = new Address([
            'first_name' => @$data['first_name'],
            'last_name' => @$data['last_name'],
            'phone' => @$data['phone'],
            // 'address' => @$data['address'] ?: '',
            'province' => @$data['province'] ?: '',
            // 'district' => @$data['district'] ?: '',
            // 'ward' => @$data['ward'] ?: '',
            'hospital' => @$data['hospital'] ?: '',
            'specialists' => @$data['specialists'] ?: '',
            'experience' => @$data['experience'] ?: '',
            'job' => @$data['job'] ?: '',
            'prefix' => @$data['prefix'] ?: '',
        ]);
        $customer->addresses()->save($address);

        
        Mail::send(new CustomerMail($customer));
        Mail::send(new AdminMail($customer));

        return $customer;
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

    public function showRegistrationForm()
    {
        $this->tpl->setTemplateFrontend('auth.register', 'customer');

        $this->tpl->setData('title', trans('custom.shop.register'));

        $this->tpl->breadcrumb()->add('customer.register', trans('custom.shop.register'));

        return $this->tpl->render();
    }

    protected function registered(Request $request, $user)
    {
        Auth::guard('customer')->logout();
        //return redirect('alert-user')->with(['alert_user' => 'success']);
        /*if(Auth::guard('customer')->user()->activated == true){
             Auth::guard('customer')->logout();
             return redirect('login')->with('message_register_success',session('lang') ? 'Bạn đã đăng ký thành công , vui lòng dùng tài khoản bạn đã đăng ký đăng nhập vào hệ thống' : 'You have successfully registered, please enter your login with account regsiter');
        }*/
        if ($request->has('redirect')) {
            return redirect($request->input('redirect'));
        }
    }
}
