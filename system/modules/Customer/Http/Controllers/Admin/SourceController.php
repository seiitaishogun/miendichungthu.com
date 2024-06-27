<?php
namespace Modules\Customer\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Modules\Customer\Models\Source;
use Yajra\DataTables\Facades\DataTables;

class SourceController extends AdminController
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->data();
        }
        
        $this->tpl->setData('title', trans('customer::language.source_manager'));
        $this->tpl->setTemplate('customer::admin.source.index');
        
        // breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.source.index', trans('customer::language.source_manager'));
        
        // DataTables
        $this->tpl->datatable()->setSource(admin_route('customer.source.index'));
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
        
        return DataTables::eloquent(Source::query())->addColumn('action', function ($model) {
            $button = [];
            
            // edit role
            if (allow('customer.source.edit')) {
                $button[] = [
                    'route' => admin_route('customer.source.edit', $model->id),
                    'name' => trans('language.edit'),
                    'icon' => 'fa fa-pencil-square-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-primary'
                    ]
                ];
            }
            
            // delete
            if (allow('customer.source.destroy')) {
                $button[] = [
                    'route' => 'javascript:void(0);',
                    'name' => trans('language.delete'),
                    'icon' => 'fa fa-trash-o',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-danger',
                        'data-url' => admin_route('customer.source.destroy', $model->id),
                        'data-action' => 'confirm_to_delete',
                        'data-message' => trans('language.confirm_to_delete')
                    ]
                ];
            }
            
            return cnv_action_block($button);
        })->make(true);
    }

    public function create(Source $source)
    {
        $this->tpl->setData('title', trans('customer::language.source_create'));
        $this->tpl->setTemplate('customer::admin.source.create');
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.source.index', trans('customer::language.source_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.source.create', trans('customer::language.source_create'));
        
        // set data default
        $this->tpl->setData('source', $source);
        return $this->tpl->render();
    }

    public function store(Request $request, Source $source)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($source->create($request->all())) {
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

    public function edit(Source $source)
    {
        $this->tpl->setData('title', trans('customer::language.source_edit'));
        $this->tpl->setTemplate('customer::admin.source.edit');
        
        // Breadcrumb
        $this->tpl->breadcrumb()->add('/' . admin_path(), trans('language.dashboard'));
        $this->tpl->breadcrumb()->add('admin.customer.index', trans('customer::language.customer_manager'));
        $this->tpl->breadcrumb()->add('admin.customer.source.index', trans('customer::language.source_manager'));
        $this->tpl->breadcrumb()->add(admin_route('customer.source.edit', $source->id), trans('customer::language.source_edit'));
        
        // set data default
        $this->tpl->setData('source', $source);
        return $this->tpl->render();
    }

    public function update(Request $request, Source $source)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($source->update($request->all())) {
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

    public function destroy(Request $request, Source $source)
    {
        if (! $request->ajax()) {
            return;
        }
        
        if ($source->delete()) {
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