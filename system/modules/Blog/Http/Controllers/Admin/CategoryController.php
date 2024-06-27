<?php

namespace Modules\Blog\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Blog\Models\PostCategory;
use Modules\Blog\Models\PostCategoryLanguage;
use Modules\Page\Http\Requests\PageRequest;
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

        $this->tpl->setData('title', trans('blog::language.manager_category'));
        $this->tpl->setTemplate('blog::admin.category.index');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.post.category.index', trans('blog::language.manager_category'));

        // datatable
        $this->tpl->datatable()->setSource(admin_route('post.category.index') . '?language=' . $request->get('language'));
        $this->tpl->datatable()->addColumn(
            '#',
            'position',
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
        $model = (new PostCategory())->getNestedMenusWithFormat($language);

        return DataTables::collection($model)
            ->editColumn('name', function($model)  use ($language) {
                return link_to_route('admin.post.category.edit', $model->name, ['post_category' => $model->id]);
            })
            ->addColumn('action', function($model) use ($language) {
                app('helper')->load('buttons');
                $button = [];

                $button[] = [
                    'route' => route('post.category.show', $model->language('slug', $language)),
                    'name' => trans('language.show'),
                    'icon' => 'fa fa-eye',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-warning',
                        'target' => '_blank'
                    ],
                 ];

                // edit role
                if(allow('blog.category.edit')) {
                    $button[] = [
                        'route' => admin_route('post.category.edit', $model->id),
                        'name' => trans('language.edit'),
                        'icon' => 'fa fa-pencil-square-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-primary'
                        ]
                    ];
                }

                // delete
                if(allow('blog.category.destroy')) {
                    $button[] = [
                        'route' => 'javascript:void(0);',
                        'name' => trans('language.delete'),
                        'icon' => 'fa fa-trash-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-danger',
                            'data-url' => admin_route('post.category.destroy', $model->id),
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
            ->editColumn('position', function ($model) {
                return sprintf('<input type="number" data-id="%d" data-toggle="change-position" value="%d" style="width: 80px;">', $model->id, $model->position);
            })
            ->rawColumns(['name', 'action', 'published', 'position'])
            ->make(true);
    }

    public function create(PostCategory $category)
    {
        $this->tpl->setData('title', trans('blog::language.category_create'));
        $this->tpl->setData('category', $category);
        $this->tpl->setTemplate('blog::admin.category.create');

        $category->published = true;

        // breadcrumb
        $this->tpl->breadcrumb()->add(admin_route('post.category.index'), trans('blog::language.manager_category'));
        $this->tpl->breadcrumb()->add(admin_route('post.category.create'), trans('blog::language.category_create'));

        return $this->tpl->render();
    }

    public function store(Request $request)
    {
        $data = $request->except(['_token', 'language']);


        $languages = $request->input('language');
        foreach ($languages as $locale => $dataLanguage) {
            $languages[$locale]['slug'] = isset($dataLanguage['slug']) ? $dataLanguage['slug'] : str_slug($dataLanguage['name']);
            if ($languageCatePost = PostCategoryLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->first()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tên chuyên mục đã tồn tại . Yêu cầu nhập tên khác'
                ]);
            }
        }

        /** @var PostCategory $category */
        if ($category = PostCategory::create($data)) {
            $category->saveLanguages($request->only('language'));

            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success'),
                'redirect_url' =>  $request->input('create_after_save') ?
                    admin_route('post.category.create') : admin_route('post.category.edit', $category->id)
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail'),
            ]);
        }
    }

    public function edit(PostCategory $postCategory)
    {
        $this->tpl->setData('title', trans('blog::language.category_edit'));
        $this->tpl->setData('category', $postCategory);
        $this->tpl->setTemplate('blog::admin.category.edit');

        // breadcrumb
        $this->tpl->breadcrumb()->add(admin_route('post.category.index'), trans('blog::language.manager_category'));
        $this->tpl->breadcrumb()->add(admin_route('post.category.edit', $postCategory->id), trans('blog::language.category_edit'));

        return $this->tpl->render();
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        if(! $request->ajax()) {
            return;
        }

        $data = $request->except(['_token', 'language']);
        $data['published'] = $request->has('published') ? true : false;

        $languages = $request->input('language');
        foreach ($languages as $locale => $dataLanguage) {
            $languages[$locale]['slug'] = isset($dataLanguage['slug']) ? $dataLanguage['slug'] : str_slug($dataLanguage['name']);
            if ($languageCatePost = PostCategoryLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->first()) {
                if($languageCatePost->post_category_id != $postCategory->id){
                    return response()->json([
                        'status' => 500,
                        'message' => 'Tên chuyên mục đã tồn tại . Yêu cầu nhập tên khác'
                    ]);
                }
            }
        }


        $postCategory->update($data);
        $postCategory->saveLanguages($request->only('language'));

        return response()->json([
            'status' => 200,
            'message' => trans('language.update_success'),
        ]);
    }

    /**
     * Delele source
     * @param Request $request
     * @param PostCategory $postCategory
     * @return mixed
     */
    public function destroy(Request $request, PostCategory $postCategory)
    {
        if(! $request->ajax()) {
            return;
        }

        if(in_array($postCategory->id, PostCategory::getProtects())) {
            return response()->json([
                'status' => 500,
                'message' => 'Danh mục này đã được bảo vệ'
            ]);
        }


        $check_post_in_main_cate =  DB::table('posts')->where('main_category',$postCategory->id)->count();
        $check_post_in_related_cate =  DB::table('post_category')->where('post_category_id',$postCategory->id)->count();

        if($check_post_in_main_cate > 0 || $check_post_in_related_cate > 0){
            return response()->json([
                'status' => 500,
                'message' => 'Danh mục này có bài viết , xóa bài viết trước khi xóa chuyên mục',
                'redirect' => url()->previous(),
                'check_item' => 'check_item'
            ]);
        }

        $check_post_cate_has_child =  DB::table('post_categories')->where('parent_id',$postCategory->id)->count();

         if( $check_post_cate_has_child > 0 ){
            return response()->json([
                'status' => 500,
                'message' => 'Danh mục này có danh mục con , xóa danh mục con trước khi xóa danh mục cha',
                'redirect' => url()->previous(),
                'check_item' => 'check_item'
            ]);
        }

        if($postCategory->delete()) {
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


    public function position(Request $request, PostCategory $postCategory)
    {
        if (! $request->ajax()) {
            return;
        }
        $position = intval($request->input('position'));
        $postCategory->position = $position < 1 ? 1 : $position;
        if ($postCategory->save()) {
            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success')
            ]);
        }

        return response()->json([
            'status' => 500,
            'message' => trans('language.update_fail')
        ]);
    }
}
