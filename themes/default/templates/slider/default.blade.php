<div class="cnv-slider">
    @foreach($widget->content[$current_language] as $content)
        <div class="item {{ ! $loop->first ? 'slick-slide' : '' }}">
            <div class="img">
                <a class="smooth" href="{{ $content['link'] }}" title=""><img src="{{ $content['picture'] }}" alt=""></a>
            </div>
        </div>
    @endforeach
</div>
