<?php

namespace Modules\Page\Http\Controllers\Web;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Modules\Page\Models\Page;
use Modules\Page\Repositories\PageRepository;
use Illuminate\Support\Facades\Auth;

class PageController extends WebController
{
    protected $pageRepository;

    public function __construct(TemplateInterface $template, PageRepository $pageRepository)
    {
        parent::__construct($template);
        $this->pageRepository = $pageRepository;
    }

    public function show($slug)
    {
        $page = $this->pageRepository->getPageViaSlug($slug, true);

        if (!$page) {
            abort(404);
        }
        $page->page->counting();

        $this->tpl->setTemplateFrontend('index', 'page');

        if (config('cnv.seo_plugin')) {
            $this->tpl->setData('title', $page->page->seo->language('title'));
            $this->tpl->setData('description', $page->page->seo->language('description'));
        } else {
            $this->tpl->setData('title', $page->name);
        }

        $this->tpl->breadcrumb()->add('/pages/' . $slug, $page->name);

        $this->tpl->setData('page', $page);
        // if(Auth::guard('customer')->check() || $page->page->id == 1 || $page->page->id == 2 ){
        if ( (isset($_COOKIE['user']) && !empty($_COOKIE['user']) || $page->page->id == 1 || $page->page->id == 2) ) {
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }

    public function shortlink(Request $request)
    {
        $page = $this->pageRepository->getPageViaId($request->get('id'));
        return redirect()->route('page.show', $page->language('slug'));
    }
}
