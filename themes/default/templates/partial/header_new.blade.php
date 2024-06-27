<header>
        <div class="container">
            <div class="top">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xl-auto col-9">
                        <a class="logo" href="/" title="">
                            <img src="{{ get_option('site_logo') }}" alt="" title=""/>
                        </a>
                    </div>
                    <div class="col-xl-auto d-none d-xl-block">
                        <form class="search-fr" method="GET" action="/blogs/search">
                            <input name="q" required type="text" placeholder="Tìm kiếm ...">
                            <button type="submit"><img src="/themes/default/assets/images/search.png" alt="" title="" /></button>
                        </form>
                    </div>
                    <div class="col-xl-auto col-3  text-right">
                        @if(Auth::guard('customer')->check())
                            <a class="smooth  h-account" href="javascript:void(0)" title=""><img src="/themes/default/assets/images/user.png" alt="" title="" /> Hi, {{ Auth::guard('customer')->user()->first_name.' '.Auth::guard('customer')->user()->last_name }} !</a> <span class="d-none-xs">/</span> <a class="d-none-xs exit_mobile" href="javascript:void(0)"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ session('lang') == 'vi' ? 'Thoát' : 'Logout' }}</a>
                            {{-- Form Logout --}}
                            <form id="logout-form" action="{{ route('customer.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            {{-- End Form Logout --}}
                        @else
                             <a class="smooth h-register h-login" href="/login" title="">
                                <img src="{{ $theme_url }}/assets/images/icon_dangnhap.png" alt="">
                             </a>
                            <a class="smooth h-register" href="/register" title="">Tài liệu thông tin thuốc</a>
                        @endif
                        <button class="menu-btn m-nav-open" type="button"><i></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="header">
                <nav class="main-nav">
                    <ul>
                        @foreach(cnv_menu('main-menu') as $item)
                            <li>
                                <a class="smooth" href="{{ Auth::guard('customer')->check() ? ( @$item->attributes['url'] == '#' ? 'javascript:void(0);' :  @$item->attributes['url'] ) : '/register'  }}" title="">
                                    {{ $item->language('name') }}
                                </a>
                                @if($item->children->count())
                                    <ul>
                                        @foreach($item->children->sortBy('position') as $item_child)
                                            <li><a class="smooth" href="{{ Auth::guard('customer')->check() ? ( @$item_child->attributes['url'] == '#' ? 'javascript:void(0);' :  @$item_child->attributes['url'] ) : '/register' }}" title="">
                                                <span><img src="{{ @$item_child->attributes['icon'] }}" alt="" title="" /></span> {{ $item_child->language('name') }}
                                            </a></li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
            </div>
        </div>
    </header>
