<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Money;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Member;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductStock;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $outletIds = $this->user->shop->outlets->pluck('id');
        $orders = Order::whereIn('shop_outlet_id', $outletIds);
        $orders = QueryBuilder::for($orders)
                    ->allowedIncludes('details')
                    ->get();

        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return OrderResource
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order($request->except('order_details'));

        $order->fill([
            'employee_id' => $this->user->id,
            'customer_name' => (!is_null($request->get('member_id')))
                ? Member::find($request->get('member_id'))->name
                : $request->get('member_id'),
            'transaction_type_id' => (!is_null($request->get('member_id')))
                ? 2
                : $request->get('transaction_type_id'),
            'order_total' => $request->get('order_total'),
            'tax' => $request->get('tax'),
            'total' => $request->get('order_total') + $request->get('tax')
        ]);

        $transactionType = TransactionType::find($order->transaction_type_id);
        $discountByTransactionType = $transactionType->discount_percentage;

        $orderDetails = collect($request->get('order_details'));
        $orderDetailsTotal = $orderDetails->pluck('sub_total')->sum() * ((100 - $discountByTransactionType) / 100);
        $orderDetailsTotalAfterTax = $orderDetailsTotal * ($this->user->shop->tax / 100);

        if ($order->order_total != $orderDetailsTotal) {
            return response()->json([
                'success' => false,
                'message' => 'Price total calculation not same with input'
            ], 400);
        }

        if ($order->tax != $orderDetailsTotalAfterTax) {
            return response()->json([
                'success' => false,
                'message' => 'Tax calculation not same with input'
            ], 400);
        }

        $newOrder = tap($order)->save();

        foreach ($orderDetails as $detail) {
            $productStock = ProductStock::where('shop_outlet_id', $order->shop_outlet_id)
                                ->where('product_id', $detail['product_id'])
                                ->first();

            if ($productStock->product->stockable && $productStock->number_of_stock != 0)
                $productStock->number_of_stock = $productStock->number_of_stock - $detail['quantity']; //Todo: Create servic

            $productStock->save();

            $order->details()->save(new OrderDetail($detail));
        }

        $newOrder->load('details');
        $newOrder->load('transactionType');

        return new OrderResource($newOrder);
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return OrderResource
     */
    public function show(Order $order)
    {
        $order = Order::where('id', $order->id);
        $result = QueryBuilder::for($order)
            ->allowedIncludes('details', 'transaction_type')
            ->first();

        return new OrderResource($result);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Order $order
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Order $order)
    {
        $order->details()->delete();
        $order->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Order deleted'
        ]);
    }
}
