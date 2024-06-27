<?php

namespace Modules\Gallery\Http\Controllers\Web;

use App\Core\Template\TemplateInterface;
use App\Http\Controllers\WebController;
use Illuminate\Http\Request;
use Modules\Gallery\Repositories\GalleryCategoryRepository;
use Modules\Gallery\Repositories\GalleryRepository;
use Illuminate\Support\Facades\Auth;

class CategoryController extends WebController
{
    protected $categoryRepository;

    public function __construct(TemplateInterface $template, GalleryCategoryRepository $galleryCategoryRepository)
    {
        parent::__construct($template);
        $this->categoryRepository = $galleryCategoryRepository;
    }

    public function show(GalleryRepository $galleryRepository, $slug)
    {
        $category = $this->categoryRepository->getViaSlug($slug, true);

        if (!$category) {
            abort(404);
        }
        $this->tpl->setTemplateFrontend('category', 'gallery');

        if (config('cnv.seo_plugin')) {
            $this->tpl->setData('title', $category->category->seo->language('title'));
            $this->tpl->setData('description', $category->category->seo->language('description'));
        } else {
            $this->tpl->setData('title', $category->title);
        }
        $gallery = $galleryRepository->getGalleryViaCategoires($category->category, 10, true);

        // breadcrumb
        $this->tpl->breadcrumb()->add('/gallery/collections/' . $slug, $category->name);

        $this->tpl->setData('gallery', $gallery);
        $this->tpl->setData('category', $category);
        if(Auth::guard('customer')->check()){
            return $this->tpl->render();
        }else{
            return redirect('register');
        }
    }

    public function shortlink(Request $request)
    {
        $category = $this->categoryRepository->getViaId($request->get('id'));
        return redirect()->route('gallery.category.show', $category->language('slug'));
    }
}
