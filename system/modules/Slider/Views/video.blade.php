@foreach($widget->content->sortBy('position') as $content)
    {{ @$content['link'] ?: '#'}}
    {{ @$content['language'][$current_language]['title'] }}
    {{ @$content['language'][$current_language]['picture'] }}
    @if(@$content['language'][$current_language]['description'])
        {{ @$content['language'][$current_language]['description'] }}
    @endif
@endforeach
