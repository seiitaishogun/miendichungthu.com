@extends('admin')

@section('page_header')

    @can('gallery.gallery.create')
        <div class="pull-right">
            <a href="{{ admin_route('gallery.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> {{ trans('language.create') }}
            </a>
        </div>
    @endcan

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')
    @include('partial.datatable_mutillang', ['url' => admin_route('gallery.index')])

    @component('components.block')

        @slot('title', trans('gallery::language.gallery_list'))

            @include('partial.datatable')
            @endcomponent

@stop
