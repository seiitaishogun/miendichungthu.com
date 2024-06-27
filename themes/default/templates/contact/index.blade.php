@extends('theme::layout')

@push('header')
    <script>
        CNV.categoryActive = '/contact';
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush

@section('content')
    @include('theme::partial.heading', ['title' => trans('custom.contact'), 'url' =>  request()->url()])
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- block  contact-->
                <div class="block-contact-us">
                    <form action="{{ url('/contact') }}" method="post" class="form-validate">
                    <div class="block-content row">
                        <div class="col-sm-5">
                            <div class="form-group input-contact">
                                <input type="text" required="" placeholder="{{ trans('contact::web.your_name') }} *" name="name" class="form-control" id="name">
                            </div>
                            <div class="form-group input-contact">
                                <input type="text" required="" placeholder="{{ trans('contact::web.your_email') }} *" name="email" class="form-control" id="email">
                            </div>
                            <div class="form-group input-contact">
                                <input type="text" required="" placeholder="{{ trans('contact::web.your_phone') }} *" name="phone" class="form-control" id="phone">
                            </div>
                            <div class="form-group input-contact">
                                <input type="text" required="" placeholder="{{ trans('contact::web.your_subject') }} *" name="subject" id="subject" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <textarea placeholder="{{ trans('contact::web.your_message') }}" name="message" rows="3" class="form-control" id="message"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="{{ get_option('recaptcha_site_key') }}"></div>
                            </div>
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
                    {!! widget('lien-he-thong-tin-cong-ty') !!}
                </div><!-- block  contact-->
            </div>
        </div>
    </div>

    <div>
        <div class="col-md-12 mmap">
            {!! widget('lien-he-ban-do') !!}
        </div>
    </div>
    <div class="clearfix"></div>
@endsection
