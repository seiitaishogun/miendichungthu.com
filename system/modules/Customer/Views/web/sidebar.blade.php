<div class="col-md-3 ptb-15">
    <div class="account-wrap cart-box">
        <h4 class="text-center account-title">{{ trans('custom.shop.customer') }}</h4>

        <div class="sidebar-item">
            <a href="{{ route('customer.profile') }}">
                {{ trans('custom.shop.profile') }}
            </a>
        </div>
        <div class="sidebar-item">
            <a href="{{ route('customer.password') }}">
                {{ trans('custom.shop.change_password') }}
            </a>
        </div>
        @if(config('cnv.cart_has_affiliate') && auth()->guard('customer')->check() && auth()->guard('customer')->user()->affiliate)
        <div class="sidebar-item">
            <a href="{{ route('customer.affiliate') }}">
                {{ trans('customer::language.affiliate') }}
            </a>
        </div>
        @endif
        <div class="sidebar-item">
            <a href="/logout">
                {{ trans('custom.shop.logout') }}
            </a>
        </div>
    </div>
</div>
