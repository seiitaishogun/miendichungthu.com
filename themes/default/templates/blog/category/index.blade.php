@extends('theme::layout')
@push('header')
    <script>
            CNV.categoryActive = '/blogs?id=' + {{ $category->category->id }};
    </script>
@endpush
@section('content')
@include('theme::partial.heading')
<div class="container">
    <div class="row">
        @include('theme::partial.sidebar')
        <div class="col-md-8 dlls-wrap">
            @forelse($posts as $post)
            <div class="post2 clearfix">
                <a class="img hv-scale hv-over cnv-img-new" href="{{ $post->language('link') }}" title="">
                    <img src="{{ $post->thumbnail }}" alt="" title="" />
                </a>
                <div class="ct">
                    <h2 class="title"><a class="smooth" href="{{ $post->language('link') }}" title="">{{ $post->language('name') }}</a></h2>
                    @php session()->get('lang') == 'vi' ? setlocale(LC_TIME, 'vi_VN') : setlocale(LC_TIME, ''); @endphp
                    {{-- <time>{{ $post->published_at->formatLocalized('%A') }}, {{ Carbon\Carbon::parse($post->published_at)->format('d/m/Y') }} </time> --}}
                    <div class="des2">
                        {{ $post->language('description') }}
                    </div>
                    <a class="more" href="{{ $post->language('link') }}" title="">@if(session('lang') == 'vi') Xem chi tiết @else See more @endif</a>
                </div>
            </div>
            @empty
            <h3>Thông tin đang cập nhật...</h3>
            @endforelse

            {{ $posts->links() }}

        </div>

    </div>
</div>
@endsection
