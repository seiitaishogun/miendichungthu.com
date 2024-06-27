<?php
namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Modules\Acl\Models\Role;
use Modules\Customer\Models\Customer;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\AdminController;
use Modules\Customer\Http\Requests\CustomerRequest;
use Illuminate\Support\Facades\Mail;
use Modules\Customer\Mails\SuccessMail;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Customer\Http\Controllers\Admin\Export\CustomerExport;

class CustomerController extends AdminController
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            if($request->has('id')) {
                return $this->show($request->get('id'));
            }
            return $this->data($request);
        }
        
        $this->tpl->setData('title', trans('customer::language.customer_manager'));
        $this->tpl->setTemplate('customer::admin.index');
        
        // breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        
        // DataTables
        $this->tpl->datatable()->setSource(admin_route('customer.index') . '?filter=' . encrypt($request->all()));
        $this->tpl->datatable()->addColumn('#', 'id', [
            'class' => 'col-md-1'
        ]);
        $this->tpl->datatable()->addColumn(trans('customer::language.user_identifycation'), 'user_identifycation', [
            'class' => 'col-md-2'
        ], false, false);
        $this->tpl->datatable()->addColumn(trans('customer::language.account'), 'name', [
            'class' => 'col-md-2'
        ], false, false);
        $this->tpl->datatable()->addColumn(trans('customer::language.email'), 'email', [
            'class' => 'col-md-2'
        ]);
        $this->tpl->datatable()->addColumn(trans('language.status'), 'activated', []);
        // if(allow('customer.group.index')) {
        //     $this->tpl->datatable()->addColumn('Nhóm', 'group', [], false, false);
        // }
        // if(allow('customer.source.index')) {
        //     $this->tpl->datatable()->addColumn('Nguồn', 'source', [], false, false);
        // }
        // if(allow('customer.address.index')) {
        //     $this->tpl->datatable()->addColumn(trans('customer::language.addresses'), 'addresses', [], false, false);
        // }
        return $this->tpl->render();
    }

    protected function show($id)
    {
        $customer = Customer::with('addresses')->where('id', $id)->firstOrFail();
        return view('customer::admin.show', compact('customer'));
    }

    public function data(Request $request)
    {
        app('helper')->load('buttons');
        $model = Customer::query();
        
        if ($request->has('filter')) {
            $filter = decrypt($request->get('filter'));
            if (isset($filter['group']) && $filter['group'] > 0) {
                $model = $model->where('customer_group_id', $filter['group']);
            }
            if (isset($filter['source']) && $filter['source'] > 0) {
                $model = $model->where('customer_source_id', $filter['source']);
            }
        }
        
        return DataTables::eloquent($model)->addColumn('name', function ($model) {
            $affiliate = '';
            if($model->affiliate) {
                $affiliate = sprintf('<span class="label label-info">%s</span>', 'Affiliate');
            }
            return sprintf('<h4>%s</h4> %s', sprintf('<a href="javascript:void(0);" onclick="showData(%d);">%s</a>', $model->id, $model->first_name.' '.$model->last_name), $affiliate);
        })
        //     ->addColumn('addresses', function ($model) {
        //     return sprintf('<a href="%s" class="btn btn-xs btn-alt btn-info">%s</a>', admin_route('customer.address.index', $model->id), trans('customer::language.addresses'));
        // })
            ->addColumn('action', function ($model) {
            $button = [];
            
            // edit role
            if (allow('customer.customer.edit')) {
                $button[] = [
                    'route' => admin_route('customer.edit', $model->id),
                    'name' => trans('language.edit'),
                    'icon' => 'fa fa-pencil-square-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-primary'
                    ]
                ];
            }
            
            // delete
            if (allow('customer.customer.destroy')) {
                $button[] = [
                    'route' => 'javascript:void(0);',
                    'name' => trans('language.delete'),
                    'icon' => 'fa fa-trash-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-danger',
                        'data-url' => admin_route('customer.destroy', $model->id),
                        'data-action' => 'confirm_to_delete',
                        'data-message' => trans('language.confirm_to_delete')
                    ]
                ];
            }
            
            return cnv_action_block($button);
        })
            ->editColumn('activated', function ($model) {
            return sprintf('<span class="label label-%s">%s</span>', $model->activated ? 'success' : 'warning', $model->activated ? trans('language.activated') : trans('language.inactivated'));
        })
            ->addColumn('group', function ($model) {
            return $model->group ? sprintf('<a href="%s" class="text-info">%s</a> <br>', admin_route('customer.group.edit', $model->group->id), $model->group->name) : 'N/A';
        })
            ->addColumn('source', function ($model) {
            return $model->source ? sprintf('<a href="%s" class="text-warning">%s</a> <br>', admin_route('customer.source.edit', $model->source->id), $model->source->name) : 'N/A';
        })
            ->rawColumns([
            'action',
            'activated',
            'name',
            // 'addresses',
            'source',
            'group'
        ])
            ->make(true);
    }

    public function create(Customer $customer)
    {
        $this->tpl->setData('title', trans('customer::language.customer_create'));
        $this->tpl->setTemplate('customer::admin.create');
        
        $customer->activated = true;
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.create', trans('customer::language.customer_create'));
        
        // set data default
        $this->tpl->setData('customer', $customer);
        return $this->tpl->render();
    }

    public function store(CustomerRequest $request, Customer $customer)
    {
        if (! $request->ajax()) {
            return;
        }
        
        $data = $customer->readyProfile($request);
        // mặc định mật khẩu 123456
        if (! isset($data['password'])) {
            $data['password'] = bcrypt(time());
        }
        
        if ($customer = Customer::create($data)) {
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

    public function edit(Request $request, Customer $customer)
    {
        $this->tpl->setData('title', trans('customer::language.customer_edit'));
        $this->tpl->setTemplate('customer::admin.edit');
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add(admin_route('customer.edit', $customer->id), trans('customer::language.customer_edit'));
        
        // set data default
        $this->tpl->setData('customer', $customer);
        return $this->tpl->render();
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        if (! $request->ajax()) {
            return;
        }
        $data = $customer->readyProfile($request); 
        if ($customer->update($data)) {
            if($data["activated"] == 1 && $data["user_confirm"] != 2) {
                Mail::send(new SuccessMail($customer));
                Customer::where('id', $customer->id)
                ->update(['user_confirm' => 2]);
            }
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

    public function destroy(Request $request, Customer $customer)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($customer->customername == 'admin') {
            return response()->json([
                'status' => 500,
                'message' => trans('customer::language.you_could_not_to_delete_admin')
            ]);
        }
        
        if ($customer->delete()) {
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

    public function export(string $lang){
        $date = date('Y-m-d', time());
        return Excel::download(new CustomerExport($lang), 'Customers-'.$date.'.xls');
    }
}
