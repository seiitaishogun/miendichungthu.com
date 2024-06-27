<?php
namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Modules\Customer\Models\Group;
use Yajra\DataTables\Facades\DataTables;

class GroupController extends AdminController
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data();
        }
        
        $this->tpl->setData('title', trans('customer::language.group_manager'));
        $this->tpl->setTemplate('customer::admin.group.index');
        
        // breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.group.index', trans('customer::language.group_manager'));
        
        // DataTables
        $this->tpl->datatable()->setSource(admin_route('customer.group.index'));
        $this->tpl->datatable()->addColumn('#', 'id', [
            'class' => 'col-md-1'
        ]);
        $this->tpl->datatable()->addColumn('Tên', 'name', []);
        $this->tpl->datatable()->addColumn(trans('language.updated_at'), 'updated_at', []);
        
        return $this->tpl->render();
    }

    public function data()
    {
        app('helper')->load('buttons');
        
        return DataTables::eloquent(Group::query())->addColumn('action', function ($model) {
            $button = [];
            
            // edit role
            if (allow('customer.group.edit')) {
                $button[] = [
                    'route' => admin_route('customer.group.edit', $model->id),
                    'name' => trans('language.edit'),
                    'icon' => 'fa fa-pencil-square-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-primary'
                    ]
                ];
            }
            
            // delete
            if (allow('customer.group.destroy')) {
                $button[] = [
                    'route' => 'javascript:void(0);',
                    'name' => trans('language.delete'),
                    'icon' => 'fa fa-trash-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-danger',
                        'data-url' => admin_route('customer.group.destroy', $model->id),
                        'data-action' => 'confirm_to_delete',
                        'data-message' => trans('language.confirm_to_delete')
                    ]
                ];
            }
            
            return cnv_action_block($button);
        })->make(true);
    }

    public function create(Group $group)
    {
        $this->tpl->setData('title', trans('customer::language.group_create'));
        $this->tpl->setTemplate('customer::admin.group.create');
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.group.index', trans('customer::language.group_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.group.create', trans('customer::language.group_create'));
        
        // set data default
        $this->tpl->setData('group', $group);
        return $this->tpl->render();
    }

    public function store(Request $request, Group $group)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($group->create($request->all())) {
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

    public function edit(Group $group)
    {
        $this->tpl->setData('title', trans('customer::language.group_edit'));
        $this->tpl->setTemplate('customer::admin.group.edit');
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.group.index', trans('customer::language.group_manager'));
        $this->tpl->breadcrumb()->add(admin_route('customer.group.edit', $group->id), trans('customer::language.group_edit'));
        
        // set data default
        $this->tpl->setData('group', $group);
        return $this->tpl->render();
    }

    public function update(Request $request, Group $group)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($group->update($request->all())) {
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

    public function destroy(Request $request, Group $group)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($group->delete()) {
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