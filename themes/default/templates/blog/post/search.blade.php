@extends('theme::layout')

@section('content')
    @include('theme::partial.heading', ['title' => trans('blog::language.search_result'), 'url' => 'javascript:void(0);'])

<div id="search_wrap" class="container" style="margin-top: 30px">
    <div class="row">
        <!-- @include('theme::partial.sidebar') -->
        <div class="col-md-8">
            <div class="single">
                <h2 class="s-title"> Có <span style="color:red;">({{count($pages) + count($posts)}})</span> kết quả được tìm thấy:  </h2>
            </div>
            @forelse($pages as $post)
            <div class="post2 clearfix col-sm-12 context">
                <div class="ct1">
                    <h2 class="title"><a class="smooth" href="pages/{{ $post->slug }}" title="">{{ $post->name }}</a></h2>
                    @php session()->get('lang') == 'vi' ? setlocale(LC_TIME, 'vi_VN') : setlocale(LC_TIME, ''); @endphp
                    <div class="des2">
                        {{ $post->description }}
                    </div>
                    <a class="more" href="pages/{{ $post->slug }}" title="">@if(session('lang') == 'vi') Xem chi tiết @else See more @endif</a>
                </div>
            </div>
            @empty
                <!-- <div class="post2 clearfix">
                    Không tìm thấy kết quả!
                </div> -->
            @endforelse
            <!-- <div class="single"></div>
                <h2 class="s-title"> Tìm kiếm Bài Viết: </h2>
            </div> -->
            @if($posts->isNotEmpty())
                {!! $posts->appends(request(['q']))->links() !!}
            @endif
            @forelse($posts as $post)
            <div class="post2 clearfix context">
                <a class="img hv-scale hv-over cnv-img-new" href="{{ $post->link }}" title="">
                    <img src="{{ $post->post->thumbnail }}" alt="" title="" />
                </a>
                <div class="ct">
                    <h2 class="title"><a class="smooth" href="{{ $post->link }}" title="">{{ $post->name }}</a></h2>
                    @php session()->get('lang') == 'vi' ? setlocale(LC_TIME, 'vi_VN') : setlocale(LC_TIME, ''); @endphp
                    <time>{{ $post->post->published_at->formatLocalized('%A') }}, {{ Carbon\Carbon::parse($post->post->published_at)->format('d/m/Y') }}</time>
                    <div class="des2">
                        {{ $post->description }}
                    </div>
                    <a class="more" href="{{ $post->link }}" title="">@if(session('lang') == 'vi') Xem chi tiết @else See more @endif</a>
                </div>
            </div>
            @empty
                <!-- <div class="post2 clearfix">
                    Không tìm thấy từ khoá
                </div> -->
            @endforelse

            @if($posts->isNotEmpty())
                {!! $posts->appends(request(['q']))->links() !!}
            @endif
        </div>
    </div>
</div>
@endsection
@push('footer')
<script src="https://cdn.jsdelivr.net/mark.js/8.6.0/jquery.mark.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $(window).load(function(){
        setTimeout(function() {
            $('body, html').animate({
                scrollTop: $('#search_wrap').offset().top - 60
            }, 700);
        }, 1000);
        });
        
    });
    $(function() {
        var mark = function() {
        // Read the referrer
        // In this example it is inside the input field, in practice it is document.referrer
        var referrer = window.location.href;
        // Read the parameter
        var paramKey = 'q';

        // Make sure there in the referrer is an parameter passed (the search query)
        if (referrer.indexOf("?") !== -1) {

        // Generate an array with all referrer parameters
        var qs = referrer.substr(referrer.indexOf('?') + 1);
        var qsa = qs.split('&');

        // Go through all referrer parameters
        var keyword = "";
        for (var i = 0; i < qsa.length; i++) {

            // Split the current parameter into key and value
            // Key will be currentParam[0] and value currentParam[1]
            var currentParam = qsa[i].split('=');

            // Make sure the parameter has a key and value
            if (currentParam.length !== 2) {
            continue;
            }

            // Check if the current parameter is the search parameter
            if (currentParam[0] == paramKey) {

            // Save the decoded URL (e.g. + needs to be converted to a blank)
            // keyword and exit the loop
            keyword = decodeURIComponent(currentParam[1].replace(/\+/g, "%20"));

            }
        }

        // Check if there is a keyword
        if (keyword != "") {

            // Determine selected options
            var options = {separateWordSearch: false};

            // Mark the keyword inside the context
            $(".context").unmark({
            done: function() {
                $(".context").mark(keyword, options);
            }
            });
        }

        }

        };
        mark.call();
    });
    </script>
    <style>
    mark, .mark {
        background-color: #fff2ac;
        background-image: linear-gradient(to right, #ffe359 0%, #fff2ac 100%);
        padding: .2em;
    }
    .post2 {
        margin-bottom: 0 !important;
        padding-bottom: 10px !important;
    }
    .post2 .ct {
        margin-left: 270px !important;
    }
    .cnv-img-new {
    }
    </style>
@endpush
