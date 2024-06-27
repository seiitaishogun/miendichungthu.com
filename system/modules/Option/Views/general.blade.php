@extends('admin')

@section('page_header')

    <div class="pull-right">
        <button type="button" class="btn btn-primary" onclick="submitForm('#save');">
            <i class="fa fa-save"></i> {{ trans('language.save') }}
        </button>
    </div>

    <h1>
        {{ $title }}
    </h1>
@stop

@section('content')

    @component('components.block')

    @slot('title', $title)

    {!! Form::open([
        'url' => admin_url('option'),
        'method' => 'POST',
        'class' => 'form-validate form-horizontal',
        'id' => 'save',
        'enctype' => 'multipart/form-data',
        'data-callback' => 'nothing_to_do'
    ]) !!}
    {{ csrf_field() }}

    <div class="row">
        <div class="col-lg-4">
            <h2>{{ trans('option::language.general_information') }}</h2>
            <p>{{ trans('option::language.general_information_des') }}</p>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_name', trans('option::language.general_site_name'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_name', get_option('site_name'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_name'), 'required']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_description', trans('option::language.general_site_description'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_description', get_option('site_description'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_description'), 'required']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_keywords', trans('option::language.general_site_keywords'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_keywords', get_option('site_keywords'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_keywords'), 'required']) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('site_logo', trans('option::language.general_site_logo'), ['class' => 'control-label']) !!}
                        <div class="choose-thumbnail">
                            {!! Form::hidden('site_logo', get_option('site_logo'), ['id' => 'site_logo']) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('site_favicon', trans('option::language.general_site_favicon'), ['class' => 'control-label']) !!}
                        <div class="choose-thumbnail">
                            {!! Form::hidden('site_favicon', get_option('site_favicon'), ['id' => 'site_favicon']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-4">
            <h2>Hình bộ công thương</h2>
        </div>
         <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_thumbnail_bct','Hình ảnh bộ công thương', ['class' => 'control-label']) !!}
                        <div class="choose-thumbnail">
                            {!! Form::hidden('site_thumbnail_bct', get_option('site_thumbnail_bct'), ['id' => 'site_thumbnail_bct']) !!}
                        </div>
                         {!! Form::label('site_link_bct','Link bộ công thương', ['class' => 'control-label']) !!}
                        {!! Form::text('site_link_bct', get_option('site_link_bct'), ['class' => 'form-control', 'placeholder' => 'Link Bộ Công Thương']) !!}
                    </div>
                </div>
            </div>
         </div>

    </div>
    <hr/>
    <div class="row">
        <div class="col-lg-4">
            <h2>Thanh Fix Right</h2>
        </div>
         <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_thumbnail_ttkt','Hình ảnh thông tin kê toa', ['class' => 'control-label']) !!}
                        <div class="choose-thumbnail">
                            {!! Form::hidden('site_thumbnail_ttkt', get_option('site_thumbnail_ttkt'), ['id' => 'site_thumbnail_ttkt']) !!}
                        </div>

                        {!! Form::label('site_name_ttkt','Tên thông tin kê toa', ['class' => 'control-label']) !!}
                        {!! Form::text('site_name_ttkt', get_option('site_name_ttkt'), ['class' => 'form-control', 'placeholder' => 'Thông tin kê toa']) !!}

                        {!! Form::label('site_link_ttkt','Link thông tin kê toa', ['class' => 'control-label']) !!}
                        {!! Form::text('site_link_ttkt', get_option('site_link_ttkt'), ['class' => 'form-control', 'placeholder' => 'Thông tin kê toa']) !!}

                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form_group">

                        {!! Form::label('site_thumbnail_ccd','Hình ảnh chống chỉ định-thận trọng', ['class' => 'control-label']) !!}
                        <div class="choose-thumbnail">
                            {!! Form::hidden('site_thumbnail_ccd', get_option('site_thumbnail_ccd'), ['id' => 'site_thumbnail_ccd']) !!}
                        </div>

                        {!! Form::label('site_name_ccd','Tên chống chỉ định-thận trọng', ['class' => 'control-label']) !!}
                        {!! Form::text('site_name_ccd', get_option('site_name_ccd'), ['class' => 'form-control', 'placeholder' => 'Thông tin kê toa']) !!}


                         {!! Form::label('site_link_ccd','Link chống chỉ định-thận trọng', ['class' => 'control-label']) !!}
                        {!! Form::text('site_link_ccd', get_option('site_link_ccd'), ['class' => 'form-control', 'placeholder' => 'Link chống chỉ định']) !!}
                    </div>
                </div>

            </div>
         </div>

    </div>
    <hr/>
    <div class="row">
        <div class="col-lg-4">
            <h2>Recaptcha</h2>
            <p></p>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('recaptcha_site_key', 'Recaptcha Site Key', ['class' => 'control-label']) !!}
                        {!! Form::text('recaptcha_site_key', get_option('recaptcha_site_key'), ['class' => 'form-control', 'placeholder' => 'Recaptcha Site Key']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('recaptcha_secret_key', 'Recaptcha Secret Key', ['class' => 'control-label']) !!}
                        {!! Form::text('recaptcha_secret_key', get_option('recaptcha_secret_key'), ['class' => 'form-control', 'placeholder' => 'Recaptcha Secret Key']) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-4">
            <h2>{{ trans('option::language.general_address') }}</h2>
            <p>{{ trans('option::language.general_address_des') }}</p>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_business_license', trans('option::language.general_site_business_license'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_business_license', get_option('site_business_license'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_business_license')]) !!}
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_email', trans('option::language.general_site_email'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_email', get_option('site_email'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_email')]) !!}
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('site_phone', trans('option::language.general_site_phone'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_phone', get_option('site_phone'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_phone')]) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('site_fax', trans('option::language.general_site_fax'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_fax', get_option('site_fax'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_fax')]) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('site_address', trans('option::language.general_site_address'), ['class' => 'control-label']) !!}
                        {!! Form::text('site_address', get_option('site_address'), ['class' => 'form-control', 'placeholder' => trans('option::language.general_site_address')]) !!}
                    </div>
                </div>
                <input type="hidden" data-toggle="province" value="{{ @get_option('province') }}">
                <input type="hidden" data-toggle="district" value="{{ @get_option('district') }}">
                <input type="hidden" data-toggle="ward" value="{{ @get_option('ward') }}">

                <div class="col-md-4">
                    <div class="form_group">
                        <select name="province" class="form-control non-select2" required="">
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form_group">
                        <select name="district" class="form-control non-select2" required="">
                            <option value="N/A">Quận / Huyện</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form_group">
                        <select name="ward" class="form-control non-select2" required="">
                            <option value="N/A">Phường / Xã</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-4">
            <h2>{{ trans('option::language.general_codescript') }}</h2>
            <p>{{ trans('option::language.general_codescript_des') }}</p>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('google_analytics', 'Google Analytics', ['class' => 'control-label']) !!}
                        {!! Form::textarea('google_analytics', get_option('google_analytics'), ['class' => 'form-control', 'placeholder' => 'Google Analytics']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('google_remaketing', 'Google Remaketing', ['class' => 'control-label']) !!}
                        {!! Form::textarea('google_remaketing', get_option('google_remaketing'), ['class' => 'form-control', 'placeholder' => 'Google Remaketing']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('facebook_pixel', 'Facebook Pixel', ['class' => 'control-label']) !!}
                        {!! Form::textarea('facebook_pixel', get_option('facebook_pixel'), ['class' => 'form-control', 'placeholder' => 'Facebook Pixel']) !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form_group">
                        {!! Form::label('livechat', 'Livechat', ['class' => 'control-label']) !!}
                        {!! Form::textarea('livechat', get_option('livechat'), ['class' => 'form-control', 'placeholder' => 'Livechat']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    @if(config('cnv.allow_watermark'))
    <div class="row">
        <div class="col-lg-4">
            <h2>{{ trans('option::language.watermark') }}</h2>
            <p>{{ trans('option::language.watermark_mes') }}</p>
        </div>
        <div class="col-lg-8">
            <div class="row">
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('watermark', trans('option::language.watermark'), ['class' => 'control-label']) !!}
                        <input type="radio" name="watermark" value="1" id="watermark_on" {{ get_option('watermark') ? 'checked' : '' }}> <label for="watermark_on">{{ trans('option::language.watermark_on') }}</label>
                        <input type="radio" name="watermark" value="0" id="watermark_off" {{ !get_option('watermark') ? 'checked' : '' }}> <label for="watermark_off">{{ trans('option::language.watermark_off') }}</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('watermark_position', trans('option::language.watermark_position'), ['class' => 'control-label']) !!}
                        <p>
                            <input type="radio" name="watermark_position" value="top-left" id="watermark_top_left"
                                    {{ get_option('watermark_position') == 'top-left' ? 'checked' : '' }}>
                            <label for="watermark_top_left">{{ trans('option::language.watermark_top_left') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="top" id="watermark_top"
                                    {{ get_option('watermark_position') == 'top' ? 'checked' : '' }}>
                            <label for="watermark_top">{{ trans('option::language.watermark_top') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="top-right" id="watermark_top_right"
                                    {{ get_option('watermark_position') == 'top-right' ? 'checked' : '' }}>
                            <label for="watermark_top_right">{{ trans('option::language.watermark_top_right') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="left" id="watermark_left"
                                    {{ get_option('watermark_position') == 'left' ? 'checked' : '' }}>
                            <label for="watermark_left">{{ trans('option::language.watermark_left') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="center" id="watermark_center"
                                    {{ get_option('watermark_position') == 'center' ? 'checked' : '' }}>
                            <label for="watermark_center">{{ trans('option::language.watermark_center') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="right" id="watermark_right"
                                    {{ get_option('watermark_position') == 'right' ? 'checked' : '' }}>
                            <label for="watermark_right">{{ trans('option::language.watermark_right') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="bottom-left" id="watermark_bottom_left"
                                    {{ get_option('watermark_position') == 'bottom-left' ? 'checked' : '' }}>
                            <label for="watermark_bottom_left">{{ trans('option::language.watermark_bottom_left') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="bottom" id="watermark_bottom"
                                    {{ get_option('watermark_position') == 'bottom' ? 'checked' : '' }}>
                            <label for="watermark_bottom">{{ trans('option::language.watermark_bottom') }}</label>
                        </p>
                        <p>
                            <input type="radio" name="watermark_position" value="bottom-right" id="watermark_bottom_right"
                                    {{ get_option('watermark_position') == 'bottom-right' ? 'checked' : '' }}>
                            <label for="watermark_bottom_right">{{ trans('option::language.watermark_bottom_right') }}</label>
                        </p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form_group">
                        {!! Form::label('watermark_image', trans('option::language.watermark_image'), ['class' => 'control-label']) !!}
                        <div class="choose-thumbnail">
                            {!! Form::hidden('watermark_image', get_option('watermark_image'), ['id' => 'watermark_image']) !!}
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @endif


    @foreach(get_hook('general_option_fields') as $field)
        @include($field)
    @endforeach

        {!! Form::close() !!}

    @endcomponent

@stop

@include('partial.editor')
