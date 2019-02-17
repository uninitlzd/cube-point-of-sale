<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UpdateShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\CustomerType;
use App\Models\Member;
use App\Models\Role;
use App\Models\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Claims\Custom;

class ShopController extends Controller
{
    private $shop;
    private $user;
    public function __construct()
    {
        $this->shop = new Shop();
        $this->user = auth('api')->user();
    }

    public function index()
    {
        return new ShopResource($this->user->shop);
    }

    public function save(UpdateShopRequest $request)
    {
        $shop = $this->user->shop ?: new Shop;
        $shop->name = $request->get('name');
        $shop->type = $request->get('type');
        $shop->tax = $request->get('tax');

        $shop = $this->user->shop()->save($shop);

        // Update Owner shop_id
        $this->user->roles()->updateExistingPivot(1, [
            'shop_id' => $shop->id
        ]);

        CustomerType::create([
            "shop_id" => $shop->id,
            "name" => "Regular",
            "discount_percentage" => 0
        ]);

        return new ShopResource($shop);
    }
}
