<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreMaterialRequest;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
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
        $materials = $this->user->shop->materials;
        return MaterialResource::collection($materials);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMaterialRequest $request
     * @return MaterialResource
     */
    public function store(StoreMaterialRequest $request)
    {
        $shop = $this->user->shop;
        $material = new Material($request->all());

        return new MaterialResource($shop->materials()->save($material));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Material  $material
     * @return MaterialResource
     */
    public function show(Material $material)
    {
        return new MaterialResource($material);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Material  $material
     * @return MaterialResource
     */
    public function update(Request $request, Material $material)
    {
        return new MaterialResource(tap($material)
            ->update($request->all())
            ->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Material $material
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Material $material)
    {
        $material->delete();

        return response()->json([
            'success'=> true,
            'message' => 'Material deleted'
        ]);
    }
}
