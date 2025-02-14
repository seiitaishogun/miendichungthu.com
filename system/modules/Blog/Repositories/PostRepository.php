<?php

namespace Modules\Blog\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Blog\Models\PostCategory;
use Modules\Blog\Models\PostLanguage;
use Modules\Page\Models\PageLanguage;
use Modules\Blog\Models\Post;
use Plugins\ViewCounter\Models\View;

class PostRepository
{
    protected $posts;
    protected $postLanguage;
    protected $pageLanguage;

    public function __construct(Post $page, PostLanguage $postLanguage, PageLanguage $pageLanguage)
    {
        $this->posts = $page;
        $this->postLanguage = $postLanguage;
        $this->pageLanguage = $pageLanguage;
    }

    public function query()
    {
        return $this->posts->query();
    }

    public function getViaSlug($slug, $onlyPublished = false)
    {
        $post = $this->postLanguage->where([
            ['slug', '=', $slug]
        ])->with(['post.seo', 'post.categories']);

        if($onlyPublished) {
            $post = $post->whereHas('post', function($query) {
                $query->where('published', true)->whereDate('published_at', '<=', Carbon::now());
            });
        }

        $post = $post->firstOrFail();

        if (request()->has('lang') && $post->locale !== request('lang')) {
            $postOther = $this->getViaId($post->post->id, request('lang'), false);
            if ($postOther) {
                session(['lang' => $postOther->language('locale')]);
                abort(302, 'Redirecting', ['location' => route('post.show', [
                        'category' => $postOther->categories->first()->language('slug'),
                        'post' => $postOther->language('slug')
                    ])
                ]);
            }
        }
        session(['lang' => $post->locale]);

        return $post;
    }

    public function getViaId($id, $locale = null, $falseIfNotFound = true)
    {
        $locale = $locale ? $locale : session('lang');
        $post = $this->posts
            ->where('id', $id)
            ->whereHas('languages', function ($q) use ($locale) {
                $q->where('locale', $locale);
            });

        return $falseIfNotFound ? $post->firstOrFail() : $post->first();
    }

    public function search($keyword, $onlyPublished = false, $limit = 10, $paginate = 0, $locale = null)
    {
        $locale = $locale ? $locale : session('lang');
        $keyword = '%' . $keyword . '%';
        $pages = $this->pageLanguage
            ->where(function($query) use ($keyword) {
                $query->orWhere('slug', 'like', $keyword);
                $query->orWhere('name', 'like', $keyword);
                $query->orWhere('content', 'like', $keyword);
            })
            ->with('page.languages');

        if($onlyPublished) {
            $pages = $pages->whereHas('page', function($query) {
                $query->where('published', true)->whereDate('published_at', '<=', Carbon::now());
            });
        }
        return $limit > 0  ? $pages->limit($limit)->get() :
            ($paginate > 0 ? $pages->paginate($paginate) : $pages->get());
    }
    
    public function search_post($keyword, $onlyPublished = false, $limit = 10, $paginate = 0, $locale = null)
    {
        $locale = $locale ? $locale : session('lang');
        $keyword = '%' . $keyword . '%';
        $posts = $this->postLanguage
            ->where(function($query) use ($keyword) {
                $query->orWhere('slug', 'like', $keyword);
                $query->orWhere('name', 'like', $keyword);
                $query->orWhere('content', 'like', $keyword);
                $query->orWhere('tags', 'like', $keyword);
            })
            ->with('post');

        if ($locale !== '*') {
            $posts->where('locale', $locale);
        }

        if($onlyPublished) {
            $posts->whereHas('post', function($query) {
                $query->where('published', true)->whereDate('published_at', '<=', Carbon::now());
            });
        }
        return $limit > 0  ? $posts->limit($limit)->get() :
            ($paginate > 0 ? $posts->paginate($paginate) : $posts->get());
    }

    public function getPostViaCategoires(PostCategory $category, $perPage = 10, $onlyPublished = false, $locale = null)
    {
        $query = $category->posts();
        $query->with('view');
        $locale = $locale ? $locale : session('lang');

        if($onlyPublished) {
            $query = $query
            ->where('published', true)
            ->whereHas('languages', function($query) use ($locale) {
                $query->where('locale', $locale);
            })
            ->whereDate('published_at', '<=', Carbon::now());
        }
        $query = $query->orderBy('featured', 'desc');
        $query = $query->latest('position');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    public function getPosts(
        $limit = 10,
        $category_id = 0,
        $onlyShowPublished = true,
        $orderBy = 'latest',
        $locale = null
    )
    {
        $locale = $locale ? $locale : session('lang');
        $query = $this->posts->query();

        if($onlyShowPublished) {
            $query = $query->where('published', true)
                ->whereDate('published_at', '<=', Carbon::now());
        }

        if ($category_id) {
            $query = $query->whereHas('categories', function ($q) use($category_id) {
                if(is_array($category_id)) {
                    $q->whereIn('id', $category_id);
                } else {
                    $q->where('id', $category_id);
                }
            });
        }

        $query = $query->whereHas('languages', function ($q) use ($locale) {
            return $q->where('locale', $locale);
        });

        switch ($orderBy) {
            case 'latest':
                $query = $query->latest();
                break;
            case 'oldest':
                $query = $query->oldest();
                break;
            case 'popular':
                $query = $query->join('views', function($join) {
                    $join->on('posts.id', '=', 'views.subject_id')
                         ->where('subject_type', get_class($this->posts));
                })
                ->select('posts.*', 'views.count AS views')
                ->orderBy('views', 'desc');
                break;
            case 'featured':
                $query = $query->orderBy('featured', 'desc')->latest();
                break;
        }

        return $query->limit($limit)->get();
    }
}
