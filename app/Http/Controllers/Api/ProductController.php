<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductCreated;
use App\Filters\FiltersDiscountedProduct;
use App\Filters\FiltersDiscountIdOrNull;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Image;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductController extends Controller
{
    private $shop;
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index()
    {
        $products = Product::where('shop_id', $this->user->shop->id);

        $result = QueryBuilder::for($products)
            ->allowedIncludes('stocks')
            ->allowedFilters('name', Filter::custom('discount_id', FiltersDiscountIdOrNull::class), Filter::custom('discounted', FiltersDiscountedProduct::class))
            ->get();

        return ProductResource::collection($result->load('discount'));
    }

    public function show(Product $product)
    {
        $product = Product::where('id', $product->id);

        $result = QueryBuilder::for($product)
            ->allowedIncludes('stocks','stocks.outlet')
            ->first();


        return new ProductResource($result);
    }

    public function store(Request $request)
    {
        $shop = $this->user->shop;
        $product = new Product($request->all());
        $product->fill([
            'image' => FileHelper::saveBase64Image($request->image, 500, '/images/products/')
        ]);

        $product = $shop->products()->save($product);

        event(new ProductCreated($product));

        return new ProductResource($product);
    }

    // Todo: Create Request Object for Product Update
    public function update(Request $request, Product $product)
    {
        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
        ];

        if ($request->has('image'))
            if (!is_null($request->image))
                $data['image'] = FileHelper::saveBase64Image($request->image, 500, '/images/products/');

        $product = tap($product)->update($data)->fresh();
        return response()->json(new ProductResource($product));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Product deleted'
        ]);
    }
}
