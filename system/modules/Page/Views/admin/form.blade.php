<div class="row">
    <div class="col-lg-8">
        @component('components.block')
            @slot('title', trans('language.basic_info'))
                <div class="form-bordered">

                    <ul class="nav nav-tabs" data-toggle="tabs">
                        @foreach(config('cnv.languages') as $language)
                            <li {{ $loop->first ? 'class=active' : '' }}>
                                <a href="#{{ $language['locale'] }}">
                                    {{ $language['name'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach(config('cnv.languages') as $language)
                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{ $language['locale'] }}">
                                <div class="form-group">
                                    {!! Form::label('name', trans('language.name'), ['class' => 'label-control']) !!}
                                    {!! Form::text('language['. $language['locale'] .'][name]', @$page->language('name', $language['locale']), ['class' => 'form-control', 'required']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('description', trans('language.description'), ['class' => 'label-control']) !!}
                                    {!! Form::textarea('language['. $language['locale'] .'][description]', @$page->language('description', $language['locale']), ['class' => 'form-control']) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('content', trans('language.content'), ['class' => 'label-control']) !!}
                                    {!! Form::textarea('language['. $language['locale'] .'][content]', @$page->language('content', $language['locale']), ['class' => 'form-control editor', 'required']) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
        @endcomponent
        @include('seo_plugin::form', ['base'=>'pages', 'model'=>$page])
    </div>
    <div class="col-lg-4">
        @component('components.block')
            @slot('title', trans('language.setting_field'))
                <div class="form-horizontal form-bordered">

                    <div class="form-group">
                        {!! Form::label('published', trans('language.published'), ['class' => 'control-label col-md-4']) !!}
                        <div class="col-md-8">
                            <label class="switch switch-primary">
                                <input type="checkbox" name="published" value="1" {{ @$page->published ? 'checked' : '' }}>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="javascript:void(0);" onclick="toggleThisElement('#show_publish_datetime');return false;">{{ trans('language.set_a_specific_publish_date') }}</a>
                    </div>
                    <div class="form-group" id="show_publish_datetime" style="display: none">
                        <div class="col-md-7">
                            {!! Form::text('date_published', @$page->published_at->format('d-m-Y'), ['class' => 'form-control input-datepicker']) !!}
                        </div>
                        <div class="col-md-5">
                            <div class="input-group bootstrap-timepicker timepicker">
                                {!! Form::text('time_published', @$page->published_at->format('H:i'), ['class' => 'form-control input-timepicker24']) !!}
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                            </div>
                        </div>
                    </div>

                </div>
        @endcomponent

        @component('components.block')
            @slot('title', trans('language.thumbnail'))
            <div class="form_group">
                <div class="choose-thumbnail">
                    {!! Form::hidden('thumbnail', @$page->thumbnail, ['id' => 'thumbnail']) !!}
                </div>
            </div>
        @endcomponent
    </div>
</div>

@include('partial.editor')
