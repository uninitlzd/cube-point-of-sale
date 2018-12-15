<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductStockResource;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\ShopOutlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OutletProductStockController extends Controller
{
    public function show(ShopOutlet $outlet, Product $product)
    {

    }

    public function update(Request $request, ShopOutlet $outlet, Product $product)
    {
        if ($product->stockable) {

            $outlet->products()->sync([
                $product->id => [
                    'number_of_stock' => $request->get('number_of_stock'),
                    'updated_at' => now()
                ]
            ], false);

            $stock = $product->scopeStockOfOutlet($outlet->id)->first();

            return new ProductStockResource($stock);
        }
    }
}
