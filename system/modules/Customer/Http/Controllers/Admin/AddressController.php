<?php
namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Customer\Models\Address;
use Modules\Customer\Models\Customer;
use Yajra\Datatables\Facades\Datatables;
use App\Http\Controllers\AdminController;

class AddressController extends AdminController
{

    public function index(Request $request, Customer $customer)
    {
        if ($request->ajax()) {
            return $this->data($customer->addresses());
        }
        
        $this->tpl->setData('title', trans('customer::language.customer_manager') . ' :: ' . $customer->full_name);
        $this->tpl->setData('customer', $customer);
        $this->tpl->setTemplate('customer::admin.address.index');
        
        // breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add(admin_route('customer.address.index', $customer->id), trans('customer::language.addresses'));
        
        // Datatables
        $this->tpl->datatable()->setSource(admin_route('customer.address.index', $customer->id));
        $this->tpl->datatable()->addColumn('#', 'id', [
            'class' => 'col-md-1'
        ]);
        $this->tpl->datatable()->addColumn(trans('customer::language.account'), 'full_name', [
            'class' => 'col-md-3'
        ], false, false);
        
        $this->tpl->datatable()->addColumn(trans('customer::language.phone'), 'phone', []);
        
        $this->tpl->datatable()->addColumn(trans('customer::language.address'), 'address', []);
        
        $this->tpl->datatable()->addColumn(trans('customer::language.district'), 'district', []);
        
        $this->tpl->datatable()->addColumn(trans('customer::language.province'), 'province', []);
        
        return $this->tpl->render();
    }

    public function data($model)
    {
        app('helper')->load('buttons');
        
        return Datatables::eloquent($model)->addColumn('full_name', function ($model) {
            return sprintf('<a href="%s">%s</a> %s', admin_route('customer.address.edit', [
                'customer' => $model->customer->id,
                'address' => $model->id
            ]), $model->full_name, $model->default ? sprintf('<span class="label label-warning">%s</span>', trans('customer::language.default')) : '');
        })
            ->addColumn('action', function ($model) {
            $button = [];
            
            // edit role
            if (allow('customer.address.edit')) {
                
                $button[] = [
                    'route' => admin_route('customer.address.edit', [
                        'customer' => $model->customer->id,
                        'address' => $model->id
                    ]),
                    'name' => trans('language.edit'),
                    'icon' => 'fa fa-pencil-square-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-primary'
                    ]
                ];
            }
            
            // delete
            if (allow('customer.address.destroy')) {
                $button[] = [
                    'route' => 'javascript:void(0);',
                    'name' => trans('language.delete'),
                    'icon' => 'fa fa-trash-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-danger',
                        'data-url' => admin_route('customer.address.destroy', [
                            'customer' => $model->customer->id,
                            'address' => $model->id
                        ]),
                        'data-action' => 'confirm_to_delete',
                        'data-message' => trans('language.confirm_to_delete')
                    ]
                ];
            }

            
            return cnv_action_block($button);
        })
            ->rawColumns([
            'action',
            'full_name'
        ])
            ->make(true);
    }

    public function create(Customer $customer, Address $address)
    {
        $this->tpl->setData('title', trans('customer::language.customer_address_create'));
        $this->tpl->setTemplate('customer::admin.address.create');
        
        $address->default = false;
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add(admin_route('customer.address.index', $customer->id), trans('customer::language.addresses'));
        $this->tpl->breadcrumb()->add(admin_route('customer.address.create', $customer->id), trans('customer::language.customer_address_create'));
        

        // set data default
        $this->tpl->setData('customer', $customer);
        $this->tpl->setData('address', $address);
        return $this->tpl->render();
    }

    public function store(Request $request, Customer $customer, Address $address)
    {
        if (! $request->ajax()) {
            return;
        }
        
        $data = $request->all();
        $data['default'] = ! $request->has('default') ? false : true;
        
        if (! $customer->addresses()
            ->where('default', true)
            ->first() && ! $data['default']) {
            return response()->json([
                'status' => 500,
                'message' => trans('customer::language.you_not_have_default_address')
            ]);
        }
        
        $address = new Address($data);
        
        if ($customer = $customer->addresses()->save($address)) {
            return response()->json([
                'status' => 200,
                'message' => trans('language.create_success')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.create_fail')
            ]);
        }
    }

    public function edit(Request $request, Customer $customer, Address $address)
    {
        $this->tpl->setData('title', trans('customer::language.customer_address_edit'));
        $this->tpl->setTemplate('customer::admin.address.edit');
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add(admin_route('customer.address.index', $customer->id), trans('customer::language.addresses'));
        $this->tpl->breadcrumb()->add(admin_route('customer.address.edit', [
            'customer' => $customer->id,
            'address' => $address->id
        ]), trans('customer::language.customer_address_edit'));
        
        // set data default
        $this->tpl->setData('customer', $customer);
        $this->tpl->setData('address', $address);
        return $this->tpl->render();
    }

    public function update(Request $request, Customer $customer, Address $address)
    {
        if (! $request->ajax()) {
            return;
        }
        $data = $request->all();
        $data['default'] = ! $request->has('default') ? false : true;
        
        if (! $customer->addresses()
            ->where('default', true)
            ->where('id', '<>', $address->id)
            ->first() && ! $data['default']) {
            return response()->json([
                'status' => 500,
                'message' => trans('customer::language.you_not_have_default_address')
            ]);
        }
        
        if ($address->update($data)) {
            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail')
            ]);
        }
    }

    public function destroy(Request $request, Customer $customer, Address $address)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($address->default == true) {
            return response()->json([
                'status' => 500,
                'message' => trans('customer::language.you_could_not_to_delete_default_address')
            ]);
        }
        
        if ($address->delete()) {
            return response()->json([
                'status' => 200,
                'message' => trans('language.delete_success')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.delete_fail')
            ]);
        }
    }
}
