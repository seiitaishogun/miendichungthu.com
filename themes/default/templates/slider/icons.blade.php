@foreach(collect($widget->content[$current_language])->chunk(2) as $block)
    @if($loop->iteration > 2) @break @endif
    <div class="col-lg-auto col-md-6">
        @foreach($block as $content)
            <div class="line">
                <div class="icon">
                    <img src="{{ @$content['picture'] }}" alt="{{ @$content['title'] }}" title="{{ @$content['title'] }}">
                </div>
                <p>{{ @$content['title'] }}</p>
            </div>
        @endforeach
    </div>
@endforeach