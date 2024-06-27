@extends('theme::layout')

@section('content')

    <h1>{{ trans('blog::language.search_result') }}</h1>

    @foreach($posts as $post)
        <article>
            <h2>
                <a href="{{ $post->link }}">{{ $post->name }}</a>
            </h2>
            <div class="post-meta">
                <span class="author">
                    {!! trans('blog::web.published_by', ['author' => $post->post->author->username]) !!}
                </span> &bull;
                <span class="updated_at">
                    {!! trans('blog::web.published_at', ['datetime' => $post->post->published_at])  !!}
                </span> &bull;
                <span class="categories">
                    {!! trans('blog::web.in_categories', ['categories' => implode(', ', $post->post->list_categories)]) !!}
                </span> &bull;
                <span class="views">
                    {!! trans('blog::web.view_count', ['count' => $post->post->view->count]) !!}
                </span>
            </div>
            <div class="post-description">
                {{ $post->description }}
            </div>
        </article>
    @endforeach

    <div class="pagination">
        {!! $posts->links() !!}
    </div>
@endsection