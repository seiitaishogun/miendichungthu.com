<ul>
    @foreach($menus->orderBy('position') as $item)
        <li>
            <a href="{{ @$item->attributes['url'] == '#' ? 'javascript:void(0);' :  @$item->attributes['url'] }}" {!! @$item->attributes_html !!}>
                {{ @$item->language('name') }}
            </a>
            @if($item->children->count())
                @include('theme::partial.menu', ['menus' => $item->children])
            @endif
        </li>
    @endforeach
</ul>
