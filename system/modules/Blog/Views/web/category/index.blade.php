@extends('theme::layout')

@section('content')

    <h1>{{ $category->name }}</h1>

    @foreach($posts as $post)
        <article>
            <h2>
                <a href="{{ $post->language('link') }}">{{ $post->language('name') }}</a>
            </h2>
            <div class="post-meta">
                <span class="author">
                    {!! trans('blog::web.published_by', ['author' => $post->author->username]) !!}
                </span> &bull;
                <span class="updated_at">
                    {!! trans('blog::web.published_at', ['datetime' => $post->published_at])  !!}
                </span> &bull;
                <span class="categories">
                    {!! trans('blog::web.in_categories', ['categories' => implode(', ', $post->list_categories)]) !!}
                </span> &bull;
                <span class="views">
                    {!! trans('blog::web.view_count', ['count' => $post->view->count]) !!}
                </span>
            </div>
            <div class="post-description">
                {{ $post->language('description') }}
            </div>
        </article>
    @endforeach

    <div class="pagination">
        {!! $posts->links() !!}
    </div>
@endsection