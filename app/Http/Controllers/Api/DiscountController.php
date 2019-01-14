<?php

namespace App\Http\Controllers\Api;

use App\Models\Discount;
use App\Http\Requests\DiscountStoreRequest;
use App\Http\Resources\DiscountResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class DiscountController extends Controller
{
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\ResourceCollection
     */
    public function index()
    {
        $discounts = Discount::where('shop_id', $this->user->shop->id);

        $result = QueryBuilder::for($discounts)
            ->allowedIncludes('products')
            ->get();

        return DiscountResource::collection($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DiscountStoreRequest $request
     * @return DiscountResource
     */
    public function store(DiscountStoreRequest $request)
    {
        $discount = $this->user->shop->discounts()->save(new Discount($request->all()));
        return new DiscountResource($discount);
    }

    /**
     * Display the specified resource.
     *
     * @param Discount $discount
     * @return DiscountResource
     */
    public function show(Discount $discount)
    {
        $discount = Discount::where('id', $discount->id);
        $result = QueryBuilder::for($discount)
                ->allowedIncludes('products')
                ->first();

        return new DiscountResource($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Discount $discount
     * @return DiscountResource
     */
    public function update(Request $request, Discount $discount)
    {
        return new DiscountResource(tap($discount)
            ->update($request->all())
            ->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Discount $discount
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Discount deleted'
        ]);
    }
}
