<?php

namespace App\Http\Controllers\Api;

use App\Events\ProductCreated;
use App\Filters\FiltersDiscountedProduct;
use App\Helpers\FileHelper;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
            ->allowedFilters(Filter::custom('discounted', FiltersDiscountedProduct::class))
            ->get();

        return ProductResource::collection($result->load('discounts'));
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(StoreProductRequest $request)
    {
        $shop = $this->user->shop;
        $product = new Product($request->all());
        $product->fill([
            'image' => FileHelper::saveImage($request->file('image'), 500, '/images/products/', time())
        ]);

        $product = $shop->products()->save($product);

        event(new ProductCreated($product));

        return new ProductResource($product);
    }

    // Todo: Create Request Object for Product Update
    public function update(StoreProductRequest $request, Product $product)
    {
        $product = tap($product)->update($request->all())->fresh();
        return new ProductResource($product);
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
