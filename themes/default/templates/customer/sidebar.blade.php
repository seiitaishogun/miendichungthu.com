<div class="col-md-3 ptb-15">
    <div class="account-wrap cart-box">
        <h4 class="text-center caption">{{ trans('custom.shop.customer') }}</h4>
        <div class="sidebar-item">
            <a href="{{ route('customer.profile') }}">
                <i class="fa fa-arrow-circle-o-right"></i>
                {{ trans('custom.shop.profile') }}
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('customer.password') }}">
                <i class="fa fa-arrow-circle-o-right"></i>
                {{ trans('custom.shop.change_password') }}
            </a>
        </div>
        @if(config('cnv.cart_has_affiliate') && auth()->guard('customer')->check() && auth()->guard('customer')->user()->affiliate)
        <div class="sidebar-item">
            <a href="{{ route('customer.affiliate') }}">
                <i class="fa fa-arrow-circle-o-right"></i>
                {{ trans('customer::language.affiliate') }}
            </a>
        </div>
        @endif
        <div class="sidebar-item">
            <a href="{{ route('customer.logout') }}">
                <i class="fa fa-arrow-circle-o-right"></i>
                {{ trans('custom.shop.logout') }}
            </a>
        </div>
    </div>
</div>
