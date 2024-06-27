@extends('theme::layout')

@push('header')
<style>
    .box-count {
        border: 1px solid #efefef;
        margin: 10px 0;
    }

    .box-count h4 {
        color: white;
        background-color: #3498db;
        margin: 0;
        padding: 5px;
        text-align: center;
        font-size: 13px;
    }

    .box-count p {
        text-align: center;
        color: #3498db;
        font-weight: bolder;
        margin: 10px;
        font-size: 30px;
    }
</style>
@endpush

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <section class="col-md-8 ptb-15">
                    <div>
                        <h4 class="text-center">{{ $title }}</h4>

                        @include('customer::web.message')

                        <div class="row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" value="{{ $user->affiliate_link }}" disabled>
                            </div>
                            <div class="col-md-4">
                                <div class="box-count">
                                    <h4>{{ trans('customer::language.affiliate_order') }}</h4>
                                    <p>{{ number_format($user->affiliate_order) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="box-count">
                                    <h4>{{ trans('customer::language.affiliate_order_cost') }}</h4>
                                    <p>{{ price_format($user->affiliate_order_cost ?: 0) }}</p>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="box-count">
                                    <h4>{{ trans('customer::language.affiliate_total_cost') }}</h4>
                                    <p>{{ price_format($user->affiliate_total_cost ?: 0) }}</p>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('customer::language.account') }}</th>
                                            <th>{{ trans('product::language.price') }}</th>
                                            <th>{{ trans('language.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($orders as $order)
                                            <tr>
                                                <td>#{{ $order->code }}</td>
                                                <td>{{ $order->customer->full_name }}</td>
                                                <td>{{ price_format($order->latest_price) }}</td>
                                                <td>{{ $order->created_at->format('d/m/y') }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>

                @include('customer::web.sidebar')
            </div>
        </div>
    </section>
@stop
