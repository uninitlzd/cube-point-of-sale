<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReportPerOutletResource;
use App\Http\Resources\SellingReportResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShopOutlet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class IncomeReportingController extends Controller
{
    use AuthenticatedUser;

    public function sellingReport()
    {
        $outlets = $this->user->shop->outlets->pluck('id');

        $selling = QueryBuilder::for(Order::whereIn('shop_outlet_id', $outlets))
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->select(
                'product_id',
                DB::raw('
                                    sum(order_details.quantity) as quantity_sum, 
                                    sum(order_details.quantity) * order_details.selling_price as selling_price_sum,
                                    sum(order_details.quantity) * products.purchase_price as purchase_price_sum,
                                    sum(order_details.quantity) * order_details.selling_price - sum(order_details.quantity) * products.purchase_price as gross_profit')
            )
            ->groupBy('order_details.product_id')
            ->allowedFilters(Filter::scope('created_in_month'))
            ->allowedSorts('gross_profit', 'quantity_sum')
            ->get();

        $sellingReport = new SellingReportResource($selling);
        $sellingReport->totalGrossProfit($selling->sum('gross_profit'));
        $sellingReport->totalProductSold($selling->sum('quantity_sum'));
        $sellingReport->mostSelling($selling->sortByDesc('quantity_sum')->first());
        $sellingReport->leastSelling($selling->sortBy('quantity_sum')->first());

        return $sellingReport;
    }

    public function sellingReportSummary()
    {
        return collect($this->sellingReport())->except('data');
    }

    public function sellingReportPerOutlet()
    {
        $outlets = $this->user->shop->outlets;
        $outlets = QueryBuilder::for(ShopOutlet::whereIn('id', $outlets->pluck('id')));
        $outlets->allowedFilters(Filter::exact('id'));
        $outlets = $outlets->get();

            $outlets->load(['orders' => function ($query) {
            $query->join('order_details', 'orders.id', '=', 'order_details.order_id');
            $query->join('products', 'products.id', '=', 'order_details.product_id');
            $query->select(
                'product_id', 'shop_outlet_id',
                DB::raw('
                                    sum(order_details.quantity) as quantity_sum, 
                                    sum(order_details.quantity) * order_details.selling_price as selling_price_sum,
                                    sum(order_details.quantity) * products.purchase_price as purchase_price_sum,
                                    sum(order_details.quantity) * order_details.selling_price - sum(order_details.quantity) * products.purchase_price as gross_profit')
            );
            $query->groupBy('order_details.product_id', 'orders.shop_outlet_id');
        }]);

        return ReportPerOutletResource::collection($outlets);
    }

    public function sellingReportPerOutletSummary()
    {
        return collect($this->sellingReportPerOutlet())->map(function ($e) {
            return collect($e)->except('orders');
        });
    }
}