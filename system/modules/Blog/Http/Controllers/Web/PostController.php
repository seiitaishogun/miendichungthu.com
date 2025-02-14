<?php

namespace Modules\Blog\Http\Controllers\Web;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Modules\Blog\Repositories\PostRepository;
use Modules\Blog\Repositories\PostCategoryRepository;
use Illuminate\Support\Facades\Auth;

class PostController extends WebController
{
    protected $postRepository;

    public function __construct(TemplateInterface $template, PostRepository $postRepository, PostCategoryRepository $postCategoryRepository)
    {
        parent::__construct($template);
        $this->postRepository = $postRepository;
        $this->postCategoryRepository = $postCategoryRepository;
    }

    public function show($categorySlug, $slug)
    {

        $post = $this->postRepository->getViaSlug($slug, true);

        if (!$post) {
            abort(404);
        }

        // redirect if not exits category
        $category = $post->post->categories->first();
        if($category->language('slug') != $categorySlug) {
            return redirect()->route('post.show', [
                'category' => $category->language('slug'),
                'slug' => $slug
            ], 301);
        }

        $post->post->counting();

        $this->tpl->setTemplateFrontend('post.index', 'blog');

        if (config('cnv.seo_plugin')) {
            $this->tpl->setData('title', $post->post->seo->language('title'));
            $this->tpl->setData('description', $post->post->seo->language('description'));
        } else {
            $this->tpl->setData('title', $post->title);
        }

        $this->tpl->setData('post', $post);

        $category = $post->post->categories->first();
        // breadcrumb
        if($category) {
            $this->tpl->breadcrumb()->add($category->language('link'), $category->language('name'));
        }
        $this->tpl->breadcrumb()->add($post->link, $post->name);

        if ( isset($_COOKIE['user']) && !empty($_COOKIE['user'])) {
        // if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }

    public function shortlink(Request $request)
    {
        $post = $this->postRepository->getViaId($request->get('id'));
        return redirect()->route('post.show', [
            'category' => $post->categories->first()->language('slug'),
            'post' => $post->language('slug'),
         ]);
    }

    public function search(Request $request)
    {
        $this->tpl->setTemplateFrontend('post.search', 'blog');

        $this->tpl->setData('title', trans('blog::language.search_result'));
        $posts = $this->postRepository->search_post($request->get('q'), true, 0, 12);
        $pages = $this->postRepository->search($request->get('q'), true, 0, 12);
        $this->tpl->setData('pages', $pages);
        $this->tpl->setData('posts', $posts);
        $this->tpl->breadcrumb()->add('/blogs/search', trans('blog::language.search_result'));

        if ( isset($_COOKIE['user']) && !empty($_COOKIE['user'])) {
        // if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }

    public function search_bk(Request $request)
    {
        $this->tpl->setTemplateFrontend('post.search', 'blog');

        $this->tpl->setData('title', trans('blog::language.search_result'));
        $posts = $this->postRepository->search($request->get('q'), true, 0, 12);
        $this->tpl->setData('posts', $posts);
        $this->tpl->breadcrumb()->add('/blogs/search', trans('blog::language.search_result'));

        if ( isset($_COOKIE['user']) && !empty($_COOKIE['user'])) {
        // if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }

    public function agency(Request $request, $onlyShowPublished = true, $locale = null)
    {
        $this->tpl->setTemplateFrontend('post.agency', 'blog');
        $posts = $this->postCategoryRepository->getCategories($request->get('id'), $onlyShowPublished, $locale);
        $this->tpl->setData('posts', $posts);
        if ( isset($_COOKIE['user']) && !empty($_COOKIE['user'])) {
        // if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }
}
