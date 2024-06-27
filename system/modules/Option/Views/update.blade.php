@extends('admin')

@section('page_header')
    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')

    @component('components.block')
        @slot('title', trans('option::language.check_for_update'))
        {!! Form::open([
            'url' => admin_url('option/update'),
            'method' => 'POST',
            'class' => 'form-validate form-horizontal',
            'id' => 'save',
            'enctype' => 'multipart/form-data',
            'data-callback' => 'reload_page'
        ]) !!}
        {{ csrf_field() }}

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="row">
                    <div class="col-lg-12" style="margin-bottom: 20px">
                        <input type="text" name="secret_key" class="form-control" placeholder="{{ trans('option::language.enter_key_to_update')  }}">
                    </div>
                    <div class="col-lg-6">
                        <a href="javascript:void(0)" class="widget widget-hover-effect2">
                            <div class="widget-extra themed-background{{ version_compare(config('cnv.current_version'), config('cnv.latest_version'), '<') ? '-danger' : '' }}">
                                <h4 class="widget-content-light text-center">{{ trans('option::language.current_version') }}</h4>
                            </div>
                            <div class="widget-extra-full">
                                <span class="h2 themed-color-dark animation-expandOpen">
                                    <strong style="display: block; text-align: center">{{ config('cnv.current_version') }}</strong>
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <a href="javascript:void(0)" class="widget widget-hover-effect2">
                            <div class="widget-extra themed-background">
                                <h4 class="widget-content-light">{{ trans('option::language.latest_version') }}</h4>
                            </div>
                            <div class="widget-extra-full">
                                <span class="h2 themed-color-dark animation-expandOpen">
                                    <strong style="display: block; text-align: center">{{ config('cnv.latest_version') }}</strong>
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-12 text-center">
                        @if(floatval(config('cnv.current_version')) == floatval(config('cnv.latest_version')))
                        <h4 class="text-success">
                            <i class="fa fa-info-circle"></i>
                            {{ trans('option::language.you_has_been_use_latest_version') }}
                        </h4>
                        @else
                        <h4 class="text-danger">
                            <i class="fa fa-info-circle"></i>
                            {{ trans('option::language.you_has_been_use_old_version') }}
                        </h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}

        <div class="row">
            <div class="col-lg-4">
                <div class="widget">
                    <div class="widget-extra themed-background-dark">
                        <h3 class="widget-content-light">
                            <strong>{{ trans('option::language.list_versions') }}</strong>
                        </h3>
                    </div>
                    <div class="widget-extra">
                        <div class="timeline">
                            <ul class="timeline-list">
                                @foreach($logs as $log)
                                <li class="active">
                                    <div class="timeline-icon"><i class="fa fa-check"></i></div>
                                    <div class="timeline-time"><small>{{ $log['created_at'] }}</small></div>
                                    <div class="timeline-content">
                                        <p class="push-bit">
                                            <a href="{{ admin_url('option/update') }}?version={{ $log['version'] }}"><strong>{{ trans('option::language.version') }} {{ $log['version'] }}</strong></a>
                                        </p>
                                        <p class="push-bit">{{ $log['description'] }}</p>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                @if(isset($first) && !empty($first))
                <div class="block">
                    <!-- Tracker Title -->
                    <div class="block-title">
                        <h4>{{ trans('option::language.version') }} {{ $first['version'] }}</h4>
                    </div>
                    <!-- END Tracker Title -->

                    <!-- Tracker Content -->
                    <div class="block-content-full">
                        <!-- Issues -->
                        <table class="table table-borderless table-striped table-vcenter">
                            <thead>
                            <tr>
                                <td colspan="2">
                                    <ul class="list-inline remove-margin">
                                        <li>
                                            <i class="fa fa-check"></i>
                                            <a href="javascript:void(0)" class="text-success"><strong>Các tính năng đã cập nhật</strong></a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($first['content'] as $content)
                                <tr>
                                    <td class="text-center" style="width: 60px;">
                                        <a href="javascript:void(0)" class="text-{{ get_update_class($content) }}">
                                            <i class="fa fa-{{ get_update_icon($content) }} fa-2x"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="label label-{{ get_update_class($content) }}">{{ get_update_text($content) }}</span>
                                        <strong>{{ $content['text'] }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- END Issues -->
                    </div>
                    <!-- END Tracker Content -->
                </div>
                @endif
            </div>
        </div>
    @endcomponent
@stop