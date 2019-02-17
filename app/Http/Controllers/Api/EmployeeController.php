<?php

namespace App\Http\Controllers\Api;

use App\Events\EmployeeRegistered;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeController extends Controller
{

    use AuthenticatedUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $employees = $this->user->shop->employees()->withTrashed()->get();
        return UserResource::collection($employees);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *ord
     * @param StoreEmployeeRequest $request
     * @return UserResource
     */
    public function store(StoreEmployeeRequest $request)
    {
        $shop = $this->user->shop;
        $user = User::create($request->all());
        $employee = $shop->employees()->save($user, [
            'role_id' => Role::getRoleIdByName(Role::CASHIER),
            'shop_id' => $shop->id,
            'shop_outlet_id' => $request->shop_outlet_id
        ]);

        event(new EmployeeRegistered($employee, $shop, $request->shop_outlet_id, $request->get('password')));
        return new UserResource($employee);
    }

    /**
     * Display the specified resource.
     *
     * @param User $employee
     * @return UserResource
     */
    public function show(User $employee)
    {
        return new UserResource($employee);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $employee
     * @return UserResource
     */
    public function update(Request $request, User $employee)
    {
        $shop = $this->user->shop;
        $user = tap($employee)->update($request->all())->fresh();

        $user->roles()->updateExistingPivot(Role::getRoleIdByName(Role::CASHIER), [
            'shop_outlet_id' => $request->get('shop_outlet_id')
        ]);

        return new UserResource($user);
    }

    /**
     * Deactivate Employee.
     *
     * @param User $employee
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $employee)
    {
        if ($employee->trashed()) {
            return response()->json([
                'success'=> false,
                'message' => 'Employee already Deactivated'
            ]);
        }

        $employee->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Employee deactivated'
        ]);
    }

    public function restore(User $employee)
    {
        if (!$employee->trashed()) {
            return response()->json([
                'success'=> false,
                'message' => 'Employee already Active'
            ]);
        }

        $employee->restore();

        return response()->json([
            'success'=> true,
            'message' => 'Employee re-Activated'
        ]);
    }
}
