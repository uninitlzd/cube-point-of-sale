<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SellingReportResource extends ResourceCollection
{

    public $totalGrossProfit;
    public $totalProductSold;
    public $mostSelling;
    public $leastSelling;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($report) {
                return $report;
            }),
            'total_gross_profit'=> $this->when(!is_null($this->totalGrossProfit), $this->totalGrossProfit),
            'total_product_sold'=> $this->when(!is_null($this->totalProductSold), $this->totalProductSold),
            'most_selling'=> $this->when(!is_null($this->totalGrossProfit), $this->mostSelling),
            'least_selling'=> $this->when(!is_null($this->leastSelling), $this->leastSelling)
        ];
    }

    public function totalGrossProfit($totalGrossProfit) {
        $this->totalGrossProfit = $totalGrossProfit;
        return $this;
    }

    public function totalProductSold($totalProductSold) {
        $this->totalProductSold = $totalProductSold;
        return $this;
    }

    public function mostSelling($mostSelling) {
        $this->mostSelling = $mostSelling;
        return $this;
    }

    public function leastSelling($leastSelling) {
        $this->leastSelling = $leastSelling;
        return $this;
    }
}
