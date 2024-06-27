<?php

Route::group([
    'middleware' => ['api'],
    'namespace' => 'Modules\\Page\\Http\\Controllers\\API',
    'prefix' => 'api'
], function () {
    // api blog
    Route::get('/search/blog', function (\Illuminate\Http\Request $request, \Modules\Blog\Repositories\PostRepository $postRepository) {
        $keyword = $request->get('q');
        $posts = $postRepository->search($keyword, true, 100, 0, '*');

        return response()->json([
            'status' => 200,
            'result' => $posts->map(function ($post) {
                $result = [];
                $result['name'] = $post->name;

                foreach ($post->post->languages as $language) {
                    $result['attributes'][] = [
                        'attr' => 'language['.$language->locale.'][name]',
                        'value' => $language->name
                    ];
                }
                $result['attributes'][] = [
                    'attr' => 'attributes[url]',
                    'value' => route('post.shortlink', ['id' => $post->post->id], false),
                ];

                return $result;
            })
        ]);
    });

    // api post
    Route::get('/search/blog/category', function (\Illuminate\Http\Request $request, \Modules\Blog\Repositories\PostCategoryRepository $postCategoryRepository) {
        $keyword = $request->get('q');
        $categories = $postCategoryRepository->search($keyword);

        return response()->json([
            'status' => 200,
            'result' => $categories->map(function ($category) {
                $result = [];
                $result['name'] = $category->name;

                foreach ($category->category->languages as $language) {
                    $result['attributes'][] = [
                        'attr' => 'language['.$language->locale.'][name]',
                        'value' => $language->name
                    ];
                }
                $result['attributes'][] = [
                    'attr' => 'attributes[url]',
                    'value' => route('post.category.shortlink', ['id' => $category->category->id], false),
                ];

                return $result;
            })
        ]);
    });
});