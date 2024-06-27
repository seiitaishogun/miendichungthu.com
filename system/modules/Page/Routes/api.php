<?php

Route::group([
    'middleware' => ['api'],
    'namespace' => 'Modules\\Page\\Http\\Controllers\\API',
    'prefix' => 'api'
], function () {
    Route::name('api.page.search')->get('search/page', function (\Illuminate\Http\Request $request, \Modules\Page\Repositories\PageRepository $pageRepository) {
        $keyword = $request->get('q');
        $pages = $pageRepository->search($keyword, true);

        return response()->json([
            'status' => 200,
            'result' => $pages->map(function ($page) {
                $result = [];
                $result['name'] = $page->name;

                foreach ($page->page->languages as $language) {
                    $result['attributes'][] = [
                        'attr' => 'language['.$language->locale.'][name]',
                        'value' => $language->name
                    ];
                }
                $result['attributes'][] = [
                    'attr' => 'attributes[url]',
                    'value' => route('page.shortlink', ['id' => $page->page->id], false),
                ];

                return $result;
            })
        ]);
    });
});