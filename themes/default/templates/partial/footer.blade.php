@if(url('/login') == url()->current())
    {!! widget('doi-tac-slider') !!}
@endif

<footer>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-7 col-md-7 col-sm-12 col-12">
                <!-- <h4 class="f-title">VPĐD Merck Sharp & Dohme (Asia) Ltd. tại TP.HCM</h4>
                <div class="f-line">Địa chỉ: Lầu 16, tòa nhà Mplaza, 39 Lê Duẩn, P.Bến Nghé, Q.1, TP.HCM</div>
                <div class="f-line">Điện thoại: (028) 391 55 800</div>
                <div class="f-line">*Nội dung trang web này là dành riêng cho các Cán bộ y tế đã đăng kí hành nghề ở Việt Nam.</div> -->
                {!! widget('footer-thong-tin-cong-ty') !!}
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-12">
                <h4 class="f-title">Chính sách</h4>
                <ul>
                    @foreach(cnv_menu('footer-menu') as $item)
                    <li><a class="smooth" href="{{ Auth::guard('customer')->check() ? ( @$item->attributes['url'] == '#' ? 'javascript:void(0);' :  @$item->attributes['url'] ) : '/register' }}" title="">{{ $item->language('name') }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-12 col-12">
                <div class="bct">
                    <a href="{{ get_option('site_link_bct') }}"><img src="{{ get_option('site_thumbnail_bct') }}" alt="" title="" /></a>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            Copyright © 2020 MSD ONCOLOGY. <label> All rights reserved.</label>
        </div>
    </div>
</footer>

@if(Auth::guard('customer')->check())
    <div class="fix-right">
        <button class="m-open"></button>

        <div class="fixed-right-cas">
            <div class="item">
                <a class="smooth" href="{{ get_option('site_link_ttkt') }}" title=""><span><img src="{{ get_option('site_thumbnail_ttkt') }}" alt="" title="" /></span> <big>{{ get_option('site_name_ttkt') }}</big></a>
            </div>

            <div class="item">
                <a class="smooth item" href="{{ get_option('site_link_ccd') }}" title=""><span><img src="{{ get_option('site_thumbnail_ccd') }}" alt="" title="" /></span> {{ get_option('site_name_ccd') }}</a>
            </div>
        </div>
    </div>
@endif


<!-- Modal -->
<div class="modal fade" id="myVideo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-content" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title model_title_video" id="exampleModalLongTitle"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
             </div>
            <div class="modal-body modal-body-video">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" src="" id="video"  allowscriptaccess="always" allow="autoplay"></iframe>
                </div>

            </div>
        </div>
    </div>
</div>

@push('footer')

        <div class="popup_checking">
            <div class="overlay">&nbsp;</div>
            <div class="modal_popup">
                <div class="msg">
                    {!! widget('popup-noi-dung-va-tieu-de') !!}
                </div>
                <div class="first-visit-overlay">
                    <button onclick="setCookiePage('/login')" class="first-visit-overlay__button first-visit-overlay__button--continue" data-first-visit-overlay-dismiss="true"><span>Tôi là cán bộ y tế</span></button>
                    <a href="javascript:void(0)" onclick="setCookiePage('{!! strip_tags(widget('popup-toi-khong-phai-la-can-bo-y-te-duong-dan')) !!}')" class="first-visit-overlay__button first-visit-overlay__button"><span>Tôi không phải là cán bộ y tế</span></a>
                </div>
            </div>
        </div>


    <script>
        $(document).ready(function(){
            if(!Cookies.get('checkCookie'))
            {
                  $('.popup_checking').show();
            }
            else
            {
                 $('.popup_checking').hide();
            }
        })
        function setCookiePage(href){
            document.cookie = "checkCookie="+ Math.random().toString(36);
            window.location.href  = href;
        }
    </script>
@endpush
