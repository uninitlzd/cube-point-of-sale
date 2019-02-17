<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ReportPerOutletResource;
use App\Http\Resources\SellingReportResource;
use App\Mail\DailySellingReport;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShopOutlet;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class IncomeReportingController extends Controller
{
    use AuthenticatedUser;

    public function sellingReport($user = null)
    {
        if ($user === null) {
            $outlets = $this->user->shop->outlets->pluck('id');
        } else {
            $outlets = $user->shop->whereHas('outlets')->pluck('id');
        }

        $selling = QueryBuilder::for(Order::whereIn('shop_outlet_id', $outlets))
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->select(
                'product_id', 'products.name',
                DB::raw('
                                    sum(order_details.quantity) as quantity_sum, 
                                    sum(order_details.quantity) * order_details.selling_price as selling_price_sum,
                                    sum(order_details.quantity) * products.purchase_price as purchase_price_sum,
                                    sum(order_details.quantity) * order_details.selling_price - sum(order_details.quantity) * products.purchase_price as gross_profit')
            )
            ->groupBy('order_details.product_id')
            ->allowedFilters(Filter::scope('created_in_month'), Filter::scope('created_in_a_date'))
            ->allowedSorts('gross_profit', 'quantity_sum')
            ->get();

        $sellingReport = new SellingReportResource($selling);
        $sellingReport->totalGrossProfit($selling->sum('gross_profit'));
        $sellingReport->totalProductSold($selling->sum('quantity_sum'));
        $sellingReport->mostSelling($selling->sortByDesc('quantity_sum')->first());
        $sellingReport->leastSelling($selling->sortBy('quantity_sum')->first());

        return $sellingReport;
    }

    public function sellingReportInADate($date, $user = null)
    {
        if ($user === null) {
            $outlets = $this->user->shop->outlets->pluck('id');
        } else {
            $outlets = $user->shop->outlets->pluck('id');
        }

        $selling = Order::whereIn('shop_outlet_id', $outlets)
            ->join('order_details', 'orders.id', '=', 'order_details.order_id')
            ->join('products', 'products.id', '=', 'order_details.product_id')
            ->select(
                'product_id', 'products.name',
                DB::raw('
                                    sum(order_details.quantity) as quantity_sum, 
                                    sum(order_details.quantity) * order_details.selling_price as selling_price_sum,
                                    sum(order_details.quantity) * products.purchase_price as purchase_price_sum,
                                    sum(order_details.quantity) * order_details.selling_price - sum(order_details.quantity) * products.purchase_price as gross_profit')
            )
            ->groupBy('order_details.product_id')
            ->whereDate('orders.created_at', $date)
            ->get();

        $sellingReport = new SellingReportResource($selling);
        $sellingReport->totalGrossProfit($selling->sum('gross_profit'));
        $sellingReport->totalProductSold($selling->sum('quantity_sum'));
        $sellingReport->mostSelling($selling->sortByDesc('quantity_sum')->first());
        $sellingReport->leastSelling($selling->sortBy('quantity_sum')->first());

        return collect($sellingReport)->except('data');
    }

    public function sellingReportSummary($user = null)
    {
        return collect($this->sellingReport($user))->except('data');
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

    public function getReport()
    {
        $now = Carbon::now()->firstOfMonth();
        $end = Carbon::now()->lastOfMonth();

        $reports = collect();

        foreach (CarbonPeriod::create($now, $end)->toArray() as $date) {
            $reports->push(collect([
                'date' => $date->format('d M')
            ])->merge($this->sellingReportInADate($date)));
        }

        return $reports;
    }

    public function userDailyReport()
    {
        $users = User::with(['roles', 'shop'])->whereHas('roles', function ($query) {
            return $query->where('name', 'owner');
        })->whereHas('shop')->get();

        $users->map(function ($user)  {
            $report = $this->sellingReportInADate(Carbon::now(), $user);
            Mail::to($user)->queue(new DailySellingReport($user, $report));
        });
    }
}
