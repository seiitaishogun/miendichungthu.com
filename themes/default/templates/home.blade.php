@extends('theme::layout')

@section('content')

    {!! widget('trang-chu-slider') !!}

    <div class="container">
        <div class="cnv-note">
            <div class="row justify-content-between">
                {!! widget('trang-chu-4-icon-ngoai-trang-chu') !!}
            </div>
        </div>
    </div>

    <div class="container v2">
        <div class="cnv-info">
            {!! widget('trang-chu-noi-dung-duoi-4-icon') !!}
        </div>
    </div>
<!--
    <div class="cnv-content active">
        <div class="container v2">
            <div class="s-content">
                <h2 class="title">
                    {!! strip_tags(widget('trang-chu-chong-chi-dinh-than-trong-phan-ung-bat-loi-tieu-de')) !!}
                </h2>
                <div class="row">
                    <div class="col-lg-5 col-left">
                        {!! widget('trang-chu-chong-chi-dinh-than-trong-phan-ung-bat-loi-noi-dung-trai') !!}
                    </div>
                    <div class="col-lg-7">
                        {!! widget('trang-chu-chong-chi-dinh-than-trong-phan-ung-bat-loi-noi-dung-phai') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="cnv-content sticky-content" id="stickyContent">
        <div class="sticky-block">
            <div class="container v2">
                <div class="s-content">
                    <h2 class="title">
                        {!! strip_tags(widget('trang-chu-chong-chi-dinh-than-trong-phan-ung-bat-loi-tieu-de')) !!}
                    </h2>
                    <div class="row">
                        <div class="col-lg-5 col-left">
                            {!! widget('trang-chu-chong-chi-dinh-than-trong-phan-ung-bat-loi-noi-dung-trai') !!}
                        </div>
                        <div class="col-lg-7">
                            {!! widget('trang-chu-chong-chi-dinh-than-trong-phan-ung-bat-loi-noi-dung-phai') !!}
                        </div>
                    </div>
                </div>

                <button type="button" class="expand-btn fix-btn">Mở rộng (+)</button>
            </div>
        </div>
    </div>
-->
    {{-- @push('footer')
        @if(Auth::guard('customer')->check() == false)
            <script>
                document.cookie = "checkCookie=";
            </script>
        @endif
    @endpush --}}

@stop


@push('footer')
    <script type="text/javascript">
        $('.expand-btn:not(.fix-btn)').click(function(e) {
            $('.cnv-content:not(.sticky-footer)').toggleClass('active');
            $('.cnv-content:not(.sticky-footer)').hasClass('active') ? $(this).text('Thu nhỏ -') : $(this).text('Mở rộng (+)');
        });
{{--
        $(window).scroll(function () {
            var position = $('.cnv-content:not(.sticky-content)').offset().top;
            
            if ($('.cnv-content.sticky-content').offset().top >= position) {
                $('.cnv-content.sticky-content').removeClass('active');
                $('.cnv-content.sticky-content').css({'opacity': 0, 'visibility': 'hidden'});
            } else {
                $('.cnv-content.sticky-content').css({'opacity': 1, 'visibility': 'visible'});
            }
        });
--}}
        $('.expand-btn.fix-btn').click(function(e) {
            $('.cnv-content.sticky-content').toggleClass('active');
            $('.cnv-content.sticky-content').hasClass('active') ? $(this).text('Thu nhỏ -') : $(this).text('Mở rộng (+)');

            {{--  var maxHeight = $(window).innerHeight() - $('header').innerHeight();

            if ($('.cnv-content.sticky-content').hasClass('active')) {
                $('.cnv-content.sticky-content .s-content').css('max-height', maxHeight);
            } else {
                $('.cnv-content.sticky-content .s-content').css('max-height', '');
            }  --}}

            $('body').toggleClass('hideScrollBar');
        });
    </script>
@endpush