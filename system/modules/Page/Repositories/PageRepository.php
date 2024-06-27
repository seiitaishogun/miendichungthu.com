<?php

namespace Modules\Page\Repositories;

use Carbon\Carbon;
use Modules\Page\Models\Page;
use Modules\Page\Models\PageLanguage;

class PageRepository
{
    protected $pages;
    protected $pageLanguage;

    public function __construct(Page $page, PageLanguage $pageLanguage)
    {
        $this->pages = $page;
        $this->pageLanguage = $pageLanguage;
    }

    public function query()
    {
        return $this->pages->query();
    }

    public function getPageViaSlug($slug, $onlyPublished = false)
    {
        $page = $this->pageLanguage->where([
            ['slug', '=', $slug]
        ])->with('page.seo');

        if($onlyPublished) {
            $page = $page->whereHas('page', function($query) {
                $query->where('published', true)->whereDate('published_at', '<=', Carbon::now());
            });
        }

        $page = $page->firstOrFail();
        if (request()->has('lang') && $page->locale !== request('lang')) {
            $pageOther = $this->getPageViaId($page->page->id, request('lang'), false);
            if ($pageOther) {
                session(['lang' => $pageOther->language('locale')]);
                abort(302, 'Redirecting', ['location' => route('page.show', $pageOther->language('slug'))]);
            }
        }
        session(['lang' => $page->locale]);

        return $page;
    }

    public function getPageViaId($id, $locale = null, $falseIfNotFound = true)
    {
        $locale = $locale ? $locale : session('lang');
        $page = $this->pages
            ->where('id', $id)
            ->whereHas('languages', function ($q) use ($locale) {
                $q->where('locale', $locale);
            });

        return $falseIfNotFound ? $page->firstOrFail() : $page->first();
    }

    public function search($keyword, $onlyPublished = false, $limit = 10)
    {
        $keyword = '%' . $keyword . '%';
        $pages = $this->pageLanguage
            ->orWhere([
                // ['slug', 'like', $keyword],
                ['name', 'like', $keyword],
            ])->with('page.languages');

        if($onlyPublished) {
            $pages = $pages->whereHas('page', function($query) {
                $query->where('published', true)->whereDate('published_at', '<=', Carbon::now());
            });
        }

        return $pages->limit($limit)->get();
    }
}
