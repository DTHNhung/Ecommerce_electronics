<?php

namespace App\Http\Controllers;

use App\Repositories\Brand\BrandRepositoryInterface;
use App\Repositories\Comment\CommentRepositoryInterface;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    protected $brandRepo;
    protected $productRepo;
    protected $cmtRepo;
    protected $userRepo;

    public function __construct(
        BrandRepositoryInterface $brandRepo,
        ProductRepositoryInterface $productRepo,
        CommentRepositoryInterface $cmtRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->brandRepo = $brandRepo;
        $this->productRepo = $productRepo;
        $this->cmtRepo = $cmtRepo;
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        $brands = $this->brandRepo->getBrands();
        $products = $this->productRepo->getProduct();

        return view('shop', [
            'brands' => $brands,
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        $product = $this->productRepo->findBySlug($slug);
        $comments = $this->cmtRepo->getAll();
        $allowComment = false;
        if (Auth::check()) {
            $user = $this->userRepo->getUserByOrderConfirmed(Auth::user()->id);
            foreach ($user->orders as $order) {
                foreach ($order->products as $p) {
                    if ($p->slug == $slug) {
                        $allowComment = true;
                        foreach ($comments as $comment) {
                            if ($comment['product_id'] == $p->id && $comment['user_id'] == Auth::user()->id) {
                                $allowComment = false;
                                break;
                            }
                        }
                    }
                }
            }
        }
        return view('show', compact('product', 'comments', 'allowComment'));
    }
}
