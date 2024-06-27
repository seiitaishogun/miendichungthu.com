<?php

namespace Modules\Gallery\Repositories;

use Carbon\Carbon;
use Modules\Gallery\Models\GalleryCategory;
use Modules\Gallery\Models\GalleryCategoryLanguage;

class GalleryCategoryRepository
{
    protected $category;
    protected $categoryLanguage;

    public function __construct(GalleryCategory $category, GalleryCategoryLanguage $galleryCategoryLanguage)
    {
        $this->category = $category;
        $this->categoryLanguage = $galleryCategoryLanguage;
    }

    public function query()
    {
        return $this->category->query();
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
                    'location' => route('gallery.category.show',  $categoryOther->language('slug'))
                ]);
            }
        }

        session(['lang' => $category->locale]);

        return $category;
    }

    public function getViaId($id)
    {
        return $this->category->where('id', $id)->firstOrFail();
    }

    public function search($keyword, $limit = 10)
    {
        $keyword = '%' . $keyword . '%';
        $categories = $this->categoryLanguage
            ->orWhere([
                ['slug', 'like', $keyword],
                ['name', 'like', $keyword],
            ])->with('category.languages');

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

        return $query->get();
    }
}
