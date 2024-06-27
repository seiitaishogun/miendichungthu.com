@php
    preg_match('/<img src\=\"(.*?)\"/is',widget('banner-breadcrumb'),$images);
@endphp
<div class="banner">
    @if(count($images) > 0)
    <img src="{{ $images[1]  }}" alt="" title="" />
    @else
    <style>
        .banner{
            margin-top: 50px
        }
    </style>
    @endif
    <div class="breadcrumbs">
        <div class="container">
            <ul>
                <li><a href="{{ url('/') }}">{{ trans('language.home') }}</a></li>
                  @foreach($breadcrumb as $item)
                    <li><a href="{{ $item['link'] }}">{{ $item['name'] }}</a></li>
                  @endforeach
            </ul>
        </div>
    </div>
</div>
