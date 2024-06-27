<?php
namespace Modules\Customer\Http\Controllers\Web;

use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Modules\Customer\Models\Address;

class ProfileController extends WebController
{

    public function index(Request $request)
    {
        $this->tpl->setTemplateFrontend('profile', 'customer');

        $this->tpl->setData('title', trans('custom.shop.profile'));
        $this->tpl->setData('user', $request->user('customer'));
        $this->tpl->setData('address', $request->user('customer')->addresses->first() ?: new Address());

        $this->tpl->breadcrumb()->add('customer.profile', trans('custom.shop.profile'));

        return $this->tpl->render();
    }

    public function change(Request $request)
    {
        $this->validate($request, [
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'phone' => 'required|string|min:9|max:20',
            'address' => 'required|string|max:255'
        ]);

        $data = $request->except([
            '_token',
            'email',
            'password'
        ]);

        if ($request->user('customer')->update($data)) {
            $address = $request->user('customer')->addresses->first();
            $dataAddress = [
                'phone' => $data['phone'],
                'address' => $data['address'],
                'province' => $data['province'],
                'district' => $data['district'],
                'ward' => $data['ward'],
            ];
            if($address) {
                $address->update($dataAddress);
            } else {
                $request->user('customer')->addresses()->save(
                    new Address($dataAddress)
                );
            }

            return back()->with('message', trans('language.update_success'));
        }

        return back()->with('error', trans('language.update_fail'));
    }

    public function affiliate(Request $request)
    {
        $this->tpl->setTemplateFrontend('affiliate', 'customer');

        $user = $request->user('customer');

        $this->tpl->setData('title', trans('customer::language.affiliate'));
        $this->tpl->setData('user', $user);
        $this->tpl->setData('orders', $user->affiliateOrders()->paginate(20));

        $this->tpl->breadcrumb()->add('customer.affiliate', trans('customer::affiliate'));

        return $this->tpl->render();
    }
}
