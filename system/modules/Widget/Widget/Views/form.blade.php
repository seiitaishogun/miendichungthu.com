<div class="row">
    <div class="col-lg-8">

        @if(!$widget->type)
            @component('components.block')
                @slot('title', trans('language.basic_info'))
                <div class="form-bordered">

                    <div class="form-group">
                        {!! Form::select('type', $widgetTypes, $widget->type, ['class' => 'form-control', 'required']) !!}
                    </div>

                </div>
            @endcomponent
        @else
            <meta name="widget_type" content="{{ $widget->type }}">
        @endif

        <div id="form-widget"></div>
    </div>

    <div class="col-lg-4">
        @component('components.block')
            @slot('title', trans('language.setting_field'))
            <div class="form-horizontal form-bordered">

                <div class="form-group">
                    {!! Form::label('name', trans('widget::language.widget_name'), ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', $widget->name, ['class' => 'form-control', 'required']) !!}
                    </div>
                </div>

                @if(!$widget->slug)
                    <div class="form-group">
                        {!! Form::label('slug', trans('widget::language.widget_slug'), ['class' => 'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            {!! Form::text('slug', $widget->slug, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    {!! Form::label('published', trans('language.published'), ['class' => 'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        <label class="switch switch-primary">
                            <input type="checkbox" name="published" value="1" {{ @$widget->published ? 'checked' : '' }}>
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        @endcomponent
    </div>
</div>

@include('partial.editor')
@push('footer')
<script>
    "use strict";
    (function ($) {
        var loadFormWidget = function ($type) {
            $.get('{{ request()->fullUrl() }}?type=' + $type, function($data) {
                $('#form-widget').html($data);
                editor().init();
                Main().init();
            });
        };

        $(document).ready(function() {
            var defaultWidget = $('select[name=type]').val();
            if($('select[name=type]').length > 0) {
                loadFormWidget(defaultWidget);
            } else {
                defaultWidget = $('meta[name=widget_type]');
                if (defaultWidget.length > 0) {
                    loadFormWidget(defaultWidget.attr('content'));
                }
            }

            $('select[name=type]').change(function (e) {
                e.preventDefault();
                loadFormWidget($(this).val());
            });
        });
    })(jQuery);
</script>
@endpush

@push('header')
    <style>
    #images, .images {
        padding: 10px;
    }

    .image-item {
        padding: 3px;
        margin: 3px;
        height: 130px;
        border: 3px dashed #efefef;
        position: relative;
        display: inline-block;
        margin-left: 23px;
        margin-top: 5px;
    }

    .image-item img {
        width: 100%;
        max-height: 96%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        margin-left: auto;
        margin-right: auto;
        margin-top: auto;
        margin-bottom: auto;
    }

    .image-item .btn-action {
        position: absolute;
        bottom: 0;
        right: 0;
    }

    .draggable-placeholder-gallery {
        background-color: #efefef;
        padding: 3px;
        margin: 3px;
        height: 130px;
        border: 3px dashed #efefef;
        position: relative;
        margin-left: 23px;
        margin-top: 5px;
        width: 16.666666667%;
        float: left;
    }

    .image-item .btn.edit-image {
        margin-right: 25px;
    }

    .btn-new-image {
        margin-top: 5px;
        margin-right: 5px;
    }

    .nav-tabs > li:first-child {
        margin-left: 17px;
    }
    </style>
@endpush
