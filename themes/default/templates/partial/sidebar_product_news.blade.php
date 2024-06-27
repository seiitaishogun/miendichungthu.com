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
            <h2 class="i-title">@if(session('lang') == 'vi') Danh mục @else Category @endif</h2>
            <ul>
                @foreach(get_list_product_categories(0) as $category)
                <li class="@if(@$category_id == $category->id) active @endif"><a href="/collections?id={{ $category->id }}" title="">{{ $category->language('name') }}</a>
                    @if($category->children->count())
                    <span class="dropdown-arrow"><i class="fa fa-fw fa-angle-down"></i></span>
                    <ul class="sub-cate">
                        @foreach($category->children->sortByDesc('position') as $cate)
                        <li class="@if(@$category_id == $cate->id) active @endif"><a href="/collections?id={{ $cate->id }}" title="">{{ $cate->language('name') }}</a>
                            @if($cate->children->count())
                            <span class="dropdown-arrow"><i class="fa fa-fw fa-angle-down"></i></span>
                            <ul class="sub-cate">
                                @foreach($cate->children->sortByDesc('position') as $item)
                                <li class="@if(@$category_id == $item->id) active @endif"><a href="/collections?id={{ $item->id }}" title="">{{ $item->language('name') }}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

        <div class="bor-box post-box">
            <h2 class="i-title">@if(session('lang') == 'vi') Sản phẩm mới nhất @else Product New @endif</h2>
            @foreach(get_list_products(4,0) as $product)
            <div class="sb-post clearfix">
                <a class="img hv-scale hv-over cnv-img-new" href="{{ $product->language('link') }}" title="">
                    <img src="{{ @$product->thumbnail }}" alt="" title="" />
                </a>
                <h3 class="title"><a class="smooth" href="{{ $product->language('link') }}" title="">{{ $product->language('name') }}</a></h3>
            </div>
            @endforeach
        </div>
    </div>
</div>
