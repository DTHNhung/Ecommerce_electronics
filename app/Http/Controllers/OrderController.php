<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Notifications\UpdateOrderStatus;
use App\Http\Requests\Order\StoreRequest;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\Order\OrderRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Voucher\VoucherRepositoryInterface;
use App\Repositories\Shipping\ShippingRepositoryInterface;
use App\Repositories\OrderStatus\OrderStatusRepositoryInterface;
use App\Repositories\OrderProduct\OrderProductRepositoryInterface;

class OrderController extends Controller
{
    protected $productRepo;
    protected $voucherRepo;
    protected $orderRepo;
    protected $shippingRepo;
    protected $orderProductRepo;
    protected $orderStatusRepo;
    protected $userRepo;


    public function __construct(
        ProductRepositoryInterface $productRepo,
        VoucherRepositoryInterface $voucherRepo,
        OrderRepositoryInterface $orderRepo,
        ShippingRepositoryInterface $shippingRepo,
        OrderProductRepositoryInterface $orderProductRepo,
        OrderStatusRepositoryInterface $orderStatusRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->productRepo = $productRepo;
        $this->voucherRepo = $voucherRepo;
        $this->orderRepo = $orderRepo;
        $this->shippingRepo = $shippingRepo;
        $this->orderProductRepo = $orderProductRepo;
        $this->orderStatusRepo = $orderStatusRepo;
        $this->userRepo = $userRepo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepo->getAll();
        $order_status = $this->orderStatusRepo->getAll();

        return view('admin.order.index', [
            'orders' => $orders,
            'order_status' => $order_status,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        if (Session::has('cart')) {
            $order_status = config('app.startOrderStatus');
            $code = Str::random(config('app.limitRandomString'));
            $data = Session::get('data');
            $carts = session()->get('cart');
            $order_product = [];

            if (!isset($data['voucher'])) {
                $voucher_id  = null;
            } else {
                $voucher_id  = $data['voucher']->id;
                $quantity = ['quantity' => $data['voucher']->quantity - 1];
                $this->voucherRepo->update($voucher_id, $quantity);
            }

            $sum_price = Session::get('subTotal');
            $dataShipping = $request->all();
            $shipping = $this->shippingRepo->create($dataShipping);
            $dataOrder = [
                'user_id' => $request->user_id,
                'order_status_id' => $order_status,
                'code' => $code,
                'sum_price' => $sum_price,
                'shipping_id' => $shipping->id,
                'voucher_id' => $voucher_id,
            ];

            $orders = $this->orderRepo->create($dataOrder);
            foreach ($carts as $key => $cart) {
                $prd = $this->productRepo->find($key);
                if ($prd['quantity'] >= $cart['quantity']) {
                    $order_product[$key] = [
                        'order_id' => $orders->id,
                        'product_id' => $key,
                        'product_sales_quantity' => $cart['quantity'],
                    ];
                } else {
                    session()->forget('cart');
                    session()->forget('data');
                    session()->forget('subTotal');
                    $orders->delete();
                    $shipping->delete();

                    return back()->with([
                        'mess', __('messages.error')
                    ]);
                }
            }
            $this->orderProductRepo->insertOrderProduct($order_product);

            session()->forget('cart');
            session()->forget('data');
            session()->forget('subTotal');

            return view('user.checkout.order_complete');
        }

        return back()->with([
            'mess', __('messages.cart-empty')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = $this->orderRepo->find($id);
        $order_status = $this->orderStatusRepo->getAll();

        return view('admin.order.show')
            ->with(compact('order', 'order_status'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $order = $this->orderRepo->find($request->order_id);
        $order_status = $this->orderStatusRepo->getAll();

        foreach ($order_status as $s) {
            if ($s->id == $order->order_status_id) {
                $status_01 =[
                    'id' => $s->id,
                    'name' => $s->name
                ];
            }
            if ($s->id == $order->order_status_id + 1) {
                $status_02 =[
                    'id' => $s->id,
                    'name' => $s->name
                ];
            }
        }

        if ($order) {
            return response()->json([
                'code' => 200,
                'order' => $order,
                'status_01' => $status_01,
                'status_02' => $status_02,
            ], 200);
        }

        return response()->json([
            'message' => __('messages.No Results Found'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $order = $this->orderRepo->find($request->order_id);
        $order_status_id = $request->order_status_id;

        if ($order->order_status_id != $order_status_id) {
            if ($order_status_id == config('app.processing')) {
                foreach ($order->products as $key => $product) {
                    $product->pivot->product_sales_quantity;
                    $this->productRepo->decrementQuantityProduct($product->id, $product->pivot->product_sales_quantity);
                    $this->productRepo->incrementSoldProduct($product->id, $product->pivot->product_sales_quantity);
                }
            } 

            $order->update([
                'order_status_id' => $request->order_status_id,
            ]);
            $eventNotify = new UpdateOrderStatus($order);
            $this->userRepo->sendNotify($order->user_id, $eventNotify);
        }

        return response()->json([
            'code' => 200,
            'message' => __('messages.update-success', ['name' => __('titles.order')]),
        ], 200);
    }

    public function infoCheckout()
    {
        $carts = [];
        $discount = 0;
        $percent = 0;

        if (Session::has('data')) {
            $data = session()->get('data');
            $carts = $data['carts'];
            $discount = $data['discount'];
            $percent = $data['percent'];
            session()->put('cart', $carts);
        }

        return view('user.checkout.checkout', [
            'carts' => $carts,
            'discount' => $discount,
            'percent' => $percent,
        ]);
    }
}
