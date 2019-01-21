<?php

namespace App\Http\Controllers\Api;

use App\Events\OutletCreated;
use App\Http\Resources\OutletResource;
use App\Models\Shop;
use App\Models\ShopOutlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class OutletController extends Controller
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
        if ($this->user->isOwner()) {
            $outlets = ShopOutlet::where('shop_id', $this->user->shop->id);
        } else {
            $outlets = ShopOutlet::where('shop_id', $this->user->role()->pivot->shop_id);
        }

        $outlets = QueryBuilder::for($outlets)
                    ->allowedFilters('name', 'address', Filter::exact('id'))
                    ->get();

        return OutletResource::collection($outlets);
    }

    public function show(ShopOutlet $outlet)
    {
        $outlet = ShopOutlet::where('id', $outlet->id);
        $outlet = QueryBuilder::for($outlet)
                    ->allowedIncludes('products')
                    ->first();

        return new OutletResource($outlet);
    }

    public function store(Request $request)
    {
        $shop = $this->user->shop;
        $outlet = new ShopOutlet($request->all());
        $outlet = $shop->outlets()->save($outlet);

        event(new OutletCreated($outlet));

        return new OutletResource($shop->outlets()->save($outlet));
    }

    public function update(Request $request, ShopOutlet $outlet)
    {
        $outlet = tap($outlet)->update($request->all())->fresh();
        return new OutletResource($outlet);
    }

    public function destroy(ShopOutlet $outlet)
    {
        try {
            $outlet->delete();
        } catch (\Exception $e) {
            return response()->json([
                'success'=> false,
                'message' => 'Outlet failed to delete!'
            ]);
        }
        return response()->json([
            'success'=> true,
            'message' => 'Outlet deleted'
        ]);
    }
}
