@extends('theme::layout')
@push('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.css">
@endpush
@push('footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.4.1/jquery.fancybox.min.js"></script>
@endpush
@section('content')
{{-- Load Banner --}}
    <div class="banner banner_customer">
            {!! strip_tags(widget('banner-detail-album'),'<img>') !!}
    </div>
{{-- End Load Banner --}}

@include('theme::partial.heading')
<div class="container gallerys">
    <div class="row" data-toggle="lightbox-gallery">
        <div class="content col-sm-12">
            <div class="row">
                @foreach($gallery->content as $content)
                    <div class="col-md-4">
                        <div class="def-cas album-cas wow fadeInUp">
                            <div class="item">
                                <div class="c-album">
                                    <a class="smooth cnv-img-16x9" href="{{ @$content['picture'] }}" title="" data-fancybox="images">
                                        <div class="img">
                                            <img class="cnv-smooth" src="{{ @$content['picture'] }}" alt="" title="{{ @$content['title'] }}"/>
                                        </div>
                                    </a>
                                   {{-- <a class="smooth" href="javascript:void(0)" title=""><h3 class="title text-center">{{ @$content['title'] }}</h3></a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
