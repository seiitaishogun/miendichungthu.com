@extends('admin')

@section('page_header')
    @include('components.header', ['url' => admin_route('post.category.index')])
@stop

@section('content')
    {!! Form::open([
        'url' => admin_route('post.category.store'),
        'method' => 'POST',
        'class' => 'form-validate',
        'id' => 'save',
        'data-callback' => 'redirect_to'
    ]) !!}
    <input type="hidden" name="create_after_save" value="0">
    @include('blog::admin.category.form')
    {!! Form::close() !!}
@stop
