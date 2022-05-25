@extends('layouts.app')

@section('content')
    <!-- breadcrum -->
    <div class="py-4 container flex gap-3 items-center m-auto">
        <a href="{{ route('home') }}" class="text-indigo-900 text-base">
            <i class="fas fa-home"></i>
        </a>
        <span class="text-sm text-gray-400">
            <i class="fas fa-chevron-right"></i>
        </span>
        <a href="{{ route('shop') }}"
            class="text-indigo-900 text-base font-medium uppercase">
            {{ __('titles.Shop') }}
        </a>
        <span class="text-sm text-gray-400">
            <i class="fas fa-chevron-right"></i>
        </span>
        <p class="text-gray-600 font-mono font-semibold uppercase">
            {{ $product->name }}
        </p>
    </div>
    <!-- breadcrum end -->

    <!-- product view -->
    <div class=" bg-white shadow rounded px-8 mt-6 container pt-4 pb-6 grid lg:grid-cols-2 gap-6 m-auto">
        <!-- product image -->
        <div>
            <div>
                <img id="main-img"
                    src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                    class=" w-2/3 h-2/3 mx-auto">
            </div>
            <div class="grid grid-cols-5 gap-4 mt-4">
                @foreach ($product->images as $image)
                    <div>
                        <img src="{{ asset('images/uploads/products/' . $image->image) }}"
                            class="single-img w-20 h-20 cursor-pointer border border-indigo-900">
                    </div>
                @endforeach
            </div>
        </div>
        <!-- product image end -->
        <!-- product content -->
        <div class="ml-6">
            <h2 class="md:text-3xl text-2xl font-mono font-medium uppercase mb-4 mt-5">
                {{ $product->name }}
            </h2>
            <div class="flex items-center mb-6">
                <div class="flex gap-1 text-sm text-yellow-400">
                    <input type="hidden" id="prd-rate" value="{{ $product->avg_rating }}">
                    <div id="rateYoP" class="pb-1"></div>
                </div>
                <div class="text-xs text-gray-500 ml-3">
                    <a href="#comments" class="text-decoration-none">
                        {{ (number_format($product->avg_rating, 1, '.', ',') . ' ' . __('titles.Reviews')) }}
                    </a>
                </div>
            </div>
            <div class="space-y-4 mb-3">
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">
                        {{ __('titles.Brand') }}:
                    </span>
                    <span class="text-gray-600">
                        {{ $product->brand->name }}
                    </span>
                </p>
            </div>
            <div class="space-y-4">
                <p class="space-x-2">
                    <span class="text-gray-800 font-semibold">
                        {{ __('titles.Category') }}:
                    </span>
                    <span class="text-gray-600">
                        @foreach ($product->category as $category)
                            {{ $category->name }} |
                        @endforeach
                    </span>
                </p>
            </div>
            <div class="mt-10 flex items-baseline gap-5 bg-gray-50 py-8 pl-5">
                <span class="text-indigo-900 font-semibold text-3xl">
                    {{ vndFormat($product->price) }}
                    <input type="hidden" name="_token"
                        value="{{ csrf_token() }}">
                </span>
            </div>
            <!-- quantity -->
            <div class="mt-10">
                <h3 class="text-base text-gray-800 mb-1">
                    {{ __('titles.Quantity') }}
                </h3>
                <div
                    class="flex border border-gray-300 text-gray-600 divide-x divide-gray-300 w-max-content absolute">
                    <button id="decrement_{{ $product->id }}"
                        onclick="stepper('decrement_{{ $product->id }}')"
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">-</button>
                    <input id="input-number_{{ $product->id }}" type="number"
                        min="1" max="{{ $product->quantity }}" readonly value="1"
                        class="appearance-none h-8 w-15 flex items-center justify-center cursor-not-allowed text-center">
                    <button id="increment_{{ $product->id }}"
                        onclick="stepper('increment_{{ $product->id }}')"
                        class="h-8 w-8 text-xl flex items-center justify-center cursor-pointer hover:bg-indigo-900 hover:text-white select-none">+</button>
                </div>
                <div class="text-gray-400 ml-36 pt-2">
                    {{ $product->quantity . __('titles.piece available') }}
                </div>
            </div>
            <!-- {{ __('titles.Add to Cart') }} button -->
            <div class="flex gap-3 border-b border-gray-200 pb-5 mt-10">
                <a href="{{ route('carts.index') }}"
                    data-id="{{ $product->id }}"
                    data-url="{{ route('addMoreProduct', ['id' => $product->id]) }}"
                    class="bg-indigo-900 border border-indigo-900 text-white px-8 py-2 font-medium rounded uppercase 
                    hover:bg-transparent hover:text-indigo-900 transition text-sm flex items-center add_quantity">
                    <span class="mr-2"><i
                            class="fas fa-shopping-bag"></i></span>
                    {{ __('titles.Buy now') }}
                </a>
                <a href="#"
                    class="bg-indigo-900 border border-indigo-900 text-white px-8 py-2 font-medium rounded uppercase 
                    hover:bg-transparent hover:text-indigo-900 transition text-sm flex items-center add_more_product"
                    data-url="{{ route('addMoreProduct', ['id' => $product->id]) }}"
                    data-id="{{ $product->id }}">
                    <span class="mr-2"><i
                            class="fa-solid fa-cart-shopping"></i></span>
                    {{ __('titles.Add to Cart') }}
                </a>
                <a href="#"
                    class="border border-gray-300 text-gray-600 px-8 py-2 font-medium rounded uppercase 
                    hover:bg-transparent hover:text-indigo-900 transition text-sm">
                    <span class="mr-2"><i
                            class="far fa-heart"></i></span>
                    {{ __('titles.Wishlist') }}
                </a>
            </div>
            <!-- {{ __('titles.Add to Cart') }} button end -->
            <!-- product share icons -->
            <div class="flex space-x-3 mt-6">
                <span
                    class="text-gray-500 mr-3 flex items-center justify-center">{{ __('titles.Share') }}:</span>
                <a href="#"
                    class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#"
                    class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#"
                    class="text-gray-400 hover:text-gray-500 h-8 w-8 rounded-full border border-gray-300 flex items-center justify-center">
                    <i class="fab fa-instagram"></i>
                </a>
            </div>
            <!-- product share icons end -->
        </div>
        <!-- product content end -->
    </div>
    <!-- product view end -->

    <!-- product details and review -->
    <div class=" bg-white shadow rounded px-8 pt-5 container pb-16 mx-auto mt-5">
        <!-- detail buttons -->
        <h3
            class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium text-xl uppercase">
            {{ __('titles.Product Details') }}
        </h3>
        <!-- details button end -->

        <!-- details content -->
        <div class="lg:w-4/5 xl:w-3/5 pt-8">
            <div class="space-y-5 text-gray-600 text-lg font-serif">
                <fieldset class=" leading-8 tracking-normal">
                    {!! $product->description !!}
                </fieldset>
            </div>
        </div>
        <!-- details content end -->
    </div>
    <!-- review comment and rating -->
    
    <div id="comments" class=" bg-white shadow rounded px-8 pt-5 container pb-16 mx-auto my-5">
        @php
            $count = 0;
            foreach($product->comments as $comment) {
                $count++;
            }
        @endphp
        <h3 
            class="border-b border-gray-200 font-roboto text-gray-800 pb-3 font-medium text-xl uppercase">
            {{ __('titles.comments') }} ({{ $count }})
        </h3>
        @if ($count == 0)
            <p class="italic mt-5">{{ __('messages.no-comment') }}</p>
        @endif
        @foreach ($product->comments as $comment)
            <div class="row mt-5">
                <div class="text-black antialiased flex">
                    @if ($comment->user->avatar != null)
                        <img class="rounded-full h-15 w-15 mx-4" src="{{ asset('avatars/' . $comment->user->avatar ) }}" alt="">
                    @else
                        <img class="rounded-full h-15 w-15 mx-4" src="{{ asset('images/user.png') }}" alt="">
                    @endif
                    <div class="w-80">
                        <div class="bg-gray-100 rounded-lg px-5 py-2">
                            <b>{{ $comment->user->name }}</b>   
                            <div class="rating my-2">
                                <p class="inline-block text-sm"> {{ $comment->content }}</p>
                                <div class="flex float-right">
                                    @php $rating = $comment->rating; @endphp
                                    @foreach (range(1, 5) as $i)
                                        @if ($rating > 0)
                                            @if ($rating > 0.5)
                                                <span class="fa-solid fa-star checked"></span>
                                            @else
                                                <span class="fa-solid fa-star-half-stroke checked"></span>
                                            @endif
                                        @else
                                            <span class="fa-regular fa-star checked"></span>
                                        @endif
                                        @php $rating--; @endphp
                                    @endforeach
                                </div>
                            </div>
                            @if (Auth::check())
                                @if ($comment->user_id == Auth::user()->id)
                                    <form class="ms-5" action="{{ route('comment.destroy', $comment->id) }}" method="POST">
                                        <small><button type="button" class="focus:outline-none focus:shadow-none hover:text-blue-400" id="btn-edit-cmt">{{ __('titles.edit') }}</button></small>
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $comment->id }}">
                                        <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                                        <small class="px-1">|</small>
                                        <small><button type="submit" id="btn-del" class="btn-delete focus:outline-none focus:shadow-none hover:text-blue-400" data-confirm="{{ __('messages.delete-confirm') }}">{{ __('titles.delete') }}</button></small>
                                    </form>
                                    <form method="POST" id="form-edit-cmt" class="visually-hidden" action="{{ route('comment.update', $comment->id) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="id" value="{{ $comment->id }}">
                                        <input type="hidden" name="product_slug" value="{{ $product->slug }}">
                                        <div class="relative flex mt-2">
                                            <input type="text" name="content" 
                                                class="bg-white w-full py-2 pl-4 pr-10 text-sm border border-transparent appearance-none rounded-tg placeholder-gray-500"
                                                style="border-radius: 25px"
                                                value="{{ $comment->content }}">
                                            <button type="submit" id="btn-comment" class="absolute inset-y-0 right-0 flex items-center py-2 pr-4 focus:outline-none focus:shadow-none hover:text-blue-400">
                                                <svg class="ml-1" viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                            </button>
                                        </div>
                                        
                                    </form>
                                    @error('content')
                                        <div class="text-red-500 italic">{{ $message }}</div>
                                    @enderror
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        
        @if ($allowComment)
            <div class="row mt-5">
                <div class="text-black antialiased flex">
                    @if (Auth::user()->avatar != null)
                        <img class="rounded-full h-15 w-15 mx-4" src="{{ asset('avatars/' . $user->avatar ) }}" alt="">
                    @else
                        <img class="rounded-full h-15 w-15 mx-4" src="{{ asset('images/user.png') }}" alt="">
                    @endif
                    <div class="w-80">
                        <div class="bg-gray-100 rounded-lg px-5 py-2">
                            <b class="text-sm">{{ Auth::user()->name }}</b>
                            <form action="{{ route('comment', $product->slug) }}" id="form-cmt" method="POST" role="form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="rating" id="rating" value="" />
                                <div class="my-2" id="rateYo"></div>
                                <div class="flex">
                                    <input type="text" name="content" class="bg-white w-full py-2 px-4 text-sm border border-transparent appearance-none rounded-tg placeholder-gray-500" style="border-radius: 25px" placeholder="{{ __('messages.enter-comment') }}">
                                    <button type="submit" id="btn-comment" class="flex items-center py-2 px-4 ml-1 rounded-lg text-sm bg-blue-600 text-white shadow-lg">{{ __('titles.post-comment') }}
                                        <svg class="ml-1" viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                                    </button>
                                </div>
                                @error('content')
                                    <div class="text-red-500 italic">{{ $message }}</div>
                                @enderror
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <!-- review comment and rating end-->
    <!-- product details and review end -->

    <div id="also_like" class="uppercase text-xl text-gray-600 pt-5 container pb-5 mx-auto">
        <h3>
            {{ __('titles.also-like') }}
        </h3>
    </div>
    <!-- product wrapper -->
    <div class="container grid lg:grid-cols-4 sm:grid-cols-2 gap-6 mx-auto mb-5">
        @foreach ($pCategory->childCategories as $category)
            @foreach ($category->products as $product)
                <div class="button-product rounded bg-white shadow-2xl overflow-hidden">
                    <div class="relative">
                        <img src="{{ asset('images/uploads/products/' . $product->image_thumbnail) }}"
                            class="img-product">
                        <div class="product absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center gap-2 opacity-0 transition">
                            <a href="{{ route('show', $product->slug) }}"
                                class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                <i class="fas fa-search"></i>
                            </a>
                            <a href="#"
                                class="text-white text-lg w-9 h-9 rounded-full bg-indigo-900 hover:bg-gray-800 transition flex items-center justify-center">
                                <i class="far fa-heart"></i>
                            </a>
                        </div>
                    </div>
                    <div class="pt-4 pb-3 px-4">
                        <a href="{{ route('show', $product->slug) }}">
                            <h4
                                class="h-14 font-mono uppercase font-semibold text-lg mb-2 text-gray-800 hover:text-indigo-900 transition">
                                {{ $product->name }}
                            </h4>
                        </a>
                        <div class="flex items-baseline mb-1 space-x-2">
                            <p
                                class="text-lg text-indigo-900 font-roboto font-semibold">
                                {{ vndFormat($product->price) }}
                                <input type="hidden" name="_token"
                                    value={{ csrf_token() }}>
                            </p>
                        </div>
                        <div class="flex items-center">
                            <div class="flex gap-1">
                                @php $rating = $product->avg_rating; @endphp
                                @foreach (range(1, 5) as $i)
                                    @if ($rating > 0)
                                        @if ($rating > 0.5)
                                            <small class="fa-solid fa-star checked"></small>
                                        @else
                                            <small class="fa-solid fa-star-half-stroke checked"></small>
                                        @endif
                                    @else
                                        <small class="fa-regular fa-star checked"></small>
                                    @endif
                                    @php $rating--; @endphp
                                @endforeach
                            </div>
                            <div class="text-xs text-gray-500 ml-3">({{ number_format($product->avg_rating, 1, '.', ',') }})</div>
                        </div>
                    </div>
                    <a href="#"
                        data-url="{{ route('addToCart', ['id' => $product->id]) }}"
                        class="block w-full py-1 text-center text-white bg-indigo-900 border border-indigo-900 rounded-b hover:bg-transparent hover:text-indigo-900 transition add_to_cart">
                        {{ __('titles.Add to Cart') }}
                    </a>
                </div>
            @endforeach
        @endforeach
    </div>
</div>

    <!-- product wrapper end -->
@endsection
