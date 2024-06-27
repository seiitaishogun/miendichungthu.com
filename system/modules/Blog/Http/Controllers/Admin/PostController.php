<?php

namespace Modules\Blog\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\PostLanguage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\AdminController;
use DB;
class PostController extends AdminController
{
    public function index(Request $request)
    {
        if($request->ajax()) {
            return $this->data($request);
        }

        $this->tpl->setData('title', trans('blog::language.manager_post'));
        $this->tpl->setTemplate('blog::admin.post.index');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.post.index', trans('blog::language.manager_post'));

        // datatable
        $filter = encrypt($request->only(['language', 'category']));
        $this->tpl->datatable()->setSource(admin_route('post.index') . '?filter=' . $filter);
        $this->tpl->datatable()->addColumn('#',
            'post.position',
            ['class' => 'col-md-1']
        );
        $this->tpl->datatable()->addColumn(
            trans('language.name'),
            'name',
            ['class' => 'col-md-4']
        );
        $this->tpl->datatable()->addColumn(
            trans('blog::language.feature'),
            'post.featured',
            ['class' => 'col-md-2'],
            false,
            true
        );
        $this->tpl->datatable()->addColumn(
            trans('language.status'),
            'post.published',
            ['class' => 'col-md-2'],
            false,
            true
        );
        $this->tpl->datatable()->addColumn(
            trans('language.updated_at'),
            'post.updated_at'
        );

        return $this->tpl->render();
    }

    public function data(Request $request)
    {
        $filter = decrypt($request->get('filter'));
        $language = @$filter['language'] ?: config('cnv.language_default');

        $model = PostLanguage::with('post')->where('locale', $language);

        if(@$filter['category'] && @$filter['category'] !== '*') {
            $model->whereHas('post', function ($query) use ($filter) {
                $query->whereHas('categories', function ($query) use ($filter) {
                    $query->where('id', @$filter['category']);
                });
            });
        }

        return DataTables::eloquent($model)
            ->editColumn('post.position', function ($model) {
                return sprintf('<input type="number" data-id="%d" data-toggle="change-position" value="%d" style="width: 80px;">', $model->post->id, $model->post->position);
            })
            ->editColumn('name', function($model) {
                $html = '<h4>';
                $html .= link_to_route('admin.post.edit', $model->name, ['page' => $model->post->id]);
                $html .= '</h4>';
                $html .= '<p>' . $model->description . '</p>';

                return $html;
            })
            ->addColumn('action', function($model) {
                app('helper')->load('buttons');
                $button = [];

                $button[] = [
                    'route' => $model->link,
                    'name' => trans('language.show'),
                    'icon' => 'fa fa-eye',
                    'attributes' => [
                        'class' => 'btn btn-xs btn-warning',
                        'target' => '_blank'
                    ],
                 ];

                // edit role
                if(allow('blog.post.edit')) {
                    $button[] = [
                        'route' => admin_route('post.edit', $model->post->id),
                        'name' => trans('language.edit'),
                        'icon' => 'fa fa-pencil-square-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-primary'
                        ]
                    ];
                }

                // delete
                if(allow('blog.post.destroy')) {
                    $button[] = [
                        'route' => 'javascript:void(0);',
                        'name' => trans('language.delete'),
                        'icon' => 'fa fa-trash-o',
                        'attributes' => [
                            'class' => 'btn btn-xs btn-danger',
                            'data-url' => admin_route('post.destroy', $model->post->id),
                            'data-action' => 'confirm_to_delete',
                            'data-message' => trans('language.confirm_to_delete')
                        ]
                    ];
                }

                return cnv_action_block($button);
            })
            ->editColumn('post.published', function ($model) {
                return sprintf(
                    '<span class="label label-%s">%s</span>',
                    $model->post->published ? 'success' : 'warning',
                    $model->post->published ? trans('language.published') : trans('language.trashed')
                );
            })
            ->editColumn('post.featured', function ($model) {
                return sprintf(
                    '<span class="label label-%s">%s</span>',
                    $model->post->featured ? 'warning' : 'default',
                    $model->post->featured ? trans('blog::language.was_featured') : trans('blog::language.normal')
                );
            })
            ->rawColumns(['name', 'action', 'post.published', 'post.featured', 'post.position'])
            ->make(true);
    }

    public function create(Post $post)
    {
        $post->published_at = Carbon::now();
        $post->published = true;

        $this->tpl->setData('title', trans('blog::language.post_create'));
        $this->tpl->setData('post', $post);
        $this->tpl->setTemplate('blog::admin.post.create');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.post.index', trans('blog::language.manager_post'));
        $this->tpl->breadcrumb()->add(admin_route('post.create'), trans('blog::language.post_create'));

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
                'message' => trans('blog::language.required_categories'),
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
            if ($languagePost = PostLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->first()) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Tên bài viết đã tồn tại . Yêu cầu nhập tên khác'
                ]);
            }
        }

        if ($post = Post::create($data)) {
            $post->saveLanguages($request->only('language'));
            $post->categories()->sync($data['category']);

            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success'),
                'redirect_url' => $request->input('create_after_save') ?
                    admin_route('post.create') : admin_route('post.edit', $post->id)
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('language.update_fail'),
            ]);
        }
    }

    public function edit(Post $post)
    {
        $this->tpl->setData('title', trans('blog::language.post_edit'));
        $this->tpl->setData('post', $post);
        $this->tpl->setTemplate('blog::admin.post.edit');

        // breadcrumb
        $this->tpl->breadcrumb()->add('admin.post.index', trans('blog::language.manager_post'));
        $this->tpl->breadcrumb()->add(admin_route('post.edit', $post->id), trans('blog::language.post_edit'));

        return $this->tpl->render();
    }

    public function update(Request $request, Post $post)
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
                'message' => trans('blog::language.required_categories'),
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
            if ($languagePost = PostLanguage::query()->whereLocale($locale)->whereSlug(@$dataLanguage['slug'])->first()) {
                if($languagePost->post_id != $post->id){
                    return response()->json([
                        'status' => 500,
                        'message' => 'Tên bài viết đã tồn tại . Yêu cầu nhập tên khác'
                    ]);
                }
            }
        }

        if($post->update($data)) {
            $post->saveLanguages($request->only('language'));
            $post->categories()->sync($data['category']);

            return response()->json([
                'status' => 200,
                'message' => trans('language.update_success'),
            ]);
        }
        return response()->json([
            'status' => 500,
            'message' => trans('language.update_fail'),
        ]);
    }

    public function destroy(Request $request, Post $post)
    {
        if(! $request->ajax()) {
            return;
        }

        DB::table('post_category')->where('post_id', $post->id)->delete();

        if($post->delete()) {
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

    /**
     * Sort products
     *
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function position(Request $request, Post $post)
    {
        if (! $request->ajax()) {
            return;
        }
        $position = intval($request->input('position'));
        $post->position = $position < 1 ? 1 : $position;

        if ($post->save()) {
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

    protected function getDatetimeOrCreateFromNow(Request $request)
    {
        $date = $request->has('date_published') ? $request->input('date_published') : date('d-m-Y');
        $time = $request->has('time_published') ? $request->input('time_published') : '00:00';

        return $date . ' ' . $time;
    }
}
