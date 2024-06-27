{{--  @foreach($widget->content->sortBy('position') as $content)
	<li>
		<a href="{{ @$content['link'] }}"><img alt="" src="{{ @$content['language'][$current_language]['picture'] }}"></a>
	</li>
@endforeach  --}}

<div class="container">
	<h1 class="title" style="font-size: 24px;
font-weight: 700;
text-align: center;
margin-bottom: 20px;">
		 LIÊN KẾT
	</h1>
	<div class="partner-cas text-center">
		@foreach($widget->content[$current_language] as $content)
			<div class="slick-slide">
				<a  href="{{ @$content['link'] }}" style="margin: auto;display: inline-block;">
					<img src="{{ @$content['picture'] }}" alt="">
				</a>
			</div>
		@endforeach
	</div>
</div>
