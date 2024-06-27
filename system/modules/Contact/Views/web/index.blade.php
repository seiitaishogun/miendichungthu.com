@extends('theme::layout')
@push('header')
<script>
     CNV.categoryActive = '/contact';
</script>
<style type="text/css">
    .btn-inline {
        display: inline-block;
        margin-bottom: 0;
        margin-top: 20px;
        font-weight: normal;
        text-align: center;
        vertical-align: middle;
        -ms-touch-action: manipulation;
        touch-action: manipulation;
        cursor: pointer;
        background-color: #4cb050;
        color: #fff;
        border: 1px solid transparent;
        white-space: nowrap;
        padding: 6px 12px;
        font-size: 14px;
        line-height: 1.42857143;
        border-radius: 4px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        margin-bottom: 20px;
    }
</style>
@endpush
@push('footer')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endpush
@section('content')
<section class="cnv-block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
            </div>
            <div class="col-md-8">
                <!-- block  contact-->
                <div class="block-contact-us">
                    <form action="{{ url('/contact') }}" method="post" class="form-validate">
                    <div class="block-content row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" placeholder="{{ trans('contact::web.your_subject') }}" name="subject" id="subject" class="form-control">
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="{{ trans('contact::web.your_name') }} *" name="name" class="form-control" id="name" required="required">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="{{ trans('contact::web.your_email') }} *" name="email" class="form-control" id="email"  required="required">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group">
                                <input type="text" placeholder="{{ trans('contact::web.your_phone') }}" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <textarea placeholder="{{ trans('contact::web.your_message') }} *" name="message" rows="4" class="form-control" id="message"  required="required"></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="g-recaptcha" data-sitekey="6LdSvkkUAAAAAO8FutYqxkg7yagEwOHBajAVLPJj"></div>
                            <div class="text-left">
                                <button class="btn btn-inline" type="submit">{{ trans('contact::web.send') }}</button>
                            </div>
                        </div>
                    </div><!-- block  contact-->
                    </form>
                </div>
            </div>

            <div class="col-md-4">

                <!-- block  contact-->
                <div class="block-address">
                    {{--  {!! widget('contact-information') !!}  --}}
                </div><!-- block  contact-->
            </div>
        </div>
    </div>
</section>
<div class="col-md-12 mmap clearfix">
    <div class="row">
        {{--  {!! widget('contact-maps') !!}  --}}
    </div>
</div>
@endsection