<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductImageController extends Controller
{
    public function update(Request $request, Product $product)
    {
        FileHelper::removeImage($product->image);

        return tap($product)->update([
            'image' => FileHelper::saveImage($request->file('image'), 500, '/images/products/', time())
        ])->refresh();
    }
}
