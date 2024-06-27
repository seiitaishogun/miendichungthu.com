{{-- @dump($item->language('content')['link']) --}}
<div class="col-md-4">
    <div class="def-cas album-cas wow fadeInUp">
        <div class="item">
            <div class="c-album">
                <a data-title-video="{{ $item->language('name') }}" data-src="{{ \App\Libraries\Str::parseYoutubeLinkToEmbed(@$item->language('content')['link'])  }}" data-toggle="modal" data-target="#myVideo" class="smooth cnv-img-16x9 video-show" href="javascript:void(0)" title="" rel="gal">
                        <img class="cnv-smooth" src="{{ $item->thumbnail }}" alt="" title=""/>
                </a>
                <a data-title-video="{{ $item->language('name') }}" data-src="{{ \App\Libraries\Str::parseYoutubeLinkToEmbed(@$item->language('content')['link'])  }}" class="video-show" data-toggle="modal" data-target="#myVideo" href="javascript:void(0)><h3 class="title text-center"><h3 class="title text-center">{{ $item->language('name') }}</h3></a>
            </div>
        </div>
    </div>
</div>

