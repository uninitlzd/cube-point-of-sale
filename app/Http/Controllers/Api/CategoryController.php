<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    private $shop;
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index()
    {

        if ($this->user->isOwner()) {
            $categories = $this->user->shop->categories;
        } else {
            $shop = Shop::find($this->user->role()->pivot->shop_id);
            $categories = $shop->categories;
        }

        return CategoryResource::collection($categories);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function store(StoreCategoryRequest $request)
    {
        $shop = $this->user->shop;
        $category = new Category($request->all());

        return new CategoryResource($shop->categories()->save($category));
    }

    public function update(Request $request, Category $category)
    {
        $category = tap($category)->update($request->all())->fresh();

        return new CategoryResource($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Category deleted'
        ]);
    }
}
