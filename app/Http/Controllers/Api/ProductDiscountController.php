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
        $productsId = $request->get('product_ids');

        // Unset discount id if product id not in array
        Product::where('discount_id', $discount->id)->whereNotIn('id', $productsId)
                    ->get()
                    ->map(function ($product) use ($discount) {
                        $product->discount_id = null;
                        $product->save();
                    });

        // Set discount id if product id is in array
        Product::whereIn('id', $productsId)
                ->get()
                ->map(function ($product) use ($discount) {
                    $product->discount_id = $discount->id;
                    $product->save();
                });

        return new DiscountResource($discount->load('products'));
    }
}
