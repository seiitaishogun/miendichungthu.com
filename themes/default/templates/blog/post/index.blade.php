@extends('theme::layout')
@push('header')
@include('seo_plugin::seo', [
'type' => 'article',
'title' => $title,
'description' => $description,
'image' => url(@$post->post->thumbnail ? $post->post->thumbnail : get_option('site_logo')),
'published_time' => $post->post->published_at
])
<script>
    CNV.categoryActive = '/blogs?id=' + {{ $post->post->categories->first()->id }};
</script>
@endpush
@section('content')
@include('theme::partial.heading')
<div class="container content-detail">
    <div class="row">
         @include('theme::partial.sidebar')
        <div class="col-md-8">
            <div class="single">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <h1 class="s-title">{{ $post->name }}</h1>
                        {{-- @php session()->get('lang') == 'vi' ? setlocale(LC_TIME, 'vi_VN') : setlocale(LC_TIME, ''); @endphp
                        <time><i class="fa fa-calendar"></i>{{ $post->post->published_at->formatLocalized('%A') }}, {{ Carbon\Carbon::parse($post->post->published_at)->format('d/m/Y') }}</time> --}}
                        <div class="s-content fv-content">
                            {!! $post->content !!}
                        </div>
                    </div>
                </div>
                @push('footer')
                    <script>
                        $(document).on('click', 'a[href^="#"]', function (event) {
                            event.preventDefault();

                            $('html, body').animate({
                                scrollTop: $($.attr(this, 'href')).offset().top
                            }, 500);
                        });
                    </script>
                @endpush
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="fb-comments" data-href="{{ $post->link }}" data-colorscheme="light" data-width="100%"></div>
                        <input type="hidden" name="slug_id" id="slug_id" value="#post_{{$post->post->id }}" />
                        <!--
                        <div class="s-social">
                            <span class="text">Chia sẻ: </span>
                            <div class="ctrl">
                                <ul class="cnv-social-icons list-inline">
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ $post->link }}" onclick="window.open(this.href, 'facebook-share','width=580,height=296');return false;" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?text={{ urlencode($post->name) }}&amp;url={{ $post->link }}" onclick="window.open(this.href, 'twitter-share', 'width=550,height=235');return false;" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                    <li><a href="https://plus.google.com/share?url={{ $post->link }}" onclick="window.open(this.href, 'google-plus-share', 'width=490,height=530');return false;"" class="instagram"><i class="fa fa-google-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        -->
                    </div>
                </div>
<!--
                <div class="bor-box lpost-box">
                    <h2 class="i-title">@if(session('lang') == 'vi') KHỐI U KHÁC @else Related News @endif</h2>
                    <ul>
                        @foreach(get_list_posts(-1,$post->post->categories->map->id->toArray()) as $post)
                        <li class="cat_{{$post->id}}"><a href="{{ $post->language('link') }}">{{ $post->language('name') }}</a></li>
                        @endforeach
                    </ul>
                </div>
                -->
            </div>
        </div>
    </div>
</div>
@endsection
@push('footer')
<script type="text/javascript">
    $(document).ready(function(){
        $('.cat_33').hide();
        var slug_ = $('#slug_id').val();
        if(slug_) {
            //alert(slug_);
            $(slug_).addClass('active');
        }
    });
</script>
@endpush

{{-- <div class="content_href">
    <table width="100%" class="table_post_custom table_reposive">
        <tbody>
             <tr>
                <td style="width: 33.333%; text-align: center; vertical-align: middle;">
                    <a href="#thiet-ke-nghien-cuu" style="font-size: 14pt;">Thiết kế nghiên cứu</a>
                </td>

                <td style="width: 33.333%; text-align: center; vertical-align: middle;">
                    <a href="#dac-diem-benh-nhan" style="font-size: 14pt;">Đặc điểm bệnh nhân</a>
                </td>

                <td style="width: 33.333%; text-align: center; vertical-align: middle;">
                    <a href="#ket-qua-nghien-cuu" style="font-size: 14pt;">Kết quả nghiên cứu</a>
                </td>

             </tr>
        </tbody>
    </table>
</div>
<div class="group_content">

    <div id="thiet-ke-nghien-cu" class="section_contact">
        <span class="title_blog_href">1.Thiết kế nghiên cứu</span>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </p>

    </div>


    <div id="dac-diem-benh-nhan" class="section_contact">
        <span class="title_blog_href">2.Đặc điểm bệnh nhân</span>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>



    <div id="ket-qua-nghien-cuu" class="section_contact">
        <span class="title_blog_href"> 3.Kết quả nghiên cứu</span>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>


        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

    </div>
</div> --}}
