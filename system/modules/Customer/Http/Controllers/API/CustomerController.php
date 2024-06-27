<?php
namespace Modules\Customer\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\WebController;
use Modules\Customer\Models\Customer;

class CustomerController extends WebController
{

    public function getInfoById(Request $request)
    {
        $customer = Customer::with('addresses')->where('id', $request->get('id'))
            ->firstOrFail();
        
        if ($request->get('type') == 'json') {
            return response()->json([
                'status' => 200,
                'result' => $customer
            ]);
        } elseif ($request->get('type') == 'html') {
            return view('cart::api.customer_info_box', compact('customer'));
        }
    }
}
