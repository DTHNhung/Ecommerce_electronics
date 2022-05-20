@extends('user.profile.layouts.profile')
@section('content-profile')
    <!-- account content -->
    <div class="col-span-9">
        <div class="shadow-2xl rounded px-6 pt-5 pb-7 mt-6 lg:mt-0 bg-white">
            <h3
                class="text-lg font-medium capitalize mb-3 mx-6 pt-3.5 pb-8">
                {{ __('titles.your-order') }}: {{ $orders->total() }}
                {{ __('titles.order') }}
            </h3>
        </div>
    
        @foreach ($orders as $order)
        <div class="shadow-2xl rounded px-6 pt-5 pb-7 mt-6 bg-white">
            <div class="text-black flex items-center justify-end flex-grow border border-l-0 border-t-0 border-r-0 pb-3">
                <span class="bg-gray-100 px-2 py-1 rounded-full text-sm text-gray-700">
                @switch($order->orderStatus->id)
                    @case(1)
                        {{ __('messages.waiting') }}
                    @break

                    @case(2)
                        {{ __('messages.processing') }}
                    @break
                    
                    @case(3)
                        {{ __('messages.shipped') }}
                    @break

                    @case(4)
                        {{ __('messages.delivered') }}
                    @break

                    @case(5)
                        {{ __('messages.canceled') }}
                    @break
                @endswitch
                </span>
                <span class=" text-gray-500 mx-2">|</span>
                <span class="font-normal my-2 text-green-500">{{ formatDate($order->created_at) }}</span>
            </div>
            <div class="">
                @foreach ($order->products as $product)
                <div class="max-w-md mx-auto bg-white shadow-2xl-md overflow-hidden md:max-w-4xl border border-l-0 border-t-0 border-r-0 pb-3">
                    <div class="flex mt-3">
                        <a href="{{ route('show', ['product' => $product->slug]) }}">
                            <img class=" h-28 w-full object-cover md:h-full md:w-28 border-gray-300 border"
                                src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                                alt="Man looking at item at a store">
                        </a>
                        <a href="{{ route('viewDetailOrder', ['id' => $order->id]) }}">
                            <div class="p-8 flex mt-4">
                                <div
                                    class="font-mono uppercase tracking-wide text-sm text-indigo-500 font-semibold w-72">
                                    {{ $product->name }}
                                </div>
                                <div class="w-52 ml-10">
                                    Qty: x{{ $product->pivot->product_sales_quantity }}
                                </div>
                                <div class=" text-red-400 font-medium">
                                    {{ vndFormat($product->price) }}
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <div class="row">
                    <div class="col-sm-5 text-center">
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <h1 class="uppercase tracking-wide text-lg text-indigo-900 font-semibold mt-3">
                            {{ __('titles.Total') }}:
                            {{ vndFormat($order->sum_price) }}</h1>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-sm-5 text-center">
        </div>
        <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
            </ul>
        </div>
    </div>
    {{ $orders->links() }}
    <!-- account content end -->
@endsection
