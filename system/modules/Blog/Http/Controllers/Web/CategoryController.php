<?php

namespace Modules\Blog\Http\Controllers\Web;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Modules\Blog\Repositories\PostCategoryRepository;
use Modules\Blog\Repositories\PostRepository;
use Illuminate\Support\Facades\Auth;


class CategoryController extends WebController
{
    protected $categoryRepository;

    public function __construct(TemplateInterface $template, PostCategoryRepository $postCategoryRepository)
    {
        parent::__construct($template);
        $this->categoryRepository = $postCategoryRepository;
    }

    public function show(PostRepository $postRepository, $slug)
    {
        $category = $this->categoryRepository->getViaSlug($slug, true);

        if (!$category) {
            abort(404);
        }
        $this->tpl->setTemplateFrontend('category.index', 'blog');

        if (config('cnv.seo_plugin')) {
            $this->tpl->setData('title', $category->category->seo->language('title'));
            $this->tpl->setData('description', $category->category->seo->language('description'));
        } else {
            $this->tpl->setData('title', $category->title);
        }
        $posts = $postRepository->getPostViaCategoires($category->category, 12, true);
        $this->tpl->setData('posts', $posts);
        $this->tpl->setData('category', $category);

        $this->tpl->breadcrumb()->add($category->link, $category->name);
        if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }

    }

    public function shortlink(Request $request)
    {
        $category = $this->categoryRepository->getViaId($request->get('id'));
        return redirect()->route('post.category.show', $category->language('slug'));
    }
}
