@extends('theme::layout')

@section('content')

    <h1>{{ $post->name }}</h1>
    <div class="meta">
        <span class="author">
            {!! trans('blog::web.published_by', ['author' => $post->post->author->username]) !!}
        </span>
        <span class="updated_at">
            {!! trans('blog::web.published_at', ['datetime' => $post->post->published_at])  !!}
        </span>
        <span class="categories">
            {!! trans('blog::web.in_categories', ['categories' => implode(', ', $post->post->list_categories)]) !!}
        </span>
    </div>
    <div class="content">
        {!! $post->content !!}
    </div>
@endsection