<?php

namespace Modules\Page\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\Libraries\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Page\Http\Requests\PageRequest;
use Modules\Page\Models\Page;
use Modules\Page\Models\PageLanguage;
use Yajra\DataTables\Facades\DataTables;

class PageController extends AdminController
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->data($request);
        }

        $this->tpl->setData('title', trans('page::language.manager'));
        $this->tpl->setTemplate('page::admin.index');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.page.index', trans('page::language.manager'));

        // datatable
        $this->tpl->datatable()->setSource(admin_route('page.index') . '?language=' . $request->get('language'));
        $this->tpl->datatable()->addColumn(
            '#',
            'id',
            ['class' => 'col-md-1']
        );
        $this->tpl->datatable()->addColumn(
            trans('language.name'),
            'name',
            ['class' => 'col-md-6']
        );
        $this->tpl->datatable()->addColumn(
            trans('language.status'),
            'page.published',
            ['class' => 'col-md-2'],
            false,
            true
        );
        $this->tpl->datatable()->addColumn(
            trans('language.updated_at'),
            'page.updated_at'
        );

        return $this->tpl->render();
    }

    public function data(Request $request)
    {
        $language = $request->filled('language') ? $request->get('language') : config('cnv.language_default');
        $model = PageLanguage::with('page')->where('locale', $language);

        return DataTables::eloquent($model)
            ->editColumn('name', function($model) {
                $html = '<h4>';
                $html .= link_to_route('admin.page.edit', $model->name, ['page' => $model->page->id]);
                $html .= '</h4>';
                $html .= '<p>' . $model->description . '</p>';

                return $html;
            })
            ->addColumn('action', function($model) {
                app('helper')->load('buttons');
                $button = [];

                $button[] = [
                    'route' => route('page.show', $model->slug),
                    'name' => trans('language.show'),
                    'icon' => 'fa fa-eye',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-warning',
                        'target' => '_blank'
                    ],
                 ];

                // edit role
                if(allow('page.page.edit')) {
                    $button[] = [
                        'route' => admin_route('page.edit', $model->page->id),
                        'name' => trans('language.edit'),
                        'icon' => 'fa fa-pencil-square-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-primary'
                        ]
                    ];
                }

                // delete
                if(! in_array($model->page->id, [1,2 , 9]))
                if(allow('page.page.destroy')) {
                    $button[] = [
                        'route' => 'javascript:void(0);',
                        'name' => trans('language.delete'),
                        'icon' => 'fa fa-trash-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-danger',
                            'data-url' => admin_route('page.destroy', $model->page->id),
                            'data-action' => 'confirm_to_delete',
                            'data-message' => trans('language.confirm_to_delete')
                        ]
                    ];
                }

                return cnv_action_block($button);
            })
            ->editColumn('page.published', function ($model) {
                return sprintf(
                    '<span class="label label-%s">%s</span>',
                    $model->page->published ? 'success' : 'warning',
                    $model->page->published ? trans('language.published') : trans('language.trashed')
                );
            })
            ->rawColumns(['name', 'action', 'page.published'])
            ->make(true);
    }

    public function create(Page $page)
    {
        $page->published_at = Carbon::now();
        $page->published = true;

        $this->tpl->setData('title', trans('page::language.page_create'));
        $this->tpl->setData('page', $page);
        $this->tpl->setTemplate('page::admin.create');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.page.index', trans('page::language.manager'));
        $this->tpl->breadcrumb()->add(admin_route('page.create'), trans('page::language.page_create'));

        return $this->tpl->render();
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'language']);
        $data['published'] = $request->has('published') ? true : false;
        $data['published_at'] = Carbon::createFromFormat('d-m-Y H:i', $this->getDatetimeOrCreateFromNow($request));

        if ($page = Page::create($data)) {
            $page->saveLanguages($request->only('language'));

            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success'),
                'redirect_url' => admin_route('page.edit', $page->id)
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail'),
            ]);
        }
    }

    public function edit(Page $page)
    {
        $this->tpl->setData('title', trans('page::language.page_edit'));
        $this->tpl->setData('page', $page);
        $this->tpl->setTemplate('page::admin.edit');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.page.index', trans('page::language.manager'));
        $this->tpl->breadcrumb()->add(admin_route('page.edit', $page->id), trans('page::language.page_edit'));

        return $this->tpl->render();
    }

    public function update(PageRequest $request, Page $page)
    {
        if(! $request->ajax()) {
            return;
        }

        $data = $request->except(['_token', 'language']);
        $data['published'] = $request->has('published') ? true : false;
        $data['published_at'] = Carbon::createFromFormat('d-m-Y H:i', $this->getDatetimeOrCreateFromNow($request));

        $page->update($data);
        $page->saveLanguages($request->only('language'));

        return response()->json([
            'status' => 200,
            'message' => trans('language.update_success'),
        ]);
    }

    public function destroy(Request $request, Page $page)
    {
        if(! $request->ajax()) {
            return;
        }

        if($page->delete()) {
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

    protected function getDatetimeOrCreateFromNow(Request $request)
    {
        $date = $request->has('date_published') ? $request->input('date_published') : date('d-m-Y');
        $time = $request->has('time_published') ? $request->input('time_published') : '00:00';

        return $date . ' ' . $time;
    }
}
