<?php

namespace Modules\Blog\Repositories;

use Carbon\Carbon;
use Modules\Blog\Models\PostCategory;
use Modules\Blog\Models\PostCategoryLanguage;

class PostCategoryRepository
{
    protected $category;
    protected $categoryLanguage;

    public function __construct(PostCategory $category, PostCategoryLanguage $postCategoryLanguage)
    {
        $this->category = $category;
        $this->categoryLanguage = $postCategoryLanguage;
    }

    public function query()
    {
        return $this->category->query();
    }

    public function all()
    {
        return $this->category->all();
    }

    public function getViaSlug($slug, $onlyPublished = false)
    {
        $category = $this->categoryLanguage->where([
            ['slug', '=', $slug]
        ])->with('category.seo');

        if($onlyPublished) {
            $category = $category->whereHas('category', function($query) {
                $query->where('published', true);
            });
        }
        $category = $category->firstOrFail();

        if (request()->has('lang') && $category->locale !== request('lang')) {
            $categoryOther = $this->getViaId($category->category->id, request('lang'), false);
            if ($categoryOther) {
                session(['lang' => $categoryOther->language('locale')]);
                abort(302, 'Redirecting', [
                    'location' => route('post.category.show',  $categoryOther->language('slug'))
                ]);
            }
        }
        session(['lang' => $category->locale]);

        return $category;
    }

    public function getViaId($id, $locale = null, $falseIfNotFound = true)
    {
        $locale = $locale ? $locale : session('lang');

        $query = $this->category->query();
        $query->where('id', $id);
        $query->whereHas('languages', function($q) use ($locale) {
            $q->where('locale', $locale);
        });

        return $falseIfNotFound ? $query->firstOrFail() : $query->first();
    }

    public function search($keyword, $limit = 10)
    {
        $keyword = '%' . $keyword . '%';
        $categories = $this->categoryLanguage
            ->where(function ($query) use ($keyword) {
                $query->orWhere('slug', 'like', $keyword);
                $query->orWhere('name', 'like', $keyword);
            })->with('category.languages');

        return $categories->limit($limit)->get();
    }

    public function getCategories($parent_id = 0, $onlyShowPublished = true, $locale = null)
    {
        $query = $this->category->withCount('children')->where('parent_id', $parent_id);
        $locale = $locale ? $locale : session('lang');

        if($onlyShowPublished) {
            $query = $query->where('published',  true);
        }

        $query = $query->whereHas('languages', function ($q) use ($locale) {
            $q->where('locale', $locale);
        });

        $query->orderBy('position', 'desc');

        return $query->get();
    }
}