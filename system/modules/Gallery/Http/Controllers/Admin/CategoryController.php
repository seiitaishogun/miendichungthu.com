<?php

namespace Modules\Gallery\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Gallery\Models\GalleryCategory;
use Modules\Gallery\Models\GalleryCategoryLanguage;
use Yajra\DataTables\Facades\DataTables;
use DB;
class CategoryController extends AdminController
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->data($request);
        }

        $this->tpl->setData('title', trans('gallery::language.manager_category'));
        $this->tpl->setTemplate('gallery::admin.category.index');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.gallery.category.index', trans('gallery::language.manager_category'));

        // datatable
        $this->tpl->datatable()->setSource(admin_route('gallery.category.index') . '?language=' . $request->get('language'));
        $this->tpl->datatable()->addColumn(
            '#',
            'id',
            ['class' => 'col-md-1'],
            false,
            false
        );
        $this->tpl->datatable()->addColumn(
            trans('language.name'),
            'name',
            ['class' => 'col-md-6'],
            false,
            false
        );
        $this->tpl->datatable()->addColumn(
            trans('language.published'),
            'published',
            ['class' => 'col-md-2'],
            false,
            false
        );
        $this->tpl->datatable()->addColumn(
            trans('language.updated_at'),
            'updated_at',
            [],
            false,
            false
        );

        return $this->tpl->render();
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function data(Request $request)
    {
        $language = $request->has('language') ? $request->get('language') : config('cnv.language_default');
        $model = (new GalleryCategory());

        return DataTables::eloquent($model->query())
            ->editColumn('name', function($model)  use ($language) {
                return link_to_route('admin.gallery.category.edit', $model->language('name'), ['gallery_category' => $model->id]);
            })
            ->addColumn('action', function($model) use ($language) {
                app('helper')->load('buttons');
                $button = [];

                $button[] = [
                    'route' => route('gallery.category.show', $model->language('slug', $language)),
                    'name' => trans('language.show'),
                    'icon' => 'fa fa-eye',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-warning',
                        'target' => '_blank'
                    ],
                 ];

                // edit role
                if(allow('gallery.category.edit')) {
                    $button[] = [
                        'route' => admin_route('gallery.category.edit', $model->id),
                        'name' => trans('language.edit'),
                        'icon' => 'fa fa-pencil-square-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-primary'
                        ]
                    ];
                }

                // delete
                if(allow('gallery.category.destroy')) {
                    $button[] = [
                        'route' => 'javascript:void(0);',
                        'name' => trans('language.delete'),
                        'icon' => 'fa fa-trash-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-danger',
                            'data-url' => admin_route('gallery.category.destroy', $model->id),
                            'data-action' => 'confirm_to_delete',
                            'data-message' => trans('language.confirm_to_delete')
                        ]
                    ];
                }

                return cnv_action_block($button);
            })
            ->editColumn('published', function ($model) {
                return sprintf(
                    '<span class="label label-%s">%s</span>',
                    $model->published ? 'success' : 'warning',
                    $model->published ? trans('language.published') : trans('language.trashed')
                );
            })
            ->rawColumns(['name', 'action', 'published'])
            ->make(true);
    }

    public function create(GalleryCategory $category)
    {
        $this->tpl->setData('title', trans('gallery::language.category_create'));
        $this->tpl->setData('category', $category);
        $this->tpl->setTemplate('gallery::admin.category.create');

        $category->published = true;

        // breadcrumb
        $this->tpl->breadcrumb()->add(admin_route('gallery.category.index'), trans('gallery::language.manager_category'));
        $this->tpl->breadcrumb()->add(admin_route('gallery.category.create'), trans('gallery::language.category_create'));

        return $this->tpl->render();
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'language']);


        $languages = $request->input('language');
        foreach ($languages as $locale => $dataLanguage) {
            $languages[$locale]['slug'] = isset($dataLanguage['slug']) ? $dataLanguage['slug'] : str_slug($dataLanguage['name']);
            if ($languageCateGallery = GalleryCategoryLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->first()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tên chuyên mục đã tồn tại . Yêu cầu nhập tên khác'
                ]);
            }
        }


        /** @var GalleryCategory $category */
        if ($category = GalleryCategory::create($data)) {
            $category->saveLanguages($request->only('language'));

            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success'),
                'redirect_url' => admin_route('gallery.category.edit', $category->id)
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail'),
            ]);
        }
    }

    public function edit(GalleryCategory $galleryCategory)
    {
        $this->tpl->setData('title', trans('gallery::language.category_edit'));
        $this->tpl->setData('category', $galleryCategory);
        $this->tpl->setTemplate('gallery::admin.category.edit');

        // breadcrumb
        $this->tpl->breadcrumb()->add(admin_route('gallery.category.index'), trans('gallery::language.manager_category'));
        $this->tpl->breadcrumb()->add(admin_route('gallery.category.edit', $galleryCategory->id), trans('gallery::language.category_edit'));

        return $this->tpl->render();
    }

    public function update(Request $request, GalleryCategory $galleryCategory)
    {
        if(! $request->ajax()) {
            return;
        }

        $data = $request->except(['_token', 'language']);
        $data['published'] = $request->has('published') ? true : false;

        $languages = $request->input('language');
        foreach ($languages as $locale => $dataLanguage) {
            $languages[$locale]['slug'] = isset($dataLanguage['slug']) ? $dataLanguage['slug'] : str_slug($dataLanguage['name']);
            if ($languageCateGallery = GalleryCategoryLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->first()) {
                if($languageCateGallery->gallery_category_id != $galleryCategory->id){
                    return response()->json([
                        'status' => 500,
                        'message' => 'Tên chuyên mục đã tồn tại . Yêu cầu nhập tên khác'
                    ]);
                }
            }
        }


        $galleryCategory->update($data);
        $galleryCategory->saveLanguages($request->only('language'));

        return response()->json([
            'status' => 200,
            'message' => trans('language.update_success'),
        ]);
    }

    /**
     * Delele source
     * @param Request $request
     * @param GalleryCategory $galleryCategory
     * @return mixed
     */
    public function destroy(Request $request, GalleryCategory $galleryCategory)
    {
        if(! $request->ajax()) {
            return;
        }

        $check_gallery_in_related_cate =  DB::table('gallery_category')->where('gallery_category_id',$galleryCategory->id)->count();

        if( $check_gallery_in_related_cate > 0){
            return response()->json([
                'status' => 500,
                'message' => 'Danh mục này có bài viết , xóa bài viết trước khi xóa chuyên mục',
                'redirect' => url()->previous(),
                'check_item' => 'check_item'
            ]);
        }

        $galleryCategory->gallery()->delete();

        if($galleryCategory->delete()) {
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
