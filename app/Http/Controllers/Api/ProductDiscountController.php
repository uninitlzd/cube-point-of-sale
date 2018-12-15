<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductDiscountController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function assignProducts(Request $request, Discount $discount)
    {
        $productsId = $request->get('products');
        $discount->products()->sync($productsId);

        return new DiscountResource($discount->load('products'));
    }
}
