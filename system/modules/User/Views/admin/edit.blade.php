@extends('admin')

@section('page_header')

    <div class="pull-right">
        <a href="{{ route('admin.user.index') }}" class="btn btn-default">
            <i class="fa fa-arrow-circle-left"></i> {{ trans('language.back') }}
        </a>
        <button type="button" class="btn btn-primary" onclick="submitForm('#user_edit');">
            <i class="fa fa-save"></i> {{ trans('language.save') }}
        </button>
    </div>

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    {!! Form::open([
        'url' => admin_route('user.update', $user->id),
        'method' => 'PUT',
        'class' => 'form-validate',
        'id' => 'user_edit',
        'enctype' => 'multipart/form-data',
        'data-callback' => 'nothing_to_do'
    ]) !!}
        @include('user::admin.form')
    {!! Form::close() !!}
@stop
