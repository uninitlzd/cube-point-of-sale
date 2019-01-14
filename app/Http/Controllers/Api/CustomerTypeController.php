<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreCustomerTypeRequest;
use App\Http\Resources\CustomerTypeResource;
use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerTypeController extends Controller
{
    private $shop;
    private $user;
    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    public function index()
    {
        $types = CustomerType::get();

        return CustomerTypeResource::collection($types);
    }

    public function show(CustomerType $customerType)
    {
        return new CustomerTypeResource($customerType);
    }

    public function store(StoreCustomerTypeRequest $request)
    {
        $customerType = CustomerType::create($request->all());

        return new CustomerTypeResource($customerType);
    }

    public function update(Request $request, CustomerType $customerType)
    {
        $customerType = tap($customerType)->update($request->all())->fresh();

        return new CustomerTypeResource($customerType);
    }


    public function destroy(CustomerType $customerType)
    {
        $customerType->delete();

        return response()->json([
            'success'=> true,
            'message' => 'CustomerType deleted'
        ]);
    }
}
