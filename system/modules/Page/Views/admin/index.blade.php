@extends('admin')

@section('page_header')

    @can('page.page.create')
        <div class="pull-right">
            <a href="{{ admin_route('page.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('language.create') }}
            </a>
        </div>
    @endcan

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    @include('partial.datatable_mutillang', ['url' => admin_route('page.index')])

    @component('components.block')

        @slot('title', trans('page::language.page_list'))

            @include('partial.datatable')
            @endcomponent

@stop
