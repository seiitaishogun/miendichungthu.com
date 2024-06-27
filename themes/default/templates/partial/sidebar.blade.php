@push('footer')
<script>
    $(document).ready(function(){
        $('.cate-box > ul > li span.dropdown-arrow').each(function(){
            $(this).click(function(){
                $(this).parent().children('.sub-cate').slideToggle();
            });
        });
    });
</script>
@endpush

<div class="col-md-4">
    <div class="sidebar">

        <div class="bor-box cate-box">
            <h2 class="i-title">@if(session('lang') == 'vi') DANH MỤC @else Category @endif</h2>
            <ul>
                @foreach(get_list_posts(-1,1) as $post)
                <li class="cat_{{$post->id}}">
                    <a id="post_{{$post->id}}" class="smooth" href="{{ $post->language('link') }}" title="">{{ $post->language('name') }}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
