@extends('admin.admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ __('titles.all-brand') }}
            </div>
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
                <table class="table table-striped b-t b-light"
                    id="orders_cancel_table">
                    <thead>
                        <tr>
                            <th class="width-css">
                            </th>
                            <th>{{ __('titles.order') }}</th>
                            <th>{{ __('titles.status') }}</th>
                            <th class="width-css"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <p class="stt">
                                        {{ $order->code }}</p>
                                </td>
                                <td>
                                    @switch($order->orderStatus->id)
                                        @case(1)
                                            <span class="text-warning p-2 text-xs bg-orange-300">
                                                {{ __('messages.waiting') }}
                                            </span>
                                        @break

                                        @case(2)
                                            <span class=" text-purple-700 p-2 text-xs bg-purple-300">
                                                {{ __('messages.processing') }}
                                            </span>
                                        @break
                                        
                                        @case(3)
                                        <span class=" text-blue-700 p-2 text-xs bg-blue-300">
                                            {{ __('messages.shipped') }}
                                        </span>
                                        @break

                                        @case(4)
                                            <span class="text-success p-2 text-xs bg-green-300">
                                                {{ __('messages.delivered') }}
                                            </span>
                                        @break

                                        @case(5)
                                            <span class="text-danger p-2 text-xs bg-red-300">
                                                {{ __('messages.canceled') }}
                                            </span>
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{ route('viewCancelOrder', ['id' => $order->id]) }}"
                                        class="active styling-edit"
                                        ui-toggle-class="">
                                        <i
                                            class="fas fa-eye text-success text-active"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{ $orders->links() }}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
@section('dataTable')
    <script>
        $(function() {
            $("#orders_cancel_table").DataTable();
        });
    </script>
@endsection
