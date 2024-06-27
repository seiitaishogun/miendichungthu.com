@extends('admin')

@section('page_header')
    @include('components.header', ['url' => admin_route('post.index')])
@stop

@section('content')
    {!! Form::open([
        'url' => admin_route('post.store'),
        'method' => 'POST',
        'class' => 'form-validate',
        'id' => 'save',
        'data-callback' => 'redirect_to'
    ]) !!}
    <input type="hidden" name="create_after_save" value="0">
    @include('blog::admin.post.form')
    {!! Form::close() !!}
@stop
