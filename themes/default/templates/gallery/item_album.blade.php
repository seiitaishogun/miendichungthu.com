<div class="col-md-4">
    <div class="def-cas album-cas wow fadeInUp">
        <div class="item">
            <div class="c-album">
                <a class="smooth cnv-img-16x9" href="{{ $item->language('link') }}" title="" rel="gal">
                    <div class="img">
                        <img class="cnv-smooth" src="{{ $item->thumbnail }}" alt="" title=""/>
                    </div>
                </a>
                <a href="{{ $item->language('link') }}"><h3 class="title text-center">{{ $item->language('name') }}</h3></a>
            </div>
        </div>
    </div>
</div>

    <!-- <div class="content gallery" data-toggle="lightbox-gallery">
        <div class="">
            <a href="{{ $item->thumbnail }}" title="" class="gallery-link" rel="gal">
                    <img src="{{ $item->thumbnail }}" alt="" title=""/>
            </a>
        </div>

        <div class="">
            <a href="{{ $item->thumbnail }}" title="" class="gallery-link" rel="gal">
                    <img src="{{ $item->thumbnail }}" alt="" title=""/>
            </a>
        </div>
    </div> -->
