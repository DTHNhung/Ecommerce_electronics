@extends('admin.admin_layout')
@section('admin_content')
<h4 class="page-title">{{ __('titles.order') }}</h4>
<div class="panel panel-default">
    <div class="row">
        <div class="table-responsive">
            @php
                $mess = Session::get('mess');
            @endphp
            @if ($mess)
                <span class="text-alert">{{ $mess }}
                </span>
                <br><br>
                @php
                    Session::put('mess', null);
                @endphp
            @endif
            <table class="table table-hover" id="orders_table">
                <thead>
                    <tr>
                        <th class="width-css">
                        </th>
                        <th>{{ __('titles.order_id') }}</th>
                        <th>{{ __('titles.order_date') }}</th>
                        <th>{{ __('titles.total') }}</th>
                        <th>{{ __('titles.status') }}</th>
                        <th class="width-css">{{ __('titles.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>
                                <p class="stt">
                                    #{{ $order->code }}</p>
                            </td>
                            <td>
                                {{ formatDate($order->created_at) }}
                            </td>
                            <td>
                                {{ vndFormat($order->sum_price) }}
                            </td>
                            <td>
                                @switch($order->orderStatus->id)
                                    @case(1)
                                        <span class="text-warning stt-waiting">
                                            {{ __('messages.waiting') }}
                                        </span>
                                    @break

                                    @case(2)
                                        <span class="text-info stt-processing">
                                            {{ __('messages.processing') }}
                                        </span>
                                    @break
                                    
                                    @case(3)
                                    <span class="text-primary stt-primary">
                                        {{ __('messages.shipped') }}
                                    </span>
                                    @break

                                    @case(4)
                                        <span class="text-success stt-success">
                                            {{ __('messages.delivered') }}
                                        </span>
                                    @break

                                    @case(5)
                                        <span class="text-danger stt-danger">
                                            {{ __('messages.canceled') }}
                                        </span>
                                    @break
                                @endswitch
                            </td>
                            <td>
                                <a href="{{ route('orders.edit', ['order' => $order->id]) }}"
                                    class="active styling-edit"
                                    ui-toggle-class="">
                                    <i class="fas fa-edit text-gray"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
@section('dataTable')
    <script>
        $(function() {
            $("#orders_table").DataTable();
        });
    </script>
@endsection
