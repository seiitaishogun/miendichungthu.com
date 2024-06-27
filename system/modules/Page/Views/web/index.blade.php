@extends('theme::layout')

@section('content')

    <h1>{{ $page->name }}</h1>
    <div class="content">
        {!! $page->content !!}
    </div>
@endsection