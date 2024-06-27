<?php

namespace Modules\Gallery\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Gallery\Models\Gallery;
use Modules\Gallery\Models\GalleryLanguage;
use Yajra\DataTables\Facades\DataTables;
use DB;
class GalleryController extends AdminController
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->data($request);
        }

        $this->tpl->setData('title', trans('gallery::language.manager'));
        $this->tpl->setTemplate('gallery::admin.index');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.gallery.index', trans('gallery::language.manager'));

        // datatable
        $this->tpl->datatable()->setSource(admin_route('gallery.index') . '?language=' . $request->get('language'));
        $this->tpl->datatable()->addColumn(
            '#',
            'id',
            ['class' => 'col-md-1']
        );
        $this->tpl->datatable()->addColumn(
            '<i class="fa fa-picture-o"></i>',
            'thumbnail',
            ['class' => 'col-md-2'],
            false,
            false
        );
        $this->tpl->datatable()->addColumn(
            trans('language.name'),
            'name',
            ['class' => 'col-md-4']
        );
        $this->tpl->datatable()->addColumn(
            trans('language.status'),
            'gallery.published',
            ['class' => 'col-md-2'],
            false,
            true
        );
        $this->tpl->datatable()->addColumn(
            trans('language.updated_at'),
            'gallery.updated_at'
        );

        return $this->tpl->render();
    }

    public function data(Request $request)
    {
        $language = $request->filled('language') ? $request->get('language') : config('cnv.language_default');
        $model = GalleryLanguage::with('gallery')->where('locale', $language);

        return DataTables::eloquent($model)
            ->editColumn('thumbnail', function ($model){
                return sprintf('<div class="%s"><img src="%s" width="120" class="img-rounded"></div>', 'text-center', $model->thumbnail);
            })
            ->editColumn('name', function($model) {
                $html = '<strong>';
                $html .= sprintf(
                    '<span class="label label-%s">%s</span> ',
                    $model->gallery->type == 'video' ? 'info' : 'success',
                    $model->gallery->type == 'video' ? 'video' : 'album'
                    );
                $html .= link_to_route('admin.gallery.edit', $model->name, ['page' => $model->gallery->id]);
                $html .= '</strong>';
                $html .= '<p>' . $model->description . '</p>';

                return $html;
            })
            ->addColumn('action', function($model) {
                app('helper')->load('buttons');
                $button = [];

                $button[] = [
                    'route' => route('gallery.show', $model->slug),
                    'name' => trans('language.show'),
                    'icon' => 'fa fa-eye',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-warning',
                        'target' => '_blank'
                    ],
                ];

                // edit role
                if(allow('gallery.gallery.edit')) {
                    $button[] = [
                        'route' => admin_route('gallery.edit', $model->gallery->id),
                        'name' => trans('language.edit'),
                        'icon' => 'fa fa-pencil-square-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-primary'
                        ]
                    ];
                }

                // delete
                if(allow('gallery.gallery.destroy')) {
                    $button[] = [
                        'route' => 'javascript:void(0);',
                        'name' => trans('language.delete'),
                        'icon' => 'fa fa-trash-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-danger',
                            'data-url' => admin_route('gallery.destroy', $model->gallery->id),
                            'data-action' => 'confirm_to_delete',
                            'data-message' => trans('language.confirm_to_delete')
                        ]
                    ];
                }

                return cnv_action_block($button);
            })
            ->editColumn('gallery.published', function ($model) {
                return sprintf(
                    '<span class="label label-%s">%s</span>',
                    $model->gallery->published ? 'success' : 'warning',
                    $model->gallery->published ? trans('language.published') : trans('language.trashed')
                );
            })
            ->rawColumns(['name', 'action', 'gallery.published', 'thumbnail' ])
            ->make(true);
    }

    public function create(Request $request, Gallery $gallery)
    {
        if($request->ajax()) {
            return $this->getForm($request->get('type'), $gallery);
        }

        $gallery->published_at = Carbon::now();
        $gallery->published = true;

        $this->tpl->setData('title', trans('gallery::language.gallery_create'));
        $this->tpl->setData('gallery', $gallery);
        $this->tpl->setTemplate('gallery::admin.create');

        // breadcrumb
        $this->tpl->breadcrumb()->add(admin_route('gallery.index'), trans('gallery::language.manager'));
        $this->tpl->breadcrumb()->add(admin_route('gallery.create'), trans('gallery::language.gallery_create'));

        return $this->tpl->render();
    }

    public function store(Request $request)
    {
        if(! $request->ajax()) {
            return;
        }

        $data = $request->except(['_token', 'language']);

        $data['featured'] = $request->has('featured') ? true : false;
        $data['published'] = $request->has('published') ? true : false;
        $data['published_at'] = Carbon::createFromFormat('d-m-Y H:i', $this->getDatetimeOrCreateFromNow($request));

        $data['category'] = @$data['category'] ?: [];
        // required category
        if(!$data['category']) {
            return response()->json([
                'status' => 500,
                'message' => trans('gallery::language.required_categories'),
            ]);
        }

        if(!$data['thumbnail']) {
            return response()->json([
                'status' => 500,
                'message' => 'Bạn chưa chọn hình ảnh'
            ]);
        }

        $languages = $request->input('language');
        foreach ($languages as $locale => $dataLanguage) {
            $languages[$locale]['slug'] = isset($dataLanguage['slug']) ? $dataLanguage['slug'] : str_slug($dataLanguage['name']);
            if( $languageGallery = GalleryLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->whereHas('gallery', function($query) use ($request){
                 $query->where('type',$request->get('type'));
             })->first()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tên bài viết đã tồn tại . Yêu cầu nhập tên khác'
                ]);
            }
        }


        if ($gallery = Gallery::create($data)) {
            $gallery->saveLanguages($request->only('language'));
            $gallery->categories()->sync($data['category']);

            return response()->json([
                'status' => 200,
                'message' => trans('language.create_success'),
                'redirect_url' => admin_route('gallery.edit', $gallery->id)
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail'),
            ]);
        }
    }

    public function edit(Request $request, Gallery $gallery)
    {
        if($request->ajax()) {
            return $this->getForm($request->get('type'), $gallery);
        }

        $this->tpl->setData('title', trans('gallery::language.gallery_edit'));
        $this->tpl->setData('gallery', $gallery);
        $this->tpl->setTemplate('gallery::admin.edit');

        // breadcrumb
        $this->tpl->breadcrumb()->add(admin_route('gallery.index'), trans('gallery::language.manager'));
        $this->tpl->breadcrumb()->add(admin_route('gallery.edit', $gallery->id), trans('gallery::language.gallery_edit'));

        return $this->tpl->render();
    }

    public function update(Request $request, Gallery $gallery)
    {
        if(! $request->ajax()) {
            return;
        }

        $data = $request->except(['_token', 'language']);

        $data['featured'] = $request->has('featured') ? true : false;
        $data['published'] = $request->has('published') ? true : false;
        $data['published_at'] = Carbon::createFromFormat('d-m-Y H:i', $this->getDatetimeOrCreateFromNow($request));

        $data['category'] = @$data['category'] ?: [];
        // required category
        if(!$data['category']) {
            return response()->json([
                'status' => 500,
                'message' => trans('gallery::language.required_categories'),
            ]);
        }
        $languages = $request->input('language');
        foreach ($languages as $locale => $dataLanguage) {
             $languages[$locale]['slug'] = isset($dataLanguage['slug']) ? $dataLanguage['slug'] : str_slug($dataLanguage['name']);
             if( $languageGallery = GalleryLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->whereHas('gallery', function($query) use ($gallery){
                 $query->where('type',$gallery->type);
             })->first()){
                if($languageGallery->gallery_id != $gallery->id){
                    return response()->json([
                        'status' => 500,
                        'message' => 'Tên bài viết đã tồn tại . Yêu cầu nhập tên khác'
                    ]);
                }
             }
        }



        if ($gallery->update($data)) {
            $gallery->saveLanguages($request->only('language'));
            $gallery->categories()->sync($data['category']);

            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success'),
                'redirect_url' => admin_route('gallery.edit', $gallery->id)
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail'),
            ]);
        }
    }

    public function destroy(Request $request, Gallery $gallery)
    {
        if(! $request->ajax()) {
            return;
        }
        if ($gallery->delete()) {
            $gallery->saveLanguages($request->only('language'));

            return response()->json([
                'status' => 200,
                'message' => trans('language.delete_success')
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.delete_fail'),
            ]);
        }
    }

    protected function getForm($type, $gallery)
    {
        if($type == 'video') {
            return view('gallery::admin.video', compact('gallery'));
        }

        return view('gallery::admin.album', compact('gallery'));
    }

    protected function getDatetimeOrCreateFromNow(Request $request)
    {
        $date = $request->has('date_published') ? $request->input('date_published') : date('d-m-Y');
        $time = $request->has('time_published') ? $request->input('time_published') : '00:00';

        return $date . ' ' . $time;
    }
}
