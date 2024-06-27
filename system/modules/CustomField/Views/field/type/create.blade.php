@extends('admin')

@section('page_header')

    <div class="pull-right">
        <a href="{{ admin_route('custom-field.type.index', $field->id) }}" class="btn btn-default">
            <i class="fa fa-arrow-circle-left"></i> {{ trans('language.back') }}
        </a>
        <button type="button" class="btn btn-primary" onclick="submitForm('#save');">
            <i class="fa fa-save"></i> {{ trans('language.save') }}
        </button>
    </div>

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    {!! Form::open([
        'url' => admin_route('custom-field.type.store', $field->id),
        'method' => 'POST',
        'class' => 'form-validate',
        'id' => 'save',
        'data-callback' => 'redirect_to'
    ]) !!}
    @include('custom_field::field.type.form')
    {!! Form::close() !!}
@stop
