@extends('admin.admin_layout')
@section('admin_content')
    <h4 class="page-title">{{ __('titles.order-details') }}</h4>

    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <h5 class="title-order">
                    {{ __('titles.shipping-info') }}
                </h5>

                <span class="span-title">{{ $order->shipping->name }}</span>
                <br />
                <div class="text-content-info">
                    <p>
                        <span class="span-title">{{ __('titles.address') }}</span>:
                        {{ $order->shipping->address }}
                    </p>
                    <p>
                        <span class="span-title">{{ __('titles.phone') }}</span>:
                        {{ $order->shipping->phone }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-default">
                <h5 class="title-order">
                    {{ __('titles.bing-info') }}
                </h5>
                <div class="text-content-info">
                    <p><span class="span-title">Payment Type</span>: Credit Card</p>
                    <p><span class="span-title">Provider</span>: Visa ending in 2851</p>
                    <p><span class="span-title">Valid Date</span>: 02/2020</p>
                    <p><span class="span-title">CVV</span>: xxx</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-default">
                <h5 class="title-order">
                    {{ __('titles.delivery-info') }}
                </h5>

                <div class="delivery text-content-info">
                    <i class="fa-solid fa-truck"></i>
                    <p><span class="span-title">UPS Delivery</span></p>
                    <p><span class="span-title">Order ID</span> : #{{ $order->code }}</p>
                    <p><span class="span-title">Payment Mode</span> : COD</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="panel panel-default">
                <h5 class="title-order">
                    {{ __('titles.items-from-order') . ' #' . $order->code }}
                </h5>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('titles.item') }}</th>
                            <th>{{ __('titles.quantity') }}</th>
                            <th>{{ __('titles.price') }}</th>
                            <th>{{ __('titles.total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>
                                    {{ $product->pivot->product_sales_quantity }}
                                </td>
                                <td>
                                    {{ vndFormat($product->price) }}
                                </td>
                                <td>
                                    {{ vndFormat($product->pivot->product_sales_quantity * $product->price) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-default">
                <h5 class="title-order">
                    {{ __('titles.order-summary') }}
                </h5>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ __('titles.description') }}</th>
                            <th>{{ __('titles.price') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ __('titles.Subtotal') }}</td>
                            <td>{{ vndFormat($order->sum_price) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('titles.Delivery') }}</td>
                            <td>{{ __('titles.Free') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('titles.discount') }}</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <th>{{ __('titles.total') }}</th>
                            <th>{{ vndFormat($order->sum_price) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
