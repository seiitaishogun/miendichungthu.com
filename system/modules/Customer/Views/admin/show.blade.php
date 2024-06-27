<table class="table table-striped table-hovered">
    <tr>
        <td>{{ trans('customer::language.last_name') }}</td>
        <td>{{ $customer->first_name }}</td>
    </tr>
    <tr>
        <td>{{ trans('customer::language.first_name') }}</td>
        <td>{{ $customer->last_name }}</td>
    </tr>
    <tr>
        <td>{{ trans('customer::language.email') }}</td>
        <td>{{ $customer->email }}</td>
    </tr>
    @if(! $customer->addresses->isEmpty())
        @foreach($customer->addresses as $address)
            <tr>
                <td>{{ trans('customer::language.phone') }}</td>
                <td>{{ $address->phone ?: 'Cập nhật' }}</td>
            </tr>
            <tr>
                <td>Bệnh viện</td>
                <td>{{ $address->hospital ?: 'Cập nhật' }}</td>
            </tr>
            <tr>
                <td>Chuyên khoa</td>
                <td>{{ $address->specialists ?: 'Cập nhật' }}</td>
            </tr>
            <tr>
                <td>Ngành nghề</td>
                <td>{{ $address->job ?: 'Cập nhật' }}</td>
            </tr>

            <tr>
                <td>{{ trans('customer::language.province') }}</td>
                <td>{{ $address->province }}</td>
            </tr>
        @endforeach
    @endif

    @if(config('cnv.cart_has_affiliate') && $customer->affiliate)
        <tr>
            <td>{{ trans('customer::language.affiliate_link') }}</td>
            <td><a href="{{ $customer->affiliate_link }}" target="_blank">{{ $customer->affiliate_link }}</a></td>
        </tr>
        <tr>
            <td>{{ trans('customer::language.affiliate_order') }}</td>
            <td><a href="{{ admin_route('cart.order.index', ['affiliate' => $customer->affiliate_code]) }}" target="_blank">{{ $customer->affiliate_order }}</a></td>
        </tr>
        <tr>
            <td>{{ trans('customer::language.affiliate_order_cost') }}</td>
            <td>{{ price_format($customer->affiliate_order_cost ?: 0) }}</td>
        </tr>
        <tr>
            <td>{{ trans('customer::language.affiliate_total_cost') }}</td>
            <td>{{ price_format($customer->affiliate_total_cost ?: 0) }}</td>
        </tr>
    @endif

</table>
